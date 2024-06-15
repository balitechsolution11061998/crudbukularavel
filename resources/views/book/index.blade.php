<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="#">Library</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#"></a>
                </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1>Welcome, {{ Auth::user()->name }}</h1>
    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="tambahBuku()">
        <i class="fas fa-plus"></i> Add Book
    </button>

    <!-- DataTable -->
    <table id="books-table" class="table table-striped mt-4">
        <thead>
        <tr style="background-color: blue; color: white;">
            <th>ID</th>
            <th>Kode Buku</th>
            <th>ISBN</th>
            <th>Judul Buku</th>
            <th>Pengarang</th>
            <th>Sekilas Isi</th>
            <th>Tanggal Masuk</th>
            <th>Stock</th>
            <th>Foto</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <!-- Data will be loaded dynamically using DataTables -->
        </tbody>
    </table>
</div>

<!-- Modal for Add Book -->
<div class="modal fade" id="mdlBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a book -->
                <form id="add-book-form">
                    @csrf
                    <input type="hidden" class="form-control" id="id" name="id">

                    <div class="mb-3">
                        <label for="title" class="form-label">Kode Buku</label>
                        <input type="text" class="form-control" id="kode_buku" name="kode_buku">
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn">
                    </div>
                    <div class="mb-3">
                        <label for="judul_buku" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="judul_buku" name="judul_buku">
                    </div>
                    <div class="mb-3">
                        <label for="pengarang" class="form-label">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang">
                    </div>
                    <div class="mb-3">
                        <label for="sekilas_isi" class="form-label">Sekilas Isi</label>
                        <input type="text" class="form-control" id="sekilas_isi" name="sekilas_isi">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock" name="stock">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('books.data') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'kode_buku', name: 'kode_buku'},
                    {data: 'isbn', name: 'isbn'},
                    {data: 'judul_buku', name: 'judul_buku'},
                    {data: 'pengarang', name: 'pengarang'},
                    {data: 'sekilas_isi', name: 'sekilas_isi'},
                    {data: 'tanggal_masuk', name: 'tanggal_masuk'},
                    {data: 'stock', name: 'stock'},
                    {
                        data: 'foto',
                        name: 'foto',
                        render: function (data, type, row) {
                            return '<img src="' + data + '" alt="Book Photo" style="max-width:100px; max-height:100px;">';
                        }
                    },
                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            var editButton = '<a class="btn btn-primary btn-sm edit-button" data-id="' + row.id + '" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-edit"></i> Edit</a>';
                            var deleteButton = '<a class="btn btn-danger btn-sm delete-button ml-2" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</a>';
                            return editButton + deleteButton;
                        }
                    },
                ]
            });

          // Handle click event for edit button
            $('#books-table').on('click', '.edit-button', function () {
                var bookId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to edit this book?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, edit it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/books/' + bookId, // Assuming your route for fetching book details is '/books/{id}'
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                // Update modal content with book details
                                $('#id').val(response.book.id);
                                $('#kode_buku').val(response.book.kode_buku);
                                $('#isbn').val(response.book.isbn);
                                $('#judul_buku').val(response.book.judul_buku);
                                $('#pengarang').val(response.book.pengarang);
                                $('#sekilas_isi').val(response.book.sekilas_isi);
                                $('#tanggal_masuk').val(response.book.tanggal_masuk);
                                $('#tanggal_masuk').val(response.book.tanggal_masuk);
                                $('#stock').val(response.book.stock);
                                // Update other fields as needed

                                // Show the modal
                                $('#mdlBook').modal('show');
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

        // Handle form submission for adding a book
        $('#add-book-form').submit(function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to add this book?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData(this); // Create FormData object
                $.ajax({
                    url: "{{ route('books.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false, // Important: Don't process the data
                    contentType: false, // Important: Don't set contentType
                    success: function(response) {
                        $('#mdlBook').modal('hide');
                        $('#books-table').DataTable().ajax.reload();
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            timer: 3000
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to add book. Please try again later.',
                            icon: 'error',
                            timer: 3000
                        });
                    }
                });
            }
        });
    });


    var csrfToken = $('meta[name="csrf-token"]').attr('content');

$('#books-table').on('click', '.delete-button', function () {
    var bookId = $(this).data('id');
    if (confirm('Are you sure you want to delete this book?')) {
        $.ajax({
            url: '/books/destroy',
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
            },
            data:{
                'id':bookId
            },
            success: function(response) {
                $('#books-table').DataTable().ajax.reload();
            }
        });
    }
});


    });
    function tambahBuku(){
            $('#mdlBook').modal('show');
        }
</script>
</body>
</html>
