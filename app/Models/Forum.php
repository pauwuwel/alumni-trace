<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $table = 'forum';
    protected $primaryKey = 'id_forum';
    protected $fillable = ['id_pembuat', 'judul', 'content', 'attachment', 'status', 'tanggal_post'];
    public $timestamps = false;
}
