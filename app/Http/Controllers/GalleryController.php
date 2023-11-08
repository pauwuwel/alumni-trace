<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Alumni $alumni)
    {
        // untuk mengambil data alumni dan mengurut kan data berdasarkan id alumni dari yang 
        // terkecil ke yang terbesar
        $data = [
            'datas' => $alumni->orderBy('nama', 'asc')->get()
        ]; // mengembalikan data dalam sebuah array
        return view('galeri.index', $data);
    }
}
