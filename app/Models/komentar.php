<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class komentar extends Model
{
    use HasFactory;
    protected $table = 'komentar';
    protected $primaryKey = 'id_komentar';
    protected $fillable = ['id_forum','id_pembuat','komentar','attachment','tanggal_post'];
    public $timestamps = false;
}
