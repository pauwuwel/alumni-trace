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
        $totalAlumni = DB::select("SELECT getTotalAlumni() as totalAlumni")[0]->totalAlumni;
        $logs = Logs::orderBy('id_logs', 'desc')->get();

        return view('dashboard.index', compact('totalAlumni', 'logs'));
    }
}
