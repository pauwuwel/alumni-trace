<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Alumni $alumni)
    {
        $data = [
            'datas' => $alumni->orderBy('nama', 'asc')->get()
        ]; // mengembalikan data dalam sebuah array
        return view('galeri.index', $data);
    }
}
