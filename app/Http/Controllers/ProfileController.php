<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akun;
use App\Models\SuperAdmin;
use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Alamat;
use App\Models\Karir;
use App\Models\Forum;
use App\Models\Logs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

Carbon::setLocale('id');

class ProfileController extends Controller
{
    public function index(Akun $akun, Alumni $alumni, Request $request, string $id)
    {
        $akun = Akun::find($id);
        if ($akun) {
            if ($akun->alumni) 
            {
                $idAlumni = $alumni->join('akun', 'alumni.id_akun', '=', 'akun.id_akun')
                    ->select('alumni.id_alumni')->where('alumni.id_akun', $id)
                    ->first();


                $profileData = DB::table('view_profile_alumni')->where('id_akun', $id)->get();

                $careerData = DB::table('view_karir_alumni')->where('id_alumni', $idAlumni->id_alumni)->get();

                foreach ($careerData as $career) {

                    $careerArray = (array) $career;

                    foreach ($careerArray as $field => $value) {
                        if ($field !== 'nama_instansi' && $field !== 'tanggal_mulai' && $field !== 'tanggal_selesai') {
                            $career->$field = Str::lower($value);
                        }
                        if ($field == 'nama_instansi') {
                            $career->$field = ucwords($value);
                        }
                    }

                    $career->tanggal_mulai_iso = Carbon::parse($career->tanggal_mulai)->isoFormat('DD MMMM YYYY');

                    if ($career->tanggal_selesai !== null) {
                        $career->tanggal_selesai_iso = Carbon::parse($career->tanggal_selesai)->isoFormat('DD MMMM YYYY');
                    }
                }


                $data = [
                    'profile' => $profileData,
                    'career' => $careerData,
                ];

                return view('profile.index', $data);
            } elseif ($akun->admin) {

                $data = ['profile' => DB::table('view_profile_admin')->get()];

                return view('profile.index', $data);
            } elseif ($akun->superAdmin) {
                $data = ['profile' => DB::table('view_profile_super_admin')->get()];

                return view('profile.index', $data);
            } else {
                return back()->with('error', 'terjadi kesalahan');
            }
        } else {
            return back()->with('error', 'terjadi kesalahan');
        }
    }

    public function edit(Akun $akun, Alamat $alamat, Request $request, string $id)
    {
        $akun = Akun::find($id);

        if ($akun->id_akun !== auth()->user()->id_akun) {
            return back()->with('error', 'Anda tidak memiliki akses!');
        }

        // dd($akun->id_akun, auth()->user()->id_akun);

        if ($akun) {
            if ($akun->alumni) {

                $data = [
                    'profile' => $akun->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
                        ->select('alumni.*', 'akun.role')->where('alumni.id_akun', $id)->get(),
                    'alamat' => $alamat->join('alumni', 'alamat.id_alumni', '=', 'alumni.id_alumni')
                        ->select('alamat.*')->where('alumni.id_akun', $id)->get(),
                ];

                return view('profile.edit', $data);
            } elseif ($akun->admin) {

                $data = [
                    'profile' => $akun->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
                        ->select('admin.*', 'akun.role')->where('admin.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);
            } elseif ($akun->superadmin) {

                $data = [
                    'profile' => $akun->join('super_admin', 'akun.id_akun', '=', 'super_admin.id_akun')
                        ->select('super_admin.*', 'akun.role')->where('super_admin.id_akun', $id)->get()
                ];

                return view('profile.edit', $data);
            } else {
                return back()->with('error', 'terjadi kesalahan');
            }
        } else {
            return back()->with('error', 'terjadi kesalahan');
        }
    }

    public function update(SuperAdmin $superAdmin, Admin $admin, Alumni $alumni, Request $request, Alamat $alamat, string $id)
    {

        $role = $request->input('role');

        if ($role == 'alumni') {
            $id_alumni = $request->input('id_alumni');

            $data = $request->validate([
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'nomor_telepon' => 'required',
                'tanggal_lahir' => 'required',
                'foto' => 'sometimes|file',
            ]);

            $dataAlamat = $request->validate([
                'jalan' => 'nullable',
                'gang' => 'nullable',
                'nomor_rumah' => 'nullable',
                'blok' => 'nullable',
                'rt' => 'nullable',
                'rw' => 'nullable',
                'kelurahan' => 'nullable',
                'kecamatan' => 'nullable',
                'kota' => 'nullable',
                'kodepos' => 'nullable',
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
            $alamatUpdate = $alamat->where('id_alumni', $id_alumni)->update($dataAlamat);

            if ($dataUpdate || $alamatUpdate) {
                return redirect('profile/' . $id)->with('success', 'Data profile berhasil diupdate');
            }

            return back()->with('error', 'Data profile gagal diupdate');
        } elseif ($role == 'superAdmin') {
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
                if ($update_data->file !== null) {
                    File::delete(public_path('img') . '/' . $update_data->file);
                }
            }
            $dataUpdate = $superAdmin->where('id_super_admin', $id_super_admin)->update($data);

            if ($dataUpdate) {
                return redirect('profile/' . $id)->with('success', 'Data profile berhasil diupdate');
            }

            return back()->with('error', 'Data profile gagal diupdate');
        } elseif ($role == 'admin') {
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
                if ($update_data->file !== null) {
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

    public function addKarir(Alumni $alumni, Karir $karir, Request $request, string $id)
    {
        $data = $request->validate([
            'jenis_karir' => ['required'],
            'nama_instansi' => ['required'],
            'posisi_bidang' => ['required'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date'],
        ]);

        // Additional validation or processing logic can be added here

        // Find the Alumni ID based on the authenticated user
        $alumniData = $alumni->join('akun', 'alumni.id_akun', '=', 'akun.id_akun')
            ->select('alumni.id_alumni')->where('alumni.id_akun', $id)
            ->first();

        // Create a new Karir instance and fill it with the form data
        $karir = new Karir();
        $karir->jenis_karir = $data['jenis_karir'];
        $karir->nama_instansi = $data['nama_instansi'];
        $karir->posisi_bidang = $data['posisi_bidang'];
        $karir->tanggal_mulai = $data['tanggal_mulai'];
        $karir->tanggal_selesai = $data['tanggal_selesai'];

        // Set the Alumni ID for the Karir instance
        $karir->id_alumni = $alumniData->id_alumni;

        // Save the new Karir instance to the database
        $karir->save();

        // You can also associate it with the relevant Alumni or any other logic here

        // Return a response (you may customize this based on your needs)
        return response()->json(['message' => 'Karir added successfully']);
    }

    public function editKarir(Alumni $alumni, Karir $karir, Request $request, string $id)
    {
        $data = $request->validate([
            'jenis_karir' => ['required'],
            'id_alumni' => ['required'],
            'id_karir' => ['required'],
            'nama_instansi' => ['required'],
            'posisi_bidang' => ['required'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date'],
        ]);
        
        $dataUpdate = $karir->where('id_karir', $data['id_karir'])->update($data);

        if ($dataUpdate) {
            return redirect('profile/' . $id)->with('success', 'Data karir berhasil diupdate');
        }

        return back()->with('error', 'Data karir gagal diupdate');
    }
    
    public function removeKarir(Karir $karir, Request $request, string $id)
    {
        $id_karir = $request->input('id_karir');

        // Hapus
        $aksi = $karir->where('id_karir', $id_karir)->delete();

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

    public function showLogs(string $id, Logs $logs, Forum $forum)
    {
        if (auth()->user()->id_akun != $id) {
            return redirect('profile/' . auth()->user()->id_akun . '/activity');
        }

        if (auth()->user()->role == 'admin') {
            $logsData = $logs->where('table', 'forum')->get();

            foreach ($logsData as $logss) {

                $logssDate = Carbon::parse($logss->date);
                if ($logssDate->diffInDays() > 7) {
                    $logss->date = $logssDate->format('d-m-Y');
                } else {
                    $logss->date = $logssDate->diffForHumans();
                }
            }

            return view('profile.logs', compact('logsData'));
        } else {
            $userId = auth()->user()->id_akun;

            $forumData = Forum::where('id_pembuat', $userId)->get();

            $forumIds = $forumData->pluck('id_forum');

            $logsData = Logs::whereIn('row', $forumIds)
                ->where('table', 'forum')
                ->get();



            return view('profile.logs', compact('logsData'));
        }
    }
}
