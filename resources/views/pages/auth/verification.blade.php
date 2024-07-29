@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h3 class="text-primary">Verifikasi Email</h3>

                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c"
                            class="avatar-xl">
                        </lord-icon>

                    </div>
                    <div class="text-center mt-2">
                        <p class="text-muted">
                            Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi. <br>
                            Jika Anda tidak menerima email, klik di bawah ini untuk mengirim ulang.
                        </p>
                    </div>

                    <div class="alert border-0 alert-info text-center mb-2 mx-2" role="alert">
                        email verifikasi telah dikirim ke email Anda {{ Auth::user()->email }}
                    </div>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="mt-5">
                            <button type="submit" class="btn btn-lg btn-primary w-100">
                                Klik disini untuk mengirim ulang
                            </button>
                        </div>
                    </form>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->


        </div>
    </div>
@endsection
