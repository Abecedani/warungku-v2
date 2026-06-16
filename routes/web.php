<?php

use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarungController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Warung;
use App\Models\Menu;
use App\Http\Controllers\PenjualController;

Route::get('/penjual/dashboard', [PenjualController::class, 'dashboard'])->name('penjual.dashboard');
Route::get('/penjual/profil/edit', [PenjualController::class, 'profilEdit'])->name('penjual.profil.edit');
Route::put('/penjual/profil', [PenjualController::class, 'profilUpdate'])->name('penjual.profil.update');

Route::get('/', [WarungController::class, 'home'])->name('home');
Route::get('/warung', [WarungController::class, 'index'])->name('warung.index');

Route::get('/warung/{id}', function ($id) {
    return view('public.warung.show', compact('id'));
})->name('warung.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mahasiswa/dashboard', function () {
        return view('dashboard.mahasiswa.index');
    })->name('mahasiswa.dashboard');


    Route::get('/mahasiswa/pendaftaran', function () {
        return view('dashboard.mahasiswa.pendaftaran');
    })->name('mahasiswa.pendaftaran');


    Route::get('/mahasiswa/pesan-makanan', function () {
        return view('dashboard.mahasiswa.pesan-makanan');
    })->name('mahasiswa.pesan');


    Route::get('/mahasiswa/pesanan-saya', function () {
        return view('dashboard.mahasiswa.pesanan-saya');
    })->name('mahasiswa.pesanan');


    Route::get('/mahasiswa/riwayat-pesanan', function () {
        return view('dashboard.mahasiswa.riwayat-pesanan');
    })->name('mahasiswa.riwayat');


    Route::get('/mahasiswa/profil', function () {
        $mahasiswa = Auth::user();

        return view('dashboard.mahasiswa.profil', compact('mahasiswa'));
    })->name('mahasiswa.profil');


    Route::get('/mahasiswa/profil/edit', function () {
        $mahasiswa = Auth::user();

        return view('dashboard.mahasiswa.edit-profil', compact('mahasiswa'));
    })->name('mahasiswa.profil.edit');


    Route::patch('/mahasiswa/profil', function (Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['nullable', 'string', 'max:30'],
            'fakultas' => ['nullable', 'string', 'max:255'],
            'prodi' => ['nullable', 'string', 'max:255'],
            'angkatan' => ['nullable', 'string', 'max:10'],
            'kontak' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $mahasiswa = Auth::user();

        $fotoPath = $mahasiswa->foto;

        if ($request->hasFile('foto')) {
            // [PERUBAHAN] Simpan foto profil mahasiswa
            $fotoPath = $request->file('foto')->store('mahasiswa', 'public');
        }

        $mahasiswa->update([
            'name' => $request->name,
            'nim' => $request->nim,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('mahasiswa.profil')
            ->with('success', 'Profil mahasiswa berhasil diperbarui.');
    })->name('mahasiswa.profil.update');

    Route::get('/penjual/dashboard', function () {
        $warung = Warung::where('user_id', Auth::id())->first();

        $totalMenu = 0;
        $menuTersedia = 0;
        $pesananMasuk = 0;
        $pesananSelesai = 0;
        $pesananTerbaru = collect();

        if ($warung) {
            $totalMenu = Menu::where('warung_id', $warung->id)->count();

            $menuTersedia = Menu::where('warung_id', $warung->id)
                ->where('tersedia', '1')
                ->count();

            if (Schema::hasTable('orders')) {
                $pesananMasuk = DB::table('orders')
                    ->where('warung_id', $warung->id)
                    ->whereIn('status', ['menunggu', 'diproses', 'siap'])
                    ->count();

                $pesananSelesai = DB::table('orders')
                    ->where('warung_id', $warung->id)
                    ->where('status', 'selesai')
                    ->count();

                $pesananTerbaru = DB::table('orders')
                    ->where('warung_id', $warung->id)
                    ->latest()
                    ->take(5)
                    ->get();
            }
        }

        return view('dashboard.penjual.index', compact(
            'warung',
            'totalMenu',
            'menuTersedia',
            'pesananMasuk',
            'pesananSelesai',
            'pesananTerbaru'
        ));
    })->name('penjual.dashboard');

    Route::get('/penjual/menu', function () {
        $warung = Warung::where('user_id', Auth::id())->first();
        $menus = collect();

        if ($warung) {
            $menus = Menu::where('warung_id', $warung->id)
                ->latest()
                ->get();
        }

        return view('dashboard.penjual.menu', compact('warung', 'menus'));
    })->name('penjual.menu');

    Route::get('/penjual/menu/tambah', function () {
        return view('dashboard.penjual.tambah-menu');
    })->name('penjual.menu.tambah');

    Route::post('/penjual/menu', function (Request $request) {
        $request->validate([
            'nama_menu' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'string'],
            'deskripsi' => ['nullable', 'string'],
            'varian' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $warung = Warung::where('user_id', Auth::id())->first();

        if (!$warung) {
            return redirect()->route('penjual.profil')->with('error', 'Lengkapi profil warung terlebih dahulu.');
        }

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('menu', 'public');
        }

        Menu::create([
            'warung_id' => $warung->id,
            'nama' => $request->nama_menu,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'varian' => $request->varian,
            'tersedia' => $request->status === 'tersedia' ? 1 : 0,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('penjual.menu');
    })->middleware(['auth'])->name('penjual.menu.store');

    Route::get('/penjual/menu/{menu}/edit', function (Menu $menu) {
        $warung = Warung::where('user_id', Auth::id())->first();

        if (!$warung || $menu->warung_id !== $warung->id) {
            abort(403);
        }

        return view('dashboard.penjual.edit-menu', compact('menu'));
    })->name('penjual.menu.edit');


    Route::put('/penjual/menu/{menu}', function (Request $request, Menu $menu) {
        $request->validate([
            'nama_menu' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'string'],
            'deskripsi' => ['nullable', 'string'],
            'varian' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $warung = Warung::where('user_id', Auth::id())->first();

        if (!$warung || $menu->warung_id !== $warung->id) {
            abort(403);
        }

        $fotoPath = $menu->foto;

        if ($request->hasFile('foto')) {
            // [PERUBAHAN] Simpan foto baru jika pengguna mengunggah foto baru
            $fotoPath = $request->file('foto')->store('menu', 'public');
        }

        $menu->update([
            'nama' => $request->nama_menu,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'varian' => $request->varian,
            'tersedia' => $request->status === 'tersedia' ? 1 : 0,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('penjual.menu')->with('success', 'Menu berhasil diperbarui.');
    })->name('penjual.menu.update');


    Route::delete('/penjual/menu/{menu}', function (Menu $menu) {
        $warung = Warung::where('user_id', Auth::id())->first();

        if (!$warung || $menu->warung_id !== $warung->id) {
            abort(403);
        }

        $menu->delete();

        return redirect()->route('penjual.menu')->with('success', 'Menu berhasil dihapus.');
    })->name('penjual.menu.destroy');

    Route::get('/penjual/pesanan', function () {
        return view('dashboard.penjual.pesanan');
    })->name('penjual.pesanan');

    Route::get('/penjual/profil', function () {
        $warung = Warung::where('user_id', Auth::id())->first();

        return view('dashboard.penjual.profil', compact('warung'));
    })->name('penjual.profil');

    Route::get('/penjual/profil/edit', function () {
        $warung = Warung::where('user_id', Auth::id())->first();

        return view('dashboard.penjual.edit-profil', compact('warung'));
    })->name('penjual.profil.edit');


    Route::patch('/penjual/profil', function (Request $request) {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:buka,tutup'],
            'kategori' => ['required', 'in:makanan,minuman,snack'],
            'kontak' => ['nullable', 'string', 'max:30'],
            'area_kampus' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'estimasi_waktu' => ['nullable', 'string', 'max:100'],
            'jam_buka' => ['nullable', 'date_format:H:i'],
            'jam_tutup' => ['nullable', 'date_format:H:i'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $warung = Warung::firstOrNew([
            'user_id' => Auth::id(),
        ]);

        $fotoPath = $warung->foto;

        if ($request->hasFile('foto')) {
            // [PERUBAHAN] Simpan foto profil warung
            $fotoPath = $request->file('foto')->store('warung', 'public');
        }

        $warung->fill([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'kategori' => $request->kategori,
            'kontak' => $request->kontak,
            'area_kampus' => $request->area_kampus,
            'alamat' => $request->alamat,
            'estimasi_waktu' => $request->estimasi_waktu,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'foto' => $fotoPath,
        ]);

        $warung->save();

        return redirect()->route('penjual.profil')
            ->with('success', 'Profil warung berhasil diperbarui.');
    })->name('penjual.profil.update');

    Route::get('/admin/dashboard', function () {
        $totalMahasiswa = User::where('role', 'pembeli')->count();
        $totalPenjual = User::where('role', 'penjual')->count();
        $totalWarung = Warung::count();
        $warungPending = Warung::where('status_verifikasi', 'pending')->count();

        return view('dashboard.admin.index', compact(
            'totalMahasiswa',
            'totalPenjual',
            'totalWarung',
            'warungPending'
        ));
    })->name('admin.dashboard');


    Route::get('/admin/verifikasi-warung', function () {
        $warungs = Warung::with('user')
            ->where('status_verifikasi', 'pending')
            ->latest()
            ->get();

        return view('dashboard.admin.verifikasi-warung', compact('warungs'));
    })->name('admin.verifikasi-warung');


    Route::patch('/admin/verifikasi-warung/{warung}', function (Request $request, Warung $warung) {
        $request->validate([
            'status_verifikasi' => ['required', 'in:disetujui,ditolak'],
            'catatan_verifikasi' => ['nullable', 'string'],
        ]);

        $warung->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'diverifikasi_oleh' => Auth::id(),
            'diverifikasi_pada' => now(),
        ]);

        return redirect()->route('admin.verifikasi-warung')
            ->with('success', 'Status verifikasi warung berhasil diperbarui.');
    })->name('admin.verifikasi-warung.update');


    Route::get('/admin/users', function (Request $request) {
        $search = $request->query('search');

        // [PERUBAHAN] Admin bisa mencari user berdasarkan nama, email, role, NIM, fakultas, atau prodi
        $users = User::whereIn('role', ['pembeli', 'penjual'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%")
                        ->orWhere('fakultas', 'like', "%{$search}%")
                        ->orWhere('prodi', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('dashboard.admin.users', compact('users', 'search'));
    })->name('admin.users');


    Route::patch('/admin/users/{user}/toggle-status', function (User $user) {
        if ($user->role === 'admin') {
            abort(403);
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Status akun user berhasil diperbarui.');
    })->name('admin.users.toggle-status');

    Route::get('/admin/warungs', function (Request $request) {
        $search = $request->query('search');

        // [PERUBAHAN] Admin bisa mencari warung berdasarkan nama, pemilik, area, alamat, status
        $warungs = Warung::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('area_kampus', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere('status_verifikasi', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->get();

        return view('dashboard.admin.warungs', compact('warungs', 'search'));
    })->name('admin.warungs');

    Route::get('/admin/warungs/{warung}/edit', function (Warung $warung) {
        return view('dashboard.admin.edit-warung', compact('warung'));
    })->name('admin.warungs.edit');


    Route::patch('/admin/warungs/{warung}', function (Request $request, Warung $warung) {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:buka,tutup'],
            'kategori' => ['required', 'in:makanan,minuman,snack'],
            'kontak' => ['nullable', 'string', 'max:30'],
            'area_kampus' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'estimasi_waktu' => ['nullable', 'string', 'max:100'],
            'jam_buka' => ['nullable'],
            'jam_tutup' => ['nullable'],
            'status_verifikasi' => ['required', 'in:pending,disetujui,ditolak'],
            'catatan_verifikasi' => ['nullable', 'string'],
        ]);

        $warung->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'kategori' => $request->kategori,
            'kontak' => $request->kontak,
            'area_kampus' => $request->area_kampus,
            'alamat' => $request->alamat,
            'estimasi_waktu' => $request->estimasi_waktu,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'diverifikasi_oleh' => Auth::id(),
            'diverifikasi_pada' => now(),
        ]);

        return redirect()->route('admin.warungs')
            ->with('success', 'Data warung berhasil diperbarui.');
    })->name('admin.warungs.update');

    Route::get('/admin/profil', function () {
        return view('dashboard.admin.profil');
    })->name('admin.profil');

    Route::get('/admin/users/{user}/edit', function (User $user) {
        if ($user->role === 'admin') {
            abort(403);
        }

        return view('dashboard.admin.edit-user', compact('user'));
    })->name('admin.users.edit');


    Route::patch('/admin/users/{user}', function (Request $request, User $user) {
        if ($user->role === 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', Rule::in(['pembeli', 'penjual'])],
            'nim' => ['nullable', 'string', 'max:30'],
            'fakultas' => ['nullable', 'string', 'max:255'],
            'prodi' => ['nullable', 'string', 'max:255'],
            'angkatan' => ['nullable', 'string', 'max:10'],
            'kontak' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nim' => $request->nim,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'is_active' => $request->has('is_active'),
        ];

        // [PERUBAHAN] Password hanya diganti jika admin mengisi password baru
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')
            ->with('success', 'Data user berhasil diperbarui.');
    })->name('admin.users.update');

});

require __DIR__.'/auth.php';