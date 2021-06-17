<?php

namespace App\Http\Controllers\chuyenWebAdmin;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function index()
    {
        return view('chuyenWebAdmin.app.index');
    }
}
