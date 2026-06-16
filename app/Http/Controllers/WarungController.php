<?php

namespace App\Http\Controllers;

use App\Models\Warung;
use App\Models\Menu;
use App\Models\User;

class WarungController extends Controller
{
    public function home()
    {
        // [PERUBAHAN] Public home hanya menampilkan warung yang buka dan sudah disetujui admin
        $warungs = Warung::where('status', 'buka')
            ->where('status_verifikasi', 'disetujui')
            ->take(3)
            ->get();

        // [PERUBAHAN] Total warung yang dihitung hanya warung terverifikasi
        $totalWarung = Warung::where('status_verifikasi', 'disetujui')->count();

        $totalMenu = Menu::count();
        $totalUser = User::count();

        return view('public.home', compact(
            'warungs',
            'totalWarung',
            'totalMenu',
            'totalUser'
        ));
    }

    public function index()
    {
        // [PERUBAHAN] Daftar warung public hanya menampilkan warung yang sudah disetujui admin
        $warungs = Warung::where('status_verifikasi', 'disetujui')
            ->latest()
            ->get();

        return view('public.warung.index', compact('warungs'));
    }
}