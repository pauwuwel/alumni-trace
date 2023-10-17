<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin'; //  nama tabel
    protected $primaryKey = 'id_admin'; // primary key tabel
    protected $fillable = ['id_akun', 'nama', 'foto']; // rows pada tabel
    public $timestamps = false; // mematikan fitur timestamps
}
