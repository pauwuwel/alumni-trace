<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Akun extends Authenticatable
{
    use HasFactory;
    protected $table = 'akun'; // nama tabel
    protected $primaryKey = 'id_akun'; // primary key tabel
    protected $fillable = ['username', 'password', 'role']; // row pada tabel
    public $timestamps = false; // mematikan fitur timestamps
}
