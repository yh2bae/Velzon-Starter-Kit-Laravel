<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAdd" aria-labelledby="offcanvasAddLabel"
    data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasAddLabel">
            <div>
                <h5 class="fs-16 fw-bold">
                    Tambah Permission Baru
                </h5>
                <small class="fs-12 text-muted">
                    Permission Baru untuk user
                </small>
            </div>
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="javascript:void(0)">
            @csrf
            <div class="mb-3">
                <label class="form-label">
                    Permission
                </label>
                <input class="form-control" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Nama permission">
                <div class="invalid-feedback mt-2"></div>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Module
                </label>
                <input type="text" id="module_name" name="module_name" class="form-control" value="{{ old('module_name') }}"
                    placeholder="Module">
                <div class="invalid-feedback mt-2"></div>
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


@push('scripts')

    <script>
        $(document).ready(function() {
            var offcanvasAdd = document.getElementById('offcanvasAdd');

            $('#submitAdd').on('click', function(event) {
                event.preventDefault();

                var formData = {
                    name: $('#name').val(),
                    module_name: $('#module_name').val(),
                    _token: $('input[name="_token"]').val()
                };

                const resetForm = () => {
                    $('#name, #module_name').val('').removeClass(
                        'is-invalid').siblings('.invalid-feedback').html('');
                };

                $.ajax({
                    url: "{{ route('permissions.store') }}",
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

                            if (error.errors.module_name) {
                                $('#module_name').addClass('is-invalid').siblings('.invalid-feedback')
                                    .html(error.errors.module_name);
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
