<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Wirausaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WirausahaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ['wirausaha' => DB::table('wirausaha')->get()];
        return view("wirausaha.index", $data);
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

        return view("wirausaha.tambah", ['data' => $alumni]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'bidang' => 'required',
            'alamat' => 'required',
            'tanggal_masuk' => 'required',
            'tanggal_berhenti' => 'required',
        ]);

        $data['id_alumni'] = $request->input('id_alumni');

        Wirausaha::create($data);

        return redirect('/wirausaha')->with('success', 'Karir Wirausaha berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Wirausaha $wirausaha)
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
            ->join('wirausaha', 'alumni.id_alumni', '=', 'wirausaha.id_alumni')
            ->where('alumni.id_akun', $akun)
            ->where('wirausaha.id_wirausaha', $id)
            ->first();

        return view("wirausaha.edit", ['data' => $alumni]);
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Wirausaha $wirausaha)
    {
        $data = $request->validate([
            'bidang' => 'sometimes',
            'alamat' => 'sometimes',
            'tanggal_masuk' => 'sometimes',
            'tanggal_berhenti' => 'sometimes',
        ]);

        $id_wirausaha = $request->input('id_wirausaha');

        if ($id_wirausaha !== null) {
            // Process Update
            $dataUpdate = $wirausaha->where('id_wirausaha', $id_wirausaha)->update($data);

            if ($dataUpdate) {
                return redirect('wirausaha')->with('success', 'Data wirausaha berhasil di update');
            } else {
                return back()->with('error', 'Data wirausaha gagal di update');
            }
        }
    }


    public function destroy(Wirausaha $wirausaha, Request $request)
    {
        $id_wirausaha = $request->input('id_wirausaha');

        // Hapus
        $aksi = $wirausaha->where('id_wirausaha', $id_wirausaha)->delete();

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
