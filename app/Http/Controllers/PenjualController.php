<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warung;

class PenjualController extends Controller
{
    public function dashboard()
    {
        $warung = Warung::where('user_id', Auth::id())->first();
        return view('dashboard.penjual.index', compact('warung'));
    }

    public function profilEdit()
    {
        $warung = Warung::where('user_id', Auth::id())->first();
        return view('dashboard.penjual.profil-edit', compact('warung'));
    }

    public function profilUpdate(Request $request)
    {
        $warung = Warung::where('user_id', Auth::id())->first();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|in:makanan,minuman,snack',
            'status' => 'required|in:buka,tutup',
            'area_kampus' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:50',
            'jam_buka' => 'nullable',
            'jam_tutup' => 'nullable',
            'estimasi_waktu' => 'nullable|string|max:50',
        ]);

        $warung->update($validated);

        return redirect()->route('penjual.dashboard')->with('success', 'Profil warung berhasil diperbarui!');
    }
}