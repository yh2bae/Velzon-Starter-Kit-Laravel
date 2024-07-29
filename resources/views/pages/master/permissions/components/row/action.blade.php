@if (auth()->user()->hasAnyPermission(['permission_update', 'permission_delete']))
    <div class="dropdown d-inline-block">
        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="ri-more-fill align-middle"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            @can('permission_update')
                <li>
                    <a href="javascript:void(0);" class="dropdown-item edit-item-btn" data-id="{{ $item['id'] }}"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasEdit" aria-controls="offcanvasEdit">
                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                        Edit
                    </a>
                </li>
            @endcan
            @can('permission_delete')
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
