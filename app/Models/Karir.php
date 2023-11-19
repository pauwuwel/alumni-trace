<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karir extends Model
{
    use HasFactory;
    protected $table = 'karir';
    protected $primaryKey = 'id_karir';
    protected $fillable = ['id_alumni', 'jenis_karir', 'nama_instansi', 'posisi_bidang', 'tanggal_mulai', 'tanggal_selesai'];
    public $timestamps = false;
}
