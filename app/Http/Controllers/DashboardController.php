<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Support\Facades\Auth;
use App\Models\Forum;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Carbon::setLocale('id');

class DashboardController extends Controller
{
    public function index(Forum $forum) 
    {
        $data = [
            'karir_data' => DB::table('view_total_karir')->first(),
            'forum_data' => DB::table('view_forum_data')->where('status', 'pending')->get(),
            'logs_data' => null
        ];

        
        if(Auth::user()->role == 'superAdmin') {

            $logsData = DB::table('logs')->where('actor', 'superadmin')->get();

            foreach ($logsData as $logs) {

                $logsDate = Carbon::parse($logs->date);
                if ($logsDate->diffInDays() > 7) {
                    $logs->date = $logsDate->format('d-m-Y');
                } else {
                    $logs->date = $logsDate->diffForHumans();
                }
            }

            $data['logs_data'] = $logsData;
        }

        return view('dashboard.index', $data);
    }

    public function printPDF()
    {
        // $logs = Logs::orderBy('id_logs', 'desc')->get();

        // $pdf = Pdf::loadview('dashboard.log-pdf', compact('logs'));
        // return $pdf->stream();
    }
}
