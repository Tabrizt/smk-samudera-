<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Latihan CI4',
        ];
        return view('layouts/master_app', $data);
    }
}
