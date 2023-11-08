<?php

namespace App\Http\Controllers;

use App\Models\Akun;
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
        $data = $request->validate(
            [
                'username' => ['required'],
                'password' => ['required'],
                'role'    => ['required'],
            ]
        );

        //Proses Insert
        if ($data) {
            $data['password'] = Hash::make($data['password']);

            // Simpan jika data terisi semua
            DB::beginTransaction();
            try {
                $akunId = $akun->create($data)->id_akun;
                DB::statement("CALL createProfile(?, ?, ?)", [$akunId, $data['username'], $data['role']]);
                // DB::commit();
                return redirect('kelola-akun')->with('success', 'Data user berhasil ditambahkan');
            } catch (Exception $e) {
                // DB::rollback();  
                return back()->with('error', 'Data user gagal ditambahkan');
            }
        } else {
            // Kembali ke form tambah data
            return back()->with('error', 'Data user gagal ditambahkan');
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

        if ($id_akun !== null) {
            // Process Update
            $dataUpdate = $akun->where('id_akun', $id_akun)->update($data);

            if ($dataUpdate) {
                return redirect('kelola-akun')->with('success', 'Data akun berhasil di update');
            } else {
                return back()->with('error', 'Data akun gagal di update');
            }
        }
    }

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
