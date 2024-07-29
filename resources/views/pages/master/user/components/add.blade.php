<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAdd" aria-labelledby="offcanvasAddLabel"
    data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasAddLabel">
            <div>
                <h5 class="fs-16 fw-bold">
                    Tambah User Baru
                </h5>
                <small class="fs-12 text-muted">
                    Tambah User Baru untuk aplikasi
                </small>
            </div>
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="alert alert-warning alert-dismissible alert-label-icon rounded-label shadow fade show"
            role="alert">
            <i class="ri-alert-line label-icon"></i>
            Password harus terdiri dari minimal 6 karakter, mengandung huruf besar, huruf kecil, angka dan
            karakter khusus.
        </div>
        <form action="javascript:void(0)">
            @csrf
            <div class="mb-3">
                <label class="form-label">
                    Nama
                </label>
                <input class="form-control" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Nama user">
                <div class="invalid-feedback mt-2"></div>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Email
                </label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}"
                    placeholder="Email user">
                <div class="invalid-feedback mt-2"></div>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Role
                </label>
                <select class="js-example-basic-single" name="role" id="role">
                    <option></option>
                    @foreach ($role as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback mt-2"></div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password-input">
                    Password
                </label>
                <div class="position-relative auth-pass-inputgroup mb-3">
                    <input type="password" class="form-control pe-5 password-input" placeholder="Password"
                        id="password" name="password">
                    <button
                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                        type="button" id="password-addon">
                        <i class="ri-eye-fill align-middle"></i>
                    </button>
                    <div class="invalid-feedback mt-2"></div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password-input">
                    Konfirmasi Password
                </label>
                <div class="position-relative auth-pass-inputgroup mb-3">
                    <input type="password" class="form-control pe-5 password-input" placeholder="Ulangi Password"
                        id="password_confirmation" name="password_confirmation">
                    <button
                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                        type="button" id="password-addon">
                        <i class="ri-eye-fill align-middle"></i>
                    </button>
                    <div class="invalid-feedback mt-2"></div>
                </div>
            </div>

        </form>
    </div>
    <div class="offcanvas-foorter border p-3 text-center">
        <div class="gap-2 d-flex align-items-center">
            <button type="submit" id="submitAdd" class="btn btn-primary w-50">
                Simpan
            </button>
            <a href="javascript:void(0);" class="btn btn-danger w-50" data-bs-dismiss="offcanvas">
                Batal
            </a>
        </div>
    </div>
</div>

@push('css')
    <link href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>

    <script>
        $(document).ready(function() {
            var offcanvasAdd = document.getElementById('offcanvasAdd');

            offcanvasAdd.addEventListener('shown.bs.offcanvas', function() {
                $('#role').select2({
                    dropdownParent: $('#offcanvasAdd'),
                    placeholder: 'Pilih role',
                });
            });

            $('#submitAdd').on('click', function(event) {
                event.preventDefault();

                var formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    role: $('#role').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val(),
                    _token: $('input[name="_token"]').val()
                };

                const resetForm = () => {
                    $('#name, #email, #role, #password, #password_confirmation').val('').removeClass(
                        'is-invalid').siblings('.invalid-feedback').html('');
                };

                $.ajax({
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
                            buttonsStyling: false,
                            showCloseButton: true
                        });

                        $('#datatables').DataTable().ajax.reload();
                        $('#offcanvasAdd').offcanvas('hide');
                        resetForm();
                    },
                    error: function(response) {
                        let error = response.responseJSON;

                        if (error.errors) {
                            if (error.errors.name) {
                                $('#name').addClass('is-invalid').siblings('.invalid-feedback')
                                    .html(error.errors.name);
                            }

                            if (error.errors.email) {
                                $('#email').addClass('is-invalid').siblings('.invalid-feedback')
                                    .html(error.errors.email);
                            }

                            if (error.errors.role) {
                                $('#role').addClass('is-invalid').siblings('.invalid-feedback')
                                    .html(error.errors.role);
                            }

                            if (error.errors && error.errors.password) {
                                $('#password').closest('.position-relative').find(
                                        '.invalid-feedback')
                                    .html(error.errors.password).show();
                            }

                            if (error.errors && error.errors.password_confirmation) {
                                $('#password_confirmation').closest('.position-relative').find(
                                        '.invalid-feedback')
                                    .html(error.errors.password_confirmation).show();
                            }
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: error.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
