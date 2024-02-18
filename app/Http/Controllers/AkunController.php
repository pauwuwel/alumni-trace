<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AkunController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Akun $akun)
    {
        $data = [
            'datas' => $akun->all()
        ]; // mengembalikan data akun dan akan dikirim ke halaman kelola akun
        return view('akun.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('akun.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Akun $akun, Request $request)
    {
        $data = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'role'    => ['required'],
        ]);

        // Hash the password
        $data['password'] = Hash::make($data['password']);

        // Begin a database transaction
        DB::beginTransaction();

        try {

            // filter username
            $existingUsername = Akun::where('username', $data['username'])->exists();
            if ($existingUsername) {
                return response()->json(['error' => 'Username sudah ada. Silakan pilih username lain.']);
            }

            // Create a new Akun record
            $newAkun = $akun->create($data);
            
            // Call the stored procedure to create a profile
            DB::statement("CALL createProfile(?, ?, ?)", [$newAkun->id_akun, $data['username'], $data['role']]);
            
            // Commit the transaction
            // DB::commit();

            // Redirect with success message
            return response()->json(['success' => 'Data akun berhasil ditambahkan.']);
        } catch (\Exception $e) {
            // Rollback the transaction on exception
            // DB::rollback();

            // Redirect back with error message
            return response()->json(['error' => 'Terjadi kesalahan. Mohon coba lagi.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Akun $akun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Akun $akun, string $id)
    {
        $data = [
            'data' =>  Akun::where('id_akun', $id)->first()
        ];

        return view('akun.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Akun $akun)
    {
        $data = $request->validate([
            'username' => ['required'],
            'role' => ['required'],
        ]);

        $id_akun = $request->input('id_akun');
        $old_username = $request->input('old_username');

        if ($id_akun !== null) {
            // Check if the new username is different from the old one
            if ($data['username'] !== $old_username) {
                // Check if the new username already exists
                $existingUsername = Akun::where('username', $data['username'])->exists();
                if ($existingUsername) {
                    return response()->json(['error' => 'Username sudah ada. Silakan pilih username lain.']);
                }
            } else {
                return response()->json(['error' => 'Mohon masukan username yang baru.']);
            }

            // Process Update
            $dataUpdate = $akun->where('id_akun', $id_akun)->update($data);

            if ($dataUpdate) {
                return response()->json(['success' => 'Data akun berhasil di update']);
            } else {
                return response()->json(['error' => 'Data akun gagal di update']);
            }
        }
    }


    // public function update(Request $request, Akun $akun)
    // {
    //     $data = $request->validate([
    //         'username' => ['required'],
    //         'role' => ['required'],
    //     ]);

    //     $id_akun = $request->input('id_akun');

    //     if ($id_akun !== null) {
    //         // Process Update
    //         $dataUpdate = $akun->where('id_akun', $id_akun)->update($data);

    //         if ($dataUpdate) {
    //             return redirect('kelola-akun')->with('success', 'Data akun berhasil di update');
    //         } else {
    //             return back()->with('error', 'Data akun gagal di update');
    //         }
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Akun $akun, Request $request)
    {
        $id_akun = $request->input('id_akun');

        // Hapus
        $aksi = $akun->where('id_akun', $id_akun )->delete();

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
