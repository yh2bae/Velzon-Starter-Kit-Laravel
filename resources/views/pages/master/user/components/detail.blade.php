<!-- Default Modals -->
<div id="modalDetail" class="modal zoomIn" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">
                    Detail User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                {{-- avatar --}}
                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                    <img src=""
                        class="rounded-circle avatar-xl img-thumbnail profile-img  shadow" id="avatar"
                        alt="profile-img">
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <td id="name"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="email"></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td id="role"></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td id="phone"></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td id="address"></td>
                    </tr>
                    <tr>
                        <th>Register</th>
                        <td id="created_at"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#modalDetail').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                $.ajax({
                    url: "{{ route('users.show', '') }}" + '/' + id,
                    type: 'GET',
                    success: function(response) {
                        let data = response.data;

                        modal.find('#name').text(data.name);
                        modal.find('#email').text(data.email);
                        modal.find('#role').text(data.role);
                        modal.find('#phone').text(data.phone ?? '-');
                        modal.find('#address').text(data.address ?? '-');
                        modal.find('#avatar').attr('src', data.avatar);
                        modal.find('#created_at').text(data.created_at);
                    },
                    error: function(xhr) {
                        let error = response.responseJSON;
                        Swal.fire({
                            title: 'Error!',
                            text: error.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endpush
