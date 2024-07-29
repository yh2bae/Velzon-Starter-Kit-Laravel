@extends('layouts.app')

@section('content')
    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-xxl-3">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                <img src="{{ $user->profile ? $user->profile->avatar : asset('assets/images/users/user-dummy-img.jpg') }}"
                                    class="rounded-circle avatar-xl img-thumbnail profile-img  shadow" id="profile-img"
                                    alt="profile-img">
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-image-input" type="file" class="profile-img-file-input"
                                        name="avatar" accept="image/png, image/gif, image/jpeg">
                                    <label for="profile-image-input" class="profile-photo-edit avatar-xs"
                                        data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Pilih file gambar"
                                        data-bs-original-title="Pilih file gambar">
                                        <span class="avatar-title rounded-circle bg-light text-body shadow">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                                @error('avatar')
                                    <div class="mt-4">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                @enderror
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
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="input nama bisnis"
                                        value="{{ $user->name }}">
                                    @error('name')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Input email" value="{{ $user->email }}" disabled>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" placeholder="Input alamat"
                                        value="{{ $user->profile->address ?? '' }}">
                                    @error('address')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">No.Telp</label>
                                    <input type="text" inputmode="numeric"
                                        class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        name="phone" placeholder="Input No.Telp"
                                        value="{{ $user->profile->phone ?? '' }}">
                                    @error('phone')
                                        <div class="mt-2">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->

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
    <script>
        $(document).ready(function() {
            $('input[name="phone"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            document.querySelector("#profile-image-input").addEventListener("change",
                function() {
                    var e = document.querySelector("#profile-img"),
                        t = document.querySelector("#profile-image-input").files[0],
                        o = new FileReader;
                    o.addEventListener("load", function() {
                        e.src = o.result
                    }, !1), t && o.readAsDataURL(t)
                });
        });
    </script>
@endpush
