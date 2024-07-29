<ul class="navbar-nav" id="navbar-nav">
    @foreach (loadMenu() as $item)
        @php
            $isActive = isset($item['route']) ? isMenuItemActive([$item['route'], $item['route'] . '/*']) : false;
            if (isset($item['urlActive'])) {
                $isActive = $isActive || request()->is(trim($item['urlActive'], '/'));
            }
            $isTrigger = isset($item['items'])
                ? collect($item['items'])->some(
                    fn($sub) => isMenuItemActive([$sub['route'], $sub['route'] . '/*']) ||
                        (isset($sub['urlActive']) && request()->is(trim($sub['urlActive'], '/'))),
                )
                : false;
            $hasPermission = isset($item['permission']) ? hasPermission($item['permission']) : true;
            $hasPermission = isset($item['permissionAny']) ? hasPermission($item['permissionAny']) : $hasPermission;
        @endphp
        @if ($hasPermission)
            @if (isset($item['type']) && $item['type'] == 'header')
                <li class="menu-title"><span data-key="t-{{ $item['label'] }}">{{ $item['label'] }}</span></li>
            @elseif(isset($item['items']))
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $isTrigger ? 'collapsed' : '' }} {{ $isActive ? 'active' : '' }}"
                        href="#sidebar{{ $item['label'] }}" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="sidebar{{ $item['label'] }}">
                        <i class="mdi mdi-{{ $item['icon'] }}"></i> <span
                            data-key="t-{{ $item['label'] }}">{{ $item['label'] }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar{{ $item['label'] }}">
                        <ul class="nav nav-sm flex-column">
                            @foreach ($item['items'] as $subItem)
                                @php
                                    $isActive = isset($subItem['route'])
                                        ? isMenuItemActive([$subItem['route'], $subItem['route'] . '/*'])
                                        : false;
                                    if (isset($subItem['urlActive'])) {
                                        $isActive = $isActive || request()->is(trim($subItem['urlActive'], '/'));
                                    }
                                    $hasPermission = isset($subItem['permission'])
                                        ? hasPermission($subItem['permission'])
                                        : true;
                                @endphp
                                @if ($hasPermission)
                                    <li class="nav-item">
                                        <a href="{{ route($subItem['route']) }}"
                                            class="nav-link {{ $isActive ? 'active' : '' }}"
                                            data-key="t-{{ $subItem['label'] }}">
                                            {{ $subItem['label'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $isActive ? 'active' : '' }}"
                        href="{{ isset($item['route']) ? route($item['route']) : 'javascript:void(0);' }}">
                        <i class="mdi mdi-{{ $item['icon'] }}"></i> <span data-key="t-widgets">
                            {{ $item['label'] }}
                        </span>
                    </a>
                </li>
            @endif
        @endif
    @endforeach


</ul>
