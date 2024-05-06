<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverLoginController extends Controller
{
    //
    public function index()
    {
        # code... 
        return view('driver_dashboard.auth.login');
    }
    public function fillfulment()
    {
        # code... 
        return view('driver_dashboard.auth.completeData');
    }
}
