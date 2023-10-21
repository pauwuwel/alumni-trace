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

    public function alumni()
    {
        return $this->hasOne(Alumni::class, 'id_akun', 'id_akun');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_akun', 'id_akun');
    }

    public function superAdmin()
    {
        return $this->hasOne(SuperAdmin::class, 'id_akun', 'id_akun');
    }

}
