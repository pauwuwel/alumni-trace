<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Forum;
use App\Models\Komentar;
use App\Models\Logs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Forum $forum)
    {
        // $forums = $forum->all();

        $komen = DB::table('view_komentar')->get();

        $alumnis = $forum
            ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
            ->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
            ->select('forum.*', 'alumni.nama');
        $admins = $forum
            ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
            ->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
            ->select('forum.*', 'admin.nama');

        // $data = [
        //     'datas' => $alumnis
        //         ->union($admins)
        //         ->orderBy('id_forum', 'desc')
        //         ->get(),
        // ];

        $totalForum = DB::select('SELECT getTotalForum() AS totalForum')[0]->totalForum;
        $totalKomentar = DB::select('SELECT getTotalKomentar() AS totalKomentar')[0]->totalKomentar;
        // Mengirim data agar ditampilkan kedalam view dengan isi array data pendaftaran
        // $data = [
        //         'forum' => $forum->all(),
        //         'jumlahForum' => $totalForum
        // ];

        $data = [
            'forum' => $alumnis
                ->union($admins)
                ->orderBy('id_forum', 'desc')
                ->get(),
            'jumlahForum' => $totalForum,
            'jumlahKomentar' => $totalKomentar,
            'komentar' => $komen,
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
                'judul' => 'required',
                'content' => 'required',
                'attachment' => 'sometimes|file',
                'tanggal_post',
                'id_pembuat',
                'status',
            ]
        );

        //Proses Insert
        if ($data) {
            $data['id_pembuat'] = auth()->user()->id_akun;
            $data['tanggal_post'] = Carbon::now();

            if (auth()->user()->id_akun) {
                $data['status'] = 'accepted';
            }

            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $foto_file = $request->file('attachment');
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
                $foto_file->move(public_path('img'), $foto_nama);
                $data['attachment'] = $foto_nama;
            }

            // Simpan jika data telah terisi semua
            // DB::beginTransaction();
            try {
                // $kelasId = $forum->create($data)->id_kelas;
                DB::statement('CALL Createforum(?, ?, ?, ?, ?, ?)', [$data['id_pembuat'], $data['judul'], $data['content'], $data['attachment'], $data['status'], $data['tanggal_post']]);
                // DB::commit();
                return redirect('forum')->with('success', 'data kamu berhasil ditambahkan');
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

    public function show(Forum $forum, string $id, komentar $komentar)
    {
        $alumnis = $forum
            ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
            ->join('alumni', 'akun.id_akun', '=', 'alumni.id_akun')
            ->select('forum.*', 'alumni.nama');
        $admins = $forum
            ->join('akun', 'forum.id_pembuat', '=', 'akun.id_akun')
            ->join('admin', 'akun.id_akun', '=', 'admin.id_akun')
            ->select('forum.*', 'admin.nama');

        $data = [
            'datas' => $alumnis
                ->union($admins)
                ->where('id_forum', $id)
                ->get(),
            'komentar' => $komentar->join('akun', 'komentar.id_pembuat', '=', 'akun.id_akun')->get(),
        ];

        // dd($data);
        return view('forum.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum, string $id)
    {
        $data = [
            'data' => Forum::where('id_forum', $id)->first(),
        ];

        return view('forum.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $forum)
    {
        // melakukan validasi untuk mengirim data ke dalam model menggunakan array
        //array multidimensi, array assosiative, memiliki 3 element
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
        $aksi = $forum->where('id_forum', $id_forum)->delete();

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
