<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Utama';
        return view('prodi.dasboard', compact('title'));
    }
}
