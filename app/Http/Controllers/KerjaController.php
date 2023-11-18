<?php

namespace App\Http\Controllers;

use App\Models\Kerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ['kerja' => DB::table('kerja')->get()];
        return view("kerja.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akun = Auth::user()->id_akun;
        $alumni = DB::table('alumni')
            ->where('id_akun', $akun)
            ->first();

        return view("kerja.tambah", ['data' => $alumni]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'instansi' => 'required',
            'jabatan' => 'required',
            'tanggal_masuk' => 'required',
            'tanggal_keluar' => 'required',
        ]);

        $data['id_alumni'] = $request->input('id_alumni');

        Kerja::create($data);

        return redirect('/kerja')->with('success', 'Karir Kerja berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kerja $kerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $akun = Auth::user()->id_akun;

        $alumni = DB::table('alumni')
            ->join('kerja', 'alumni.id_alumni', '=', 'kerja.id_alumni')
            ->where('alumni.id_akun', $akun)
            ->where('kerja.id_kerja', $id)
            ->first();

        return view("kerja.edit", ['data' => $alumni]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kerja $kerja)
    {
        $data = $request->validate([
            'instansi' => 'sometimes',
            'jabatan' => 'sometimes',
            'tanggal_masuk' => 'sometimes',
            'tanggal_keluar' => 'sometimes',
        ]);

        $id_kerja = $request->input('id_kerja');

        if ($id_kerja !== null) {
            // Process Update
            $dataUpdate = $kerja->where('id_kerja', $id_kerja)->update($data);

            if ($dataUpdate) {
                return redirect('kerja')->with('success', 'Data kerja berhasil di update');
            } else {
                return back()->with('error', 'Data kerja gagal di update');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kerja $kerja, Request $request)
    {
        $id_kerja = $request->input('id_kerja');

        // Hapus
        $aksi = $kerja->where('id_kerja', $id_kerja)->delete();

        if ($aksi) {
            // Pesan Berhasil
            $pesan = [
                'success' => true,
                'pesan' => 'Data jenis surat berhasil dihapus',
            ];
        } else {
            // Pesan Gagal
            $pesan = [
                'success' => false,
                'pesan' => 'Data gagal dihapus',
            ];
        }

        return response()->json($pesan);
    }
}
