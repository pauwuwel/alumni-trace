<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Forum;
use App\Models\Logs;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Logs $logs, Forum $forum) 
    {
        if (auth()->user()->role == 'superAdmin') 
        {
            $totalAlumni = DB::select("SELECT getTotalAlumni() as totalAlumni")[0]->totalAlumni;
            $logs = Logs::orderBy('id_logs', 'desc')->get();

            return view('dashboard.index', compact('totalAlumni', 'logs'));
        }

        elseif (auth()->user()->role == 'admin') 
        {
            $accForum = $forum
            ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
            ->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
            ->select('forum.*', 'alumni.nama')->where('status', 'pending')
            ->orderBy('id_forum', 'desc')->get();

            return view('dashboard.index', compact('accForum'));
        }

        elseif (auth()->user()->role == 'alumni') 
        {
            return view('dashboard.index');
        }

        else
        {

        }
    }
}
