<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SuperAdmin;
use App\Models\Admin;
use App\Models\Alumni;

class ProfileController extends Controller
{
    public function index(SuperAdmin $superAdmin, Admin $admin, Alumni $alumni, Request $request, string $id)
    {
        $data = [
            'superAdmin' => SuperAdmin::join('akun', 'super_admin.id_akun', '=', 'akun.id_akun')
                                        ->select('super_admin.*', 'akun.id_akun')
                                        ->where('super_admin.id_akun', '=', $id)
                                        ->get(),

            'admin' => Admin::join('akun', 'admin.id_akun', '=', 'akun.id_akun')
                                        ->select('admin.*', 'akun.id_akun')
                                        ->where('admin.id_akun', '=', $id)
                                        ->get(),

            'alumni' => Alumni::join('akun', 'alumni.id_akun', '=', 'akun.id_akun')
                                        ->select('alumni.*', 'akun.id_akun')
                                        ->where('alumni.id_akun', '=', $id)
                                        ->get()
        ];

        return view('profile.index', $data);
    }

    public function edit(SuperAdmin $superAdmin, Admin $admin, Alumni $alumni, Request $request, string $id)
    {
        $data = [
            'superAdmin' => SuperAdmin::join('akun', 'super_admin.id_akun', '=', 'akun.id_akun')
                                        ->select('super_admin.*', 'akun.id_akun')
                                        ->where('super_admin.id_akun', '=', $id)
                                        ->get(),

            'admin' => Admin::join('akun', 'admin.id_akun', '=', 'akun.id_akun')
                                        ->select('admin.*', 'akun.id_akun')
                                        ->where('admin.id_akun', '=', $id)
                                        ->get(),

            'alumni' => Alumni::join('akun', 'alumni.id_akun', '=', 'akun.id_akun')
                                        ->select('alumni.*', 'akun.id_akun')
                                        ->where('alumni.id_akun', '=', $id)
                                        ->get()
        ];

        return view('profile.edit', $data);
    }
}
