<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function map()
    {
        return view('dashboard.map');
    }

    public function ndvimap()
    {
        return view('dashboard.ndvimap');
    }


}
