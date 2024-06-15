<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-wJC4W5oEhAn5FZH5DU4G4P7P28dZV5R8+4iVqBRIjn1pJTBc+/Aa/HpuXlSx2vHgFuAZpXzOxO5dzqwTEFxEIg==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

</head>
<body class="antialiased">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card" style="padding: 20px;">
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-6">
                            <!-- Your content here -->
                        </div>
                        <div class="col-md-6" style="float:right;text-align:right;">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm"><i class="fas fa-sign-in-alt"></i>Sign In</a>
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                            <table id="books-table" class="table table-striped">
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
                                    </tr>
                                </thead>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('books.datas') }}",
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

                ]
            });
        });
    </script>

</body>
</html>
