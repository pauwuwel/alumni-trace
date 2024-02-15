<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    public function index(Alumni $alumni)
    {
        $data = [
            'datas' =>DB::table('view_all_alumni')->orderBy('nama', 'asc')->get()
        ]; // mengembalikan data dalam sebuah array
        return view('galeri.index', $data);
    }

    public function search(Request $request)
    {
        $output = '';

        $searchQuery = $request->input('search');

        $alumni_data = DB::table('view_profile_alumni')->where('nama', 'like', '%' . $searchQuery . '%')
            ->orderBy('nama', 'asc')
            ->get();

        foreach ($alumni_data as $alumni) {
            $output .= '<div class="col-md-2 col-sm-12 mb-2">
                <a style="text-decoration:none;" href="/profile/' . $alumni->id_akun . '">
                    <button class="card w-100 d-flex flex-column justify-content-between p-2 h-100">
                        <img src="' . ($alumni->foto !== null ? url("img/" . $alumni->foto) : url("img/pp.png")) . '" alt="pp" class="w-100 mb-2 rounded" srcset="">
                        <div style="text-align: left;">
                            <h4 class="text-capitalize text-bold" style="margin:0;">' . $alumni->nama . '</h4>
                        </div>
                    </button>
                </a>
            </div>';
        }


        return response($output);
    }
}
