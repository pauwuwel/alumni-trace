<?php

namespace App\Http\Controllers;

use App\Models\Kuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ['kuliah' => DB::table('kuliah')->get()];
        return view("kuliah.index", $data);
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

        return view("kuliah.tambah", ['data' => $alumni]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'instansi' => 'required',
            'jurusan' => 'required',
            'tanggal_masuk' => 'required',
            'tanggal_lulus' => 'required',
        ]);

        $data['id_alumni'] = $request->input('id_alumni');

        Kuliah::create($data);

        return redirect('/kuliah')->with('success', 'Karir Kuliah berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Kuliah $kuliah)
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
            ->join('kuliah', 'alumni.id_alumni', '=', 'kuliah.id_alumni')
            ->where('alumni.id_akun', $akun)
            ->where('kuliah.id_kuliah', $id)
            ->first();

        return view("kuliah.edit", ['data' => $alumni]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuliah $kuliah)
    {
        $data = $request->validate([
            'instansi' => 'sometimes',
            'jurusan' => 'sometimes',
            'tanggal_masuk' => 'sometimes',
            'tanggal_lulus' => 'sometimes',
        ]);

        $id_kuliah = $request->input('id_kuliah');

        if ($id_kuliah !== null) {
            // Process Update
            $dataUpdate = $kuliah->where('id_kuliah', $id_kuliah)->update($data);

            if ($dataUpdate) {
                return redirect('kuliah')->with('success', 'Data kuliah berhasil di update');
            } else {
                return back()->with('error', 'Data kuliah gagal di update');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuliah $kuliah, Request $request)
    {
        $id_kuliah = $request->input('id_kuliah');

        // Hapus
        $aksi = $kuliah->where('id_kuliah', $id_kuliah)->delete();

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
