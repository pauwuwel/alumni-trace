<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerja extends Model
{
    use HasFactory;
    protected $table = 'kerja';
    protected $primaryKey = 'id_kerja';
    protected $fillable = ['id_alumni', 'instansi', 'jabatan', 'tanggal_masuk', 'tanggal_keluar'];
    public $timestamps = false;
}
