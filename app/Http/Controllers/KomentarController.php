<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\komentar;
use App\Models\logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class KomentarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Forum $forum, $id_forum)
    {
        $forumData = $forum
            ->join('alumni', 'forum.id_pembuat', '=', 'alumni.id_akun')
            ->where('forum.id_forum', $id_forum)
            ->first();
        $data = [
            'forum' => $forumData,
        ];

        // dd($data);
        return view('forum.komentar', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'komentar' => ['required'],
            'attachment' => ['sometimes'],
        ]);

        $id_forum = $request->input('id_forum');
        $id_pembuat = Auth::user()->id_akun;
        $komentar = $data['komentar'];
        $attachment = null;

        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $file = $request->file('attachment');
            $attachment = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('attachment_komentar'), $attachment);
        }

        $tanggal_post = date('Y-m-d');

        DB::select('CALL CreateKomentar(?, ?, ?, ?, ?)', [
            $id_forum, $id_pembuat, $komentar, $attachment, $tanggal_post
        ]);

        return redirect('/forum')->with('success', 'Data komentar berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(komentar $komentar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(komentar $komentar, string $id)
    {
        $data = [
            'data' => $komentar::where('id_komentar', $id)->first(),
        ];
        return view('forum.komentar-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, komentar $komentar)
    {
        $data = $request->validate([
            'komentar' => ['required'],
            'attachment' => ['sometimes'],
        ]);

        $id_komentar = $request->input('id_komentar');

        if ($id_komentar !== null) {

            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                $foto_file = $request->file('attachment');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('attachment_komentar'), $foto_nama);

                $update_data = $komentar->where('id_komentar', $id_komentar)->first();
                $old_file_path = public_path('attachment_komentar') . '/' . $update_data->attachment;

                if (file_exists($old_file_path) && is_file($old_file_path)) {
                    unlink($old_file_path);
                }

                $data['attachment'] = $foto_nama;
            }

            // Process Update
            $dataUpdate = $komentar->where('id_komentar', $id_komentar)->update($data);

            if ($dataUpdate) {
                return redirect('forum')->with('success', 'Data komentar berhasil di update');
            }
        }
            return redirect('forum');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(komentar $komentar, Request $request)
    {
        $id_komentar = $request->input('id_komentar');

        $komentar = komentar::where('id_komentar', $id_komentar)->first();

        if ($komentar) {
            $attachment = $komentar->attachment;

            $aksi = $komentar->delete();

            $filePath = public_path('attachment_komentar') . '/' . $attachment;

            if (file_exists($filePath) && unlink($filePath)) {
                return response()->json(['success' => true]);
            }

            if ($aksi) {
                // Pesan Berhasil
                $pesan = [
                    'success' => true,
                    'pesan' => 'Data berhasil dihapus'
                ];
            } else {
                // Pesan Gagal
                $pesan = [
                    'success' => false,
                    'pesan' => 'Data gagal dihapus'
                ];
            }
        } else {
            // Pesan Gagal
            $pesan = [
                'success' => false,
                'pesan' => 'Tidak ada komentar',
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
