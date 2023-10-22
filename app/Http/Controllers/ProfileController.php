<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akun;
use App\Models\SuperAdmin;
use App\Models\Admin;
use App\Models\Alumni;

class ProfileController extends Controller
{
    public function index(Akun $akun, Request $request, string $id)
    {
        $akun = Akun::find($id); 
        
        if ($akun) 
        {
            if ($akun->alumni) 
            {
                
                $data = [ 
                    'datas' => $akun->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
                    ->select('alumni.*')->where('alumni.id_akun', $id)->get()
                ];

                return view('profile.index', $data);

            } 
            
            elseif ($akun->admin) 
            {
                
                $data = [ 
                    'data' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                    ->select('admin.*')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.index', $data);
            } 
            
            elseif ($akun->superadmin) 
            {
                
                $data = [ 
                    'data' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                    ->select('admin.*')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.index', $data);
            } 
            
            else 
            {
                return back()->with('error', 'terjadi kesalahan');
            }
        }

        else 
        {
            return back()->with('error', 'terjadi kesalahan');
        }
    }

    public function edit(Akun $akun, Request $request, string $id)
    {
        $akun = Akun::find($id); 
        
        if ($akun) 
        {
            if ($akun->alumni) 
            {
                
                $data = [ 
                    'datas' => $akun->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
                    ->select('alumni.*')->where('alumni.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);

            } 
            
            elseif ($akun->admin) 
            {
                
                $data = [ 
                    'data' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                    ->select('admin.*')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);
            } 
            
            elseif ($akun->superadmin) 
            {
                
                $data = [ 
                    'data' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                    ->select('admin.*')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);
            } 
            
            else 
            {
                return back()->with('error', 'terjadi kesalahan');
            }
        }

        else 
        {
            return back()->with('error', 'terjadi kesalahan');
        }
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
