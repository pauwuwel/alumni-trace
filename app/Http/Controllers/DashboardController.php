<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Forum;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Forum $forum) 
    {

        if (auth()->user()->role == 'admin')
        {
            $alumnis = $forum
                            ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
                            ->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
                            ->select('forum.*', 'alumni.nama')->where('status', 'pending');
            $admins = $forum
                            ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
                            ->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                            ->select('forum.*', 'admin.nama')->where('status', 'pending');

                    
            $data = ['datas' => $alumnis->union($admins)->orderBy('id_forum', 'desc')->get()];

            return view('dashboard.index', $data);
        }

        else 
        {
            return view('dashboard.index');
        }
    }
}
