@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="mb-3">
                <label for="role" class="form-label">
                    Role
                </label>
                <input type="text" class="form-control" id="role" name="role" value="{{ $role->name }}" readonly>
            </div>
        </div>
    </div>

    <!-- Base Switch -->
    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault">
            Centang Semua atau Hapus centang Semua
        </label>
    </div>

    <form action="{{ route('roles.permissions.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="height: 60vh; overflow-y: auto;">
            @foreach ($modulePermissions as $moduleName => $permissions)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ $moduleName }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach ($permissions as $permission)
                            <div class="form-check form-check-outline form-check-primary mb-3">
                                <input class="form-check-input permission-checkbox" type="checkbox"
                                    id="permission{{ $permission['id'] }}" name="permissions[]"
                                    value="{{ $permission['name'] }}" @if (in_array($permission['id'], $rolePermissions ?? [])) checked @endif>
                                <label class="form-check-label" for="permission{{ $permission['id'] }}">
                                    {{ $permission['name'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="py-3">
            <button type="submit" class="btn btn-primary w-100">
                Update
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.getElementById('flexSwitchCheckDefault').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
@endpush
