@extends('layouts.app')

@section('content')
    <form action="{{ route('change-password.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xxl-3">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                <img src="{{ $user->profile ? $user->profile->avatar : asset('assets/images/users/user-dummy-img.jpg') }}"
                                    class="rounded-circle avatar-xl img-thumbnail profile-img  shadow" id="profile-img"
                                    alt="profile-img">
                            </div>
                            <h5 class="fs-16 mb-1">
                                {{ ucfirst($user->name) }}
                            </h5>
                            <p class="text-muted mb-0">
                                {{ ucfirst($user->roles->first()->name) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-9">
                <div class="card">
                    <div class="card-header">
                        @include('pages.profile.partials.tabs')
                    </div>
                    <div class="card-body p-4">
                        <!-- Warning Alert -->
                        <div class="alert alert-warning alert-dismissible alert-label-icon rounded-label shadow fade show"
                            role="alert">
                            <i class="ri-alert-line label-icon"></i>
                            Password harus terdiri dari minimal 6 karakter, mengandung huruf besar, huruf kecil, angka dan
                            karakter khusus.
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <label class="form-label" for="password-input">
                                    Password Lama
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input"
                                        placeholder="Password Lama" id="password-input" name="password_old">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                </div>
                                @error('password_old')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label" for="password-input">
                                    Password Baru
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input"
                                        placeholder="Password Baru" id="password-input" name="password">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label" for="password-input">
                                    Konfirmasi Password Baru
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input"
                                        placeholder="Ulangi Password Baru" id="password-input" name="password_confirmation">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="mt-2">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>



                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    Update
                                </button>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
@endpush
