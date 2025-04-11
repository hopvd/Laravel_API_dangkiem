@extends('admin.main')

@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Bien so xe</th>
                    <th scope="col">Khu vuc</th>
                    <th scope="col">Hang san xuat</th>
                    <th scope="col">Nam san xuat</th>
                    <th scope="col">Ten xe</th>
                    <th scope="col">Muc dich su dung</th>
                    <th scope="col">Ten chu so huu</th>
                    <th scope="col">Hanh dong</th>
                </tr>
                </thead>
                <tbody>
                @foreach($vehicles as $row)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $row->license_plate }}</td>
                        <td>{{ $row->location }}</td>
                        <td>{{ $row->company }}</td>
                        <td>{{ $row->produce_year }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->purpose_to_use }}</td>
                        <td>{{ $row->owner_id }}</td>
                        <td>
                            <a href="" class="badge bg-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a onclick="return confirm('Are you sure?')" href="" class="badge bg-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>

        </div><!-- /.container-fluid -->
    </section>

@endsection
