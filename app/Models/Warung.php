<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warung extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'foto',
        'deskripsi',
        'rating',
        'status',
        'estimasi_waktu',
        'kategori',
        'kontak',        // [PERUBAHAN]
        'area_kampus',   // [PERUBAHAN]
        'alamat',        // [PERUBAHAN]
        'jam_buka',      // [PERUBAHAN]
        'jam_tutup',     // [PERUBAHAN]
        'status_verifikasi',
        'catatan_verifikasi',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}