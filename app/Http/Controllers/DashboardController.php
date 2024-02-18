<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Forum;
use App\Models\Logs;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

Carbon::setLocale('id');

class DashboardController extends Controller
{
    public function index(Forum $forum, Logs $logs) 
    {

        $log_data = null;

        
        if (Auth::user()->role == 'superAdmin') {
            $log_data = $logs->where('actor', 'superadmin')->get(); 
        }

        if (Auth::user()->role == 'admin') {
            $log_data = $logs->where('table', 'forum')->get();
        }

        if (Auth::user()->role == 'alumni') {
            $userId = auth()->user()->id_akun;

            $forumData = Forum::where('id_pembuat', $userId)->get();

            $forumIds = $forumData->pluck('id_forum');

            $log_data = Logs::whereIn('row', $forumIds)
                ->where('table', 'forum')
                ->get();
        }

        

        $data = [
            'karir_data' => DB::table('view_total_karir')->first(),
            'forum_data' => DB::table('view_forum_data')->where('status', 'pending')->get(),
            'log_data' => $log_data
        ];

        return view('dashboard.index', $data);
    }

    public function printPDF()
    {
        // $logs = Logs::orderBy('id_logs', 'desc')->get();

        // $pdf = Pdf::loadview('dashboard.log-pdf', compact('logs'));
        // return $pdf->stream();
    }
}
