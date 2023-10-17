<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;
    protected $table = 'alumni'; //  nama tabel
    protected $primarykey = 'id_alumni'; // primary key tabel
    protected $fillable = ['id_akun', 'nama', 'jenis_kelamin', 'nomor_telepon', 'tanggal_lahir', 'foto']; // rows pada tabel
    public $timestamps = false; // mematikan fitur timestamps
}
