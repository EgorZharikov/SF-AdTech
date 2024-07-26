<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.profile');
    }

    public function webmaster()
    {
        return view('dashboard.webmaster');
    }
}
