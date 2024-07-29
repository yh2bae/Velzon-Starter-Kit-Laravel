@if (auth()->user()->hasAnyPermission(['role_update', 'role_delete']))
    <div class="dropdown d-inline-block">
        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="ri-more-fill align-middle"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            @can('role_update')
                <li>
                    <a href="{{ route('roles.permissions', $item['id']) }}" class="dropdown-item">
                        <i class="mdi mdi-shield-key-outline align-bottom me-2 text-muted"></i>
                        Hak Akses
                    </a>
                </li>
            @endcan
            @can('role_update')
                <li>
                    <a href="javascript:void(0);" class="dropdown-item edit-item-btn" data-id="{{ $item['id'] }}"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasEdit" aria-controls="offcanvasEdit">
                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                        Edit
                    </a>
                </li>
            @endcan
            @can('role_delete')
                <li>
                    <a h href="javascript:void(0);" class="dropdown-item remove-item-btn" id="deleteButton"
                        data-id="{{ $item['id'] }}">
                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                        Delete
                    </a>
                </li>
            @endcan
        </ul>
    </div>
@endif
