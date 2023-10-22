<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Forum $forum)
    {
        $data = [
            'datas' => $forum->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
                             ->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
                             ->select('forum.*', 'alumni.nama')->orderBy('id_forum', 'desc')->get()
        ];

        return view('forum.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('forum.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Forum $forum, Request $request)
    {
        $data = $request->validate(
            [
                'judul' => ['required'],
                'content' => ['required'],
                'attachment' => ['sometimes'],
                'tanggal_post',
                'id_pembuat',
            ]
        );

        //Proses Insert
        if ($data) {
            $data['tanggal_post'] = Carbon::now()->format( 20 .'y-m-d');
            $data['id_pembuat'] = auth()->user()->id_akun;
            
            // Simpan jika data terisi semua
            $forum->create($data);
            return redirect('forum')->with('success', 'Data user baru berhasil ditambah');
        } else {
            // Kembali ke form tambah data
            return back()->with('error', 'Data user gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Forum $forum, string $id)
    {
        $data = [
            'datas' => $forum->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
                             ->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
                             ->select('forum.*', 'alumni.nama')->where('forum.id_forum', $id)->get()
        ];

        return view('forum.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum, string $id)
    {
        $data = [
            'data' => Forum::where('id_forum', $id)->first()
        ];

        return view('forum.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $forum)
    {
        $data = $request->validate([
            'judul' => ['sometimes'],
            'content' => ['sometimes'],
            'attachment' => ['sometimes'],
        ]);

        $id_forum = $request->input('id_forum');

        if ($id_forum !== null) {
            // Process Update
            $dataUpdate = $forum->where('id_forum', $id_forum)->update($data);

            if ($dataUpdate) {
                return redirect('forum')->with('success', 'Data jenis surat berhasil di update');
            } else {
                return back()->with('error', 'Data jenis surat gagal di update');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $forum, Request $request)
    {
        $id_forum = $request->input('id_forum');

        // Hapus
        $aksi = $forum->where('id_forum', $id_forum )->delete();

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
