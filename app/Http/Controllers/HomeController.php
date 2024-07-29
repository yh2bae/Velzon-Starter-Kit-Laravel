<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->path = 'pages.home.';
    }

    public function index()
    {

        $data = [
            'page_title' => 'Beranda',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
            ],
        ];

        return view($this->path . 'index', $data);
    }
}
