<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Forum;
use App\Models\Logs;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Logs $logs, Forum $forum) 
    {
        $karir_data = DB::table('view_total_karir')->first();

        $data = [
            'karir_data' => $karir_data,
        ];

        return view('dashboard.index', $data);
    }

    public function printPDF()
    {
        $logs = Logs::orderBy('id_logs', 'desc')->get();

        $pdf = Pdf::loadview('dashboard.log-pdf', compact('logs'));
        return $pdf->stream();
    }
}
