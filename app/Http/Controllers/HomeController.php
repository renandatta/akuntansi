<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['fitur_program']);
    }

    public function index()
    {
        return view('dashboard.index');
    }
}
