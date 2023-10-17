<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{
    use HasFactory;
    protected $table = 'super_admin'; //  nama tabel
    protected $primarykey = 'id_super_admin'; // primary key tabel
    protected $fillable = ['id_akun', 'nama', 'foto']; // rows pada tabel
    public $timestamps = false; // mematikan fitur timestamps
}
