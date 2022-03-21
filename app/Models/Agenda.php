<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';
    protected $fillable = ['nip', 'perihal', 'deskripsi', 'peserta', 'tgl_mulai', 'tgl_selesai', 'jam_mulai', 'jam_selesai', 'ruangan'];
    protected $dates = ['tgl_mulai', 'tgl_selesai'];
}
