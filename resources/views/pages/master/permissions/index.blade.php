@extends('layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('permission_create')
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAdd" aria-controls="offcanvasAdd">
                        <i class="feather-plus-circle me-2"></i>
                        <span>
                            Tambahan Permission Baru
                        </span>
                    </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table id="datatables" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>
                                Permission
                            </th>
                            <th>
                                Module
                            </th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('pages.master.permissions.components.add')
    @include('pages.master.permissions.components.edit')
@endsection

@push('scripts')
    <script>
        $(function() {
            try {
                $('#datatables').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('permissions') }}",
                    columns: [{
                            data: 'no',
                            name: 'no',
                            searchable: false,
                            orderable: false,
                            width: '5%'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'module_name',
                            name: 'module_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                    ],
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    scrollX: true,
                    fixedHeader: true,
                    scrollY: '80vh',
                    scrollCollapse: true,


                });
            } catch (error) {
                error = error.responseJSON;

                alert(error.message);
            }

            $(document).on('click', '#deleteButton', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                const t = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-primary m-1",
                        cancelButton: "btn btn-danger m-1"
                    },
                    buttonsStyling: !1
                });
                t.fire({
                    title: "Apakah Anda Yakin?",
                    text: "Anda tidak akan dapat mengembalikan data ini!",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Setuju, hapus!",
                    cancelButtonText: "Batal",
                    reverseButtons: !0
                }).then(e => {
                    e.value && $.ajax({
                        url: "{{ route('permissions.destroy', '') }}" + '/' + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            t.fire({
                                title: "Berhasil dihapus!",
                                text: response.message,
                                icon: "success",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });

                            $('#datatables').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            let error = response.responseJSON;

                            t.fire({
                                text: error.message,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    })
                })
            });
        });
    </script>
@endpush
