<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->user_type == 1) {
            return view('admin.dashboard');
        }

        if (auth()->user()->user_type == 3) {
            return redirect('/');
        }
    }
}
