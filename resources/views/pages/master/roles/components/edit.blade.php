<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit" aria-labelledby="offcanvasEditLabel"
    data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasEditLabel">
            <div>
                <h5 class="fs-16 fw-bold">
                    Edit Role
                </h5>
                <small class="fs-12 text-muted">
                    Edit Role untuk user
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
                    Role
                </label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                    placeholder="Role">
                <div class="invalid-feedback mt-2"></div>
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

@push('scripts')
    <script>
        $(document).on('click', '[data-bs-target="#offcanvasEdit"]', function() {
            var offcanvasEdit = document.getElementById('offcanvasEdit');

            $('#loadingIndicator').show();
            $('#formEdit').hide();
            $('#submitUpdate').attr('disabled', true);

            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('roles.show', '') }}" + '/' + id,
                type: 'GET',
                success: function(response) {
                    let data = response.data;

                    $('#offcanvasEdit').find('#id').val(data.id);
                    $('#offcanvasEdit').find('#name').val(data.name);

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
                        _token: $('input[name="_token"]').val()
                    };

                    var resetForm = () => {
                        $('#offcanvasEdit').find('#name').val('').removeClass('is-invalid')
                            .siblings('.invalid-feedback').html('');
                    };

                    $.ajax({
                        url: "{{ route('roles.update', '') }}" + '/' + formData.id,
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
