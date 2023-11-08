<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Akun;
use App\Models\Logs;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Logs $logs) 
    {
        return view('dashboard.index');
    }
}
