<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akun;
use App\Models\SuperAdmin;
use App\Models\Admin;
use App\Models\Alumni;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class ProfileController extends Controller
{
    public function index(Akun $akun, Request $request, string $id)
    {
        $akun = Akun::find($id);

        if ($akun) {
            if ($akun->alumni) {

                $data = [
                    'datas' => $akun->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
                        ->select('alumni.*', 'akun.role')->where('alumni.id_akun', $id)->get()
                ];

                return view('profile.index', $data);
            } elseif ($akun->admin) {

                $data = [
                    'datas' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                        ->select('admin.*', 'akun.role')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.index', $data);
            } elseif ($akun->superadmin) {

                $data = [
                    'datas' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                        ->select('admin.*', 'akun.role')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.index', $data);
            } else {
                return back()->with('error', 'terjadi kesalahan');
            }
        } else {
            return back()->with('error', 'terjadi kesalahan');
        }
    }

    public function edit(Akun $akun, Request $request, string $id)
    {
        $akun = Akun::find($id);

        if ($akun->id_akun !== auth()->user()->id_akun) {
            return back()->with('error', 'Anda tidak memiliki akses!');
        }

        // dd($akun->id_akun, auth()->user()->id_akun);

        if ($akun) {
            if ($akun->alumni) {

                $data = [
                    'datas' => $akun->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
                        ->select('alumni.*', 'akun.role')->where('alumni.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);
            } elseif ($akun->admin) {

                $data = [
                    'data' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                        ->select('admin.*')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);
            } elseif ($akun->superadmin) {

                $data = [
                    'data' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                        ->select('admin.*')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);
            } else {
                return back()->with('error', 'terjadi kesalahan');
            }
        } else {
            return back()->with('error', 'terjadi kesalahan');
        }
    }

    public function update(SuperAdmin $superAdmin, Admin $admin, Alumni $alumni, Request $request, string $id)
    {

        $id_alumni = $request->input('id_alumni');
        $role = $request->input('role');

        if ($role == 'alumni') {
            $data = $request->validate([
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'nomor_telepon' => 'required',
                'tanggal_lahir' => 'required',
                'foto' => 'sometimes|file',
            ]);

            if ($request->hasFile('foto')) {
                $foto_file = $request->file('foto');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('img'), $foto_nama);
                $data['foto'] = $foto_nama;


                $update_data = $alumni->where('id_alumni', $id_alumni)->first();
                if ($update_data->file !== null) {
                    File::delete(public_path('img') . '/' . $update_data->file);
                }
            }
            $dataUpdate = $alumni->where('id_alumni', $id_alumni)->update($data);

            if ($dataUpdate) {
                return redirect('profile/' . $id)->with('success', 'Data alumni berhasil diupdate');
            }

            return back()->with('error', 'Data alumni gagal diupdate');
        }


        // $id_super_admin = $request->input('id_super_admin');

        // $data = $request->validate([
        //     'id_super_admin' => 'required',
        //     'nama' => 'sometimes',
        //     'foto' => 'sometimes|file',
        // ]);

        // if ($id_super_admin !== null) {
        //     if ($request->hasFile('foto')) {
        //         $foto_file = $request->file('foto');
        //         $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
        //         $foto_file->move(public_path('img'), $foto_nama);
        //         $data['foto'] = $foto_nama;
        //     }

        //     $dataUpdate = $superAdmin->where('id_super_admin', $id_super_admin)->update($data);

        //     if ($dataUpdate) {
        //         return redirect('/profile/' . $id_super_admin)->with('success', 'Data profile berhasil diupdate');
        //     }

        //     return back()->with('error', 'Data jenis surat gagal diupdate');
        // }
    }
}
