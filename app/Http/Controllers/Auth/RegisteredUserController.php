<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warung;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // [PERUBAHAN] Role database tetap pembeli, label UI boleh Mahasiswa
            'role' => ['required', Rule::in(['pembeli', 'penjual'])],

            'name' => ['required', 'string', 'max:255'],

            'nama_warung' => [
                'required_if:role,penjual',
                'nullable',
                'string',
                'max:255',
                Rule::unique('warungs', 'nama'),
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // [PERUBAHAN] Simpan role sesuai database
            'role' => $request->role,
        ]);

        if ($user->role === 'penjual') {
            Warung::create([
                'user_id' => $user->id,
                'nama' => $request->nama_warung,
                'status' => 'buka',
                'kategori' => 'makanan',
                'rating' => 0,

                // [PERUBAHAN] Warung baru harus menunggu verifikasi admin
                'status_verifikasi' => 'pending',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'penjual') {
            return redirect()->route('penjual.dashboard');
        }

        // [PERUBAHAN] Role pembeli diarahkan ke dashboard mahasiswa
        return redirect()->route('mahasiswa.dashboard');
    }
}