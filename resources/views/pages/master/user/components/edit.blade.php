<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit" aria-labelledby="offcanvasEditLabel"
    data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasEditLabel">
            <div>
                <h5 class="fs-16 fw-bold">
                    Edit User
                </h5>
                <small class="fs-12 text-muted">
                    Edit User yang sudah terdaftar
                </small>
            </div>
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Loading Indicator -->
        <div id="loadingIndicator"
            style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <form action="javascript:void(0)" id="formEdit">
            @csrf
            <input type="hidden" name="id" id="id">
            <div class="mb-3">
                <label class="form-label">
                    Email
                </label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}"
                    placeholder="Email user" readonly>
                <div class="invalid-feedback mt-2"></div>
            </div>
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
                    Role
                </label>
                <select class="js-example-basic-single" name="role" id="role">
                    <option></option>
                    @foreach ($role as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="offcanvas-foorter border p-3 text-center">
        <div class="gap-2 d-flex align-items-center">
            <button type="submit" id="submitUpdate" class="btn btn-primary w-50">
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
    <script>
        $(document).on('click', '[data-bs-target="#offcanvasEdit"]', function() {
            var offcanvasEdit = document.getElementById('offcanvasEdit');

            offcanvasEdit.addEventListener('shown.bs.offcanvas', function() {
                $('#offcanvasEdit').find('#role').select2({
                    dropdownParent: $('#offcanvasEdit'),
                    placeholder: 'Pilih Role',
                });
            });

            $('#loadingIndicator').show();
            $('#formEdit').hide();
            $('#submitUpdate').attr('disabled', true);

            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('users.show', '') }}" + '/' + id,
                type: 'GET',
                success: function(response) {
                    let data = response.data;

                    $('#offcanvasEdit').find('#id').val(data.id);
                    $('#offcanvasEdit').find('#name').val(data.name);
                    $('#offcanvasEdit').find('#email').val(data.email);
                    $('#offcanvasEdit').find('#role').val(data.role).trigger('change');

                    $('#loadingIndicator').hide();
                    $('#formEdit').show();
                    $('#submitUpdate').attr('disabled', false);
                },
                error: function(xhr) {
                    let error = xhr.responseJSON;
                    Swal.fire({
                        title: 'Error!',
                        text: error.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            $(document).ready(function() {
                $('#submitUpdate').on('click', function() {
                    var formData = {
                        id: $('#offcanvasEdit').find('#id').val(),
                        name: $('#offcanvasEdit').find('#name').val(),
                        role: $('#offcanvasEdit').find('#role').val(),
                        _token: $('input[name="_token"]').val()
                    };

                    var resetForm = () => {
                        $('#offcanvasEdit').find('#name').val('').removeClass('is-invalid')
                            .siblings('.invalid-feedback').html('');
                        $('#offcanvasEdit').find('#role').val('').removeClass('is-invalid')
                            .siblings('.invalid-feedback').html('');
                    };

                    $.ajax({
                        url: "{{ route('users.update', '') }}" + '/' + formData.id,
                        type: 'PUT',
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

                            resetForm();
                            $('#offcanvasEdit').offcanvas('hide');
                            $('#datatables').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            let error = response.responseJSON;

                            if (error.errors) {
                                if (error.errors.name) {
                                    $('#offcanvasEdit').find('#name').addClass(
                                            'is-invalid')
                                        .siblings('.invalid-feedback').html(error.errors
                                            .name);
                                }

                                if (error.errors.role) {
                                    $('#offcanvasEdit').find('#role').addClass(
                                            'is-invalid')
                                        .siblings('.invalid-feedback').html(error.errors
                                            .role);
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


                })
            })
        });
    </script>
@endpush
