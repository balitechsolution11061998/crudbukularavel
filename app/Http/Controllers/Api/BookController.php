<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        try {
            $books = Book::select('*')->get();
            return response()->json([
                'success' => true,
                'message' => "Succcess load data buku",
                'data' => $books
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store or update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            if ($request->id) {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $book = Book::findOrFail($id); // Find the book by ID
            return response()->json(['success' => true, 'book' => $book]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id); // Find the book by ID
            $book->delete(); // Delete the book
            return response()->json(['success' => true, 'message' => 'Book deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
