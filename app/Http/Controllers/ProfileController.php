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

    public function update(Request $request, SuperAdmin $superAdmin)
    {
        $id_super_admin = $request->input('id_super_admin');

        $data = $request->validate([
            'id_super_admin' => 'required',
            'nama' => 'sometimes',
            'foto' => 'sometimes|file',
        ]);

        if ($id_super_admin !== null) {
            if ($request->hasFile('foto')) {
                $foto_file = $request->file('foto');
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
                $foto_file->move(public_path('img'), $foto_nama);
                $data['foto'] = $foto_nama;
            }

            $dataUpdate = $superAdmin->where('id_super_admin', $id_super_admin)->update($data);

            if ($dataUpdate) {
                return redirect('/profile/' . $id_super_admin)->with('success', 'Data profile berhasil diupdate');
            }

            return back()->with('error', 'Data jenis surat gagal diupdate');
        }
    }
}
