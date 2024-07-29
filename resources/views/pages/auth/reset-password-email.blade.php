@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">
                           Lupas Password?
                        </h5>
                        <p class="text-muted">
                            Masukkan email Anda untuk mereset password
                        </p>

                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl">
                        </lord-icon>
                    </div>
                    <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                        Masukkan email Anda dan kami akan mengirimkan Anda tautan untuk mereset password Anda
                    </div>
                    <div class="p-2 mt-2">
                        @if (session('error'))
                            <h4 class="fs-14 fw-bold text-danger">{{ session('error') }}</h4>
                        @endif
                        <form action="{{ route('password.email') }}"method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Input email" value="{{ old('email') }}" required>
                            </div>


                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">
                                    Kirim Reset Link
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">
                    Sebentar, saya ingat password saya!
                    <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline">
                        Kembali ke Login
                    </a>
                </p>
            </div>

        </div>
    </div>
@endsection
