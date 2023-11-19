<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akun;
use App\Models\SuperAdmin;
use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Karir;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

Carbon::setLocale('id');

class ProfileController extends Controller
{
    public function index(Akun $akun, Request $request, string $id)
    {
        $akun = Akun::find($id); 
        if ($akun) 
        {
            if ($akun->alumni) 
            {
                
                $profileData = DB::table('view_profile_alumni')->get();
                $careerData = DB::table('view_karir_alumni')->get();

                foreach ($careerData as $career) {

                    $careerArray = (array) $career;

                    foreach ($careerArray as $field => $value) {
                        if ($field !== 'nama_instansi' && $field !== 'tanggal_mulai' && $field !== 'tanggal_selesai') {
                            $career->$field = Str::lower($value);
                        }
                    }

                    $career->tanggal_mulai = Carbon::parse($career->tanggal_mulai)->isoFormat('DD MMMM YYYY');
                    if ($career->tanggal_selesai !== null)
                    {
                        $career->tanggal_selesai = Carbon::parse($career->tanggal_selesai)->isoFormat('DD MMMM YYYY');
                    }
                    
                }

                $data = [
                    'profile' => $profileData,
                    'career' => $careerData,
                ];

                return view('profile.index', $data);

            } 
            
            elseif ($akun->admin) 
            {
                
                $data = [ 'datas' => DB::table('view_profile_admin')->get() ];

                return view('profile.index', $data);
            } 
            
            elseif ($akun->superAdmin) 
            {
                $data = [ 'datas' => DB::table('view_profile_super_admin')->get() ];

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
        
        if ($akun->id_akun !== auth()->user()->id_akun)
        {
            return back()->with('error', 'Anda tidak memiliki akses!');
        }

        // dd($akun->id_akun, auth()->user()->id_akun);

        if ($akun) 
        {
            if ($akun->alumni) 
            {
                
                $data = [ 
                    'datas' => $akun->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
                    ->select('alumni.*', 'akun.role')->where('alumni.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);

            } 
            
            elseif ($akun->admin) 
            {
                
                $data = [ 
                    'datas' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                    ->select('admin.*', 'akun.role')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);
            } 
            
            elseif ($akun->superadmin) 
            {
                
                $data = [ 
                    'datas' => $akun->join('super_admin', 'akun.id_akun', '=', 'super_admin.id_akun')
                    ->select('super_admin.*', 'akun.role')->where('super_admin.id_akun', $id)->get()
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

    public function update(SuperAdmin $superAdmin, Admin $admin, Alumni $alumni, Request $request, string $id)
    {

        $role = $request->input('role');
        
        if ($role == 'alumni')
        {
            $id_alumni = $request->input('id_alumni');

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
                if($update_data->file !== null)
                {
                    File::delete(public_path('img') . '/' . $update_data->file);
                }

            }
            $dataUpdate = $alumni->where('id_alumni', $id_alumni)->update($data);

            if ($dataUpdate) {
                return redirect('profile/' . $id)->with('success', 'Data profile berhasil diupdate');
            }

            return back()->with('error', 'Data profile gagal diupdate');
        }

        elseif ($role == 'superAdmin')
        {
            $id_super_admin = $request->input('id_super_admin');

            $data = $request->validate([
                'nama' => 'required',
                'foto' => 'sometimes|file',
            ]);

            if ($request->hasFile('foto')) {
                $foto_file = $request->file('foto');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('img'), $foto_nama);
                $data['foto'] = $foto_nama;

                
                $update_data = $superAdmin->where('id_super_admin', $id_super_admin)->first();
                if($update_data->file !== null)
                {
                    File::delete(public_path('img') . '/' . $update_data->file);
                }

            }
            $dataUpdate = $superAdmin->where('id_super_admin', $id_super_admin)->update($data);

            if ($dataUpdate) {
                return redirect('profile/' . $id)->with('success', 'Data profile berhasil diupdate');
            }

            return back()->with('error', 'Data profile gagal diupdate');
        }

        elseif ($role == 'admin')
        {
            $id_admin = $request->input('id_admin');

            $data = $request->validate([
                'nama' => 'required',
                'foto' => 'sometimes|file',
            ]);

            if ($request->hasFile('foto')) {
                $foto_file = $request->file('foto');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('img'), $foto_nama);
                $data['foto'] = $foto_nama;

                
                $update_data = $admin->where('id_admin', $id_admin)->first();
                if($update_data->file !== null)
                {
                    File::delete(public_path('img') . '/' . $update_data->file);
                }

            }
            $dataUpdate = $admin->where('id_admin', $id_admin)->update($data);

            if ($dataUpdate) {
                return redirect('profile/' . $id)->with('success', 'Data profile berhasil diupdate');
            }

            return back()->with('error', 'Data profile gagal diupdate');
        }
        
    }

    public function addKarir(Alumni $alumni, Karir $karir, Request $request)
    {
        $data = $request->validate(
            [
                'jenis_karir' => ['required'],
                'nama_instansi' => ['required'],
                'posisi_bidang'    => ['required'],
                'tanggal_mulai'    => ['required'],
                'tanggal_selesai',
                'id_alumni',
            ]
        );

        $userid = auth()->user()->id_akun;
            $data['id_alumni'] = $alumni->join('akun', 'alumni.id_akun', '=', 'akun.id_akun')
                                        ->select('alumni.id_alumni')->where('alumni.id_akun', $userid)
                                        ->get();
        $aksi = $karir->create($data);
        

        if ($aksi) {
            // Pesan Berhasil
            $pesan = [
                'success' => true,
                'pesan'   => 'Data jenis surat berhasil dihapus'
            ];
        } else {
            // Pesan Gagal
            $pesan = [
                'success' => false,
                'pesan'   => 'Data gagal dihapus'
            ];
        }

        return response()->json($pesan);
    }
}
