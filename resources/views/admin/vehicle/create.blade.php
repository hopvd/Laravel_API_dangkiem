@extends('admin.main')

@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <form action="{{route('vehicle.store')}}" method="post">
                @csrf
                <div class="input-group mb-6">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span>Bien so xe:</span>
                        </div>
                    </div>
                    <input type="text" name="license_plate" class="form-control" placeholder="Bien so xe">
                </div>
                <div class="input-group mb-6">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span>Khu vuc:</span>
                        </div>
                    </div>
                    <input type="text" name="location" class="form-control" placeholder="Khu vuc">
                </div>
                <div class="input-group mb-6">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span>Hang san xuat:</span>
                        </div>
                    </div>
                    <input type="text" name="company" class="form-control" placeholder="Hang san xuat">
                </div>
                <div class="input-group mb-6">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span>Nam san xuat:</span>
                        </div>
                    </div>
                    <input type="text" name="produce_year" class="form-control" placeholder="Nam san xuat">
                </div>
                <div class="input-group mb-6">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span>Ten xe:</span>
                        </div>
                    </div>
                    <input type="text" name="name" class="form-control" placeholder="Ten xe">
                </div>
                <div class="input-group mb-6">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span>Muc dich su dung:</span>
                        </div>
                    </div>
                    <input type="text" name="purpose_to_use" class="form-control" placeholder="Muc dich su dung">
                </div>
                <div class="input-group mb-6">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span>Ten chu so huu:</span>
                        </div>
                    </div>
                    <input type="text" name="owner_id" class="form-control" placeholder="Ten chu so huu">
                </div>
                <input type="submit">
            </form>

        </div><!-- /.container-fluid -->
    </section>

@endsection
