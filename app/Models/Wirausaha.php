<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wirausaha extends Model
{
    use HasFactory;
    protected $table = 'wirausaha';
    protected $primaryKey = 'id_wirausaha';
    protected $fillable = ['id_alumni', 'alamat', 'bidang', 'tanggal_masuk', 'tanggal_berhenti'];
    public $timestamps = false;
}
