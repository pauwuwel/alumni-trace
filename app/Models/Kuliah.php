<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuliah extends Model
{
    use HasFactory;
    protected $table = 'kuliah';
    protected $primaryKey = 'id_kuliah';
    protected $fillable = ['id_alumni', 'instansi', 'jurusan', 'tanggal_masuk', 'tanggal_lulus'];
    public $timestamps = false;
}
