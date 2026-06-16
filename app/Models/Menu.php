<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'warung_id',
        'nama',       
        'deskripsi',
        'varian',
        'harga',
        'kategori',
        'tersedia',  
        'foto',
    ];
}