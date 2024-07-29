@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">
                            Selamat Datang Kembali !
                        </h5>
                        <p class="text-muted">
                            Masuk ke akun Anda untuk melanjutkan
                        </p>
                    </div>
                    <div class="p-2 mt-4">
                        @if (session('error'))
                            <h4 class="fs-14 fw-bold text-danger">{{ session('error') }}</h4>
                        @endif
                        <form action="{{ route('login') }}"method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Input email" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <div class="float-end">
                                    <a href="{{ route('forgot-password') }}" class="text-muted">
                                        Lupa Password?
                                    </a>
                                </div>
                                <label class="form-label" for="password-input">Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input"
                                        placeholder="Input password" id="password-input" name="password" required>
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="auth-remember-check"
                                    name="remember">
                                <label class="form-check-label" for="auth-remember-check">
                                    Ingatkan Saya
                                </label>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">
                                    Masuk
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
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline">
                        Daftar Sekarang
                    </a>
                </p>
            </div>

        </div>
    </div>
@endsection
