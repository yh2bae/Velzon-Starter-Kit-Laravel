<?php

function loadMenu()
{
    $path = base_path('resources/menu.json');
    $json = file_get_contents($path);
    $menu = json_decode($json, true);
    return $menu['menu'];
}

function isMenuItemActive($patterns)
{
    foreach ($patterns as $pattern) {
        if (request()->is($pattern . '*')) {
            return true;
        }

    }
    return false;
}

function hasPermission($permissions)
{
    if (is_array($permissions)) {
        foreach ($permissions as $permission) {
            if (auth()->user()->can($permission)) {
                return true;
            }
        }
        return false;
    } else {
        return auth()->user()->can($permissions);
    }
}
