<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Home extends BaseController
{
    protected $totalAdmin;
    
    public function __construct()
    {
        $this->totalAdmin = new AdminModel();
    } 

    public function index(): string
    {
        $data = [
            'title' => 'Latihan CI4',
            'admin' => $this->totalAdmin->TotalAdmin()
        ];
        return view('user/dashboard', $data);
    }
}
