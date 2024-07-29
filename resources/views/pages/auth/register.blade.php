@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">
                            Buat akun baru !
                        </h5>
                        <p class="text-muted">
                            Daftar untuk melanjutkan ke aplikasi
                        </p>
                    </div>
                    <div class="p-2 mt-4">
                        @if (session('error'))
                            <h4 class="fs-14 fw-bold text-danger">{{ session('error') }}</h4>
                        @endif
                        <form action="{{ route('register') }}"method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <hr class="border-dashed">
                                <h5 class="fs-15 fw-bold">
                                    Informasi Pribadi
                                </h5>
                                <hr class="border-dashed">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Input nama lengkap"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Input email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="password-input">
                                    Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password"
                                        class="form-control pe-5 password-input"
                                        placeholder="Input Password" id="password-input" name="password">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                                @error('password')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password-input">
                                    Konfirmasi Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input"
                                        placeholder="Ulangi Password" id="password-input" name="password_confirmation">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                                @error('password_confirmation')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" placeholder="Input alamat bisnis"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" placeholder="Input nomor telepon"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-5">
                                <button class="btn btn-success w-100" type="submit">
                                    Daftar
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
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline">
                        Login Sekarang
                    </a>
                </p>
            </div>

        </div>
    </div>
@endsection
