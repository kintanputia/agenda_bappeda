<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $fillable = ['id', 'nama_lokasi', 'posisi', 'status']; //posisi 0=dalam bappeda 1=luar bappeda, status 0=tersedia 1=tidaktersedia
}
