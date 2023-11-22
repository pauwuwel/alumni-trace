<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Forum;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

Carbon::setLocale('id');
class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forum_data = DB::table('view_forum_data')->where('status', 'accepted')->orderBy('tanggal_post', 'desc')->get();
        $komentar_data = DB::table('view_komentar_data')->orderBy('tanggal_post', 'desc')->get();

        $get_forum_komentar = [];

        foreach ($komentar_data as $komentar) {
            $forum_id = $komentar->id_forum;

            if (!isset($get_forum_komentar[$forum_id])) {
                $get_forum_komentar[$forum_id] = [];
            }

            $get_forum_komentar[$forum_id][] = $komentar;
        }

        foreach ($forum_data as $forum) {
            $forum->komentar = isset($get_forum_komentar[$forum->id_forum]) ? $get_forum_komentar[$forum->id_forum] : [];

            $forumDate = Carbon::parse($forum->tanggal_post);

            if ($forumDate->diffInDays() > 7) {
                $forum->tanggal_post = $forumDate->format('d-m-Y');
            } else {
                $forum->tanggal_post = $forumDate->diffForHumans();
            }
        }

        return view('forum.index', compact('forum_data'));
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

            if (auth()->user()->role == 'admin') {
                $data['status'] = 'accepted';
            }

            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $foto_file = $request->file('attachment');
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
                $foto_file->move(public_path('img'), $foto_nama);
                $data['attachment'] = $foto_nama;
            }
            // Simpan jika data terisi semua
            $forum->create($data);
            if (auth()->user()->role == 'admin') {
                return redirect('forum')->with('success', 'Forum baru berhasil dibuat');
            } else {
                return redirect('forum')->with('success', 'Data forum berhasil di kirim, mohon tunggu konfirmasi dari admin.');
            }
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

        $forum_data = DB::table('view_forum_data')->where('id_forum', $id)->get();

        foreach ($forum_data as $forum) {

            if ($forum->status == 'pending') {

                if (auth()->user()->role == 'admin') {
                    return view('forum.detail', compact('forum_data'));
                } else {
                    return redirect('forum')->with('error', 'Forum yang anda akses belum dikonfirmasi!');
                }
            }
        }

        $komentar_data = DB::table('view_komentar_data')->where('id_forum', $id)->orderBy('tanggal_post', 'desc')->get();

        $get_forum_komentar = [];

        foreach ($komentar_data as $komentar) {
            $forum_id = $komentar->id_forum;

            if (!isset($get_forum_komentar[$forum_id])) {
                $get_forum_komentar[$forum_id] = [];
            }

            $get_forum_komentar[$forum_id][] = $komentar;
        }

        foreach ($forum_data as $forum) {

            $forum->komentar = isset($get_forum_komentar[$forum->id_forum]) ? $get_forum_komentar[$forum->id_forum] : [];
            $forum->totalKomentar = DB::select('SELECT getTotalKomentar(?) AS totalKomentar', [$forum->id_forum])[0]->totalKomentar;

            $forumDate = Carbon::parse($forum->tanggal_post);

            if ($forumDate->diffInDays() > 7) {
                $forum->tanggal_post = $forumDate->format('d-m-Y');
            } else {
                $forum->tanggal_post = $forumDate->diffForHumans();
            }

            foreach ($forum->komentar as $komen) {

                $komenDate = Carbon::parse($komen->tanggal_post);
                if ($komenDate->diffInDays() > 7) {
                    $komen->tanggal_post = $komenDate->format('d-m-Y');
                } else {
                    $komen->tanggal_post = $komenDate->diffForHumans();
                }
            }
        }


        return view('forum.detail', compact('forum_data'));
    }

    public function status(Forum $forum, Request $request)
    {
        $id_forum = $request->input('id_forum');
        $status = $request->input('status');

        $dataUpdate = $forum->where('id_forum', $id_forum)->update(['status' => $status]);

        if ($dataUpdate) {
            // Pesan Berhasil
            $pesan = [
                'success' => true,
                'pesan'   => 'Forum berhasil di Konfirmasi'
            ];
        } else {
            // Pesan Gagal
            $pesan = [
                'success' => false,
                'pesan'   => 'Forum gagal di Konfirmasi'
            ];
        }

        return response()->json($pesan);
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
                return redirect('forum')->with('success', 'Data Forum update');
            } else {
                return back()->with('error', 'Data Forum gagal di update');
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
    public function addKomen(Komentar $komentar, Request $request)
    {
        $data = $request->validate([
            'id_forum' => 'required',
            'id_pembuat' => 'required',
            'komentar' => 'required',
            'attachment' => 'nullable',
            'tanggal_post' => 'nullable',
        ]);

        $data['tanggal_post'] = Carbon::now();

        $create = $komentar->create($data);
        if ($create) {
            return redirect('forum/' . $data['id_forum']);
        } else {
            return redirect('forum')->with('success', 'Data forum berhasil di kirim, mohon tunggu konfirmasi dari admin.');
        }
    }
}
