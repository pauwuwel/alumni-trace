<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Forum;
use App\Models\logs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Forum $forum)
    {
        $alumnis = $forum
        ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
        ->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
        ->select('forum.*', 'alumni.nama');

        $admins = DB::table("view_admin_forum");   

        $data = [
            'datas' => $alumnis->union($admins)->orderBy('id_forum', 'desc')->get(),
            'jumlahForum' => DB::select('SELECT getTotalForum() AS totalForum')[0]->totalForum
        ];

        // Mengirim data agar ditampilkan kedalam view dengan isi array data pendaftaran
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

     //
    public function store(Forum $forum, Request $request)
    {
        //Untuk mengambil data validasi
        //Array 2 dimensi Memiliki 1 Index 2 Element
        $data = $request->validate(
            [
                'judul' => ['required'],
                'content' => ['required'],
                'attachment' => ['sometimes'],
                'tanggal_post',
                'id_pembuat',
                'status',
            ]
        );
 
        //Proses Insert
        if ($data) {
            $data['tanggal_post'] = Carbon::now()->format( 20 .'y-m-d');
            $data['id_pembuat'] = auth()->user()->id_akun;
            
            if (auth()->user()->id_akun)
            {
                $data['status'] = 'accepted';
            }
            
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid())
            {
                $foto_file = $request->file('attachment');
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
                $foto_file->move(public_path('img'), $foto_nama);
                $data['attachment'] = $foto_nama;
            }
            // Simpan jika data terisi semua
            // DB::beginTransaction();
                try {
                    // $kelasId = $forum->create($data)->id_forum;
                    DB::statement("CALL Createforum(?, ?, ?, ?, ?, ?)", [$data['id_pembuat'], $data['judul'], $data['content'], 
                    $data['attachment'], $data['status'], $data['tanggal_post']]);
                    // DB::commit();
                    return redirect('forum')->with('success','data kamu berhasil ditambahkan');
                } catch (Exception $e) {
                    // $e->getMessage();
                    dd($e->getMessage());
                    // DB::rollback();
                    return back()->with('error', 'Data siswa gagal ditambahkan');
                }
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Forum $forum, string $id)
    {
        $alumnis = $forum
        ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
        ->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
        ->select('forum.*', 'alumni.nama');
        $admins = $forum
        ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
        ->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
        ->select('forum.*', 'admin.nama');
                   
        $data = ['data' => $alumnis->union($admins)->get()->where("id_forum", $id)];
        // Mengirim data agar ditampilkan kedalam view dengan isi array data pendaftaran

        // dd($data);
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

    public function logs(logs $logs)
    {
        $data = [
            'logs' => $logs->all(),

        ];
        return view('forum.logs', $data);
    }
}
