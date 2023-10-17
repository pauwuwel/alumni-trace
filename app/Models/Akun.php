<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;
    protected $table = 'akun'; // nama tabel
    protected $primarykey = 'id_akun'; // primary key tabel
    protected $fillable = ['username', 'email', 'password']; // row pada tabel
    public $timestamps = false; // mematikan fitur timestamps
}
