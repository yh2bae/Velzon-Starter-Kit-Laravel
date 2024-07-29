<ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
            <i class="fas fa-home"></i> Personal Detail
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('change-password') ? 'active' : '' }}"
            href="{{ route('change-password') }}">
            <i class="far fa-user"></i>
            Ubah Password
        </a>
    </li>
</ul>
