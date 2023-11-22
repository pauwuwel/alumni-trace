<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Alamat extends Model
{
    use HasFactory;
    protected $table = 'alamat';
    protected $primaryKey = 'id_alamat';
    protected $fillable = ['id_alumni', 'jalan', 'gang', 'nomor_rumah', 'blok', 'rt', 'rw', 'kelurahan', 'kecamatan', 'kota', 'kodepos'];
    public $timestamps = false;
}
