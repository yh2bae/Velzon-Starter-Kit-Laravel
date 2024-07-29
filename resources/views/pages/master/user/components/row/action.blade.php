@if (auth()->user()->hasAnyPermission(['user_update', 'user_delete', 'user_login_as']))
    <div class="dropdown d-inline-block">
        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="ri-more-fill align-middle"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            @can('user_login_as')
                <li>
                    <a href="{{ route('users.login-as', $item['id']) }}" class="dropdown-item"
                        onclick="return confirm('Apakah Anda yakin ingin login sebagai {{ $item['name'] }}?')">
                        <i class="ri-user-shared-2-fill align-bottom me-2 text-muted"></i>
                        Login As
                    </a>
                </li>
            @endcan
            <li>
                <a href="javascript:void(0);" class="dropdown-item" data-id="{{ $item['id'] }}" data-bs-toggle="modal"
                    data-bs-target="#modalDetail" aria-controls="modalDetail">
                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                    Detail
                </a>
            </li>
            @can('user_update')
                <li>
                    <a href="javascript:void(0);" class="dropdown-item edit-item-btn" data-id="{{ $item['id'] }}"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasEdit" aria-controls="offcanvasEdit">
                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                        Edit
                    </a>
                </li>
            @endcan
            @can('user_delete')
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
@else
    <div class="dropdown d-inline-block">
        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="ri-more-fill align-middle"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a href="javascript:void(0);" class="dropdown-item" data-id="{{ $item['id'] }}" data-bs-toggle="modal"
                    data-bs-target="#modalDetail" aria-controls="modalDetail">
                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                    Detail
                </a>
            </li>
        </ul>
    </div>
@endif
