<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use DataTables;


class BookController extends Controller
{
    //
    public function index(){
        return view('book.index');
    }

    public function data()
    {
        try {
            $books = Book::select('*');
            return DataTables::of($books)->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function storeOrUpdate(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'kode_buku' => 'required',
            'isbn' => 'required',
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'sekilas_isi' => 'required',
            'tanggal_masuk' => 'required|date',
            'stock' => 'required|numeric',
        ]);

        // Extract the data from the request
        $data = $request->only([
            'kode_buku',
            'isbn',
            'judul_buku',
            'pengarang',
            'sekilas_isi',
            'tanggal_masuk',
            'stock',
        ]);

        try {
            if ($request->hasFile('foto')) {
                // Save the photo to the public folder
                $myimage = $request->foto->getClientOriginalName();
                $destinationPath = public_path('photos'); // Change the folder name as needed
                $request->foto->move($destinationPath, $myimage);

                // Get the URL of the stored photo
                $photoUrl = asset('photos/' . $myimage); // Assuming 'photos' is the folder name
                // Update the data array with the photo URL
                $data['foto'] = $photoUrl;
            }

            // Check if ID is present in the request data
            if ($request->id != null) {
                // Update existing record
                $book = Book::findOrFail($request->id); // Find the book by ID
                $book->update($data); // Update the book with the provided data
                $message = 'Book updated successfully.';
            } else {
                // Insert new record
                $book = Book::create($data); // Create a new book record with the provided data
                $message = 'Book added successfully.';
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $book = Book::findOrFail($id); // Find the book by ID
            // Return JSON response with book data
            return response()->json(['success' => true, 'book' => $book]);
        } catch (\Exception $e) {
            // Return error JSON response
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            // Retrieve the book ID from the request
            $bookId = $request->id;

            // Find the book by ID
            $book = Book::findOrFail($bookId);

            // Delete the book
            $book->delete();

            // Return a success JSON response
            return response()->json(['success' => true, 'message' => 'Book deleted successfully']);
        } catch (\Exception $e) {
            // Return an error JSON response
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
