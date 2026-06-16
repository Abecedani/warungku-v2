<?php

use App\Models\User;
use App\Models\Warung;
use App\Models\Menu;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarungController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// =============================
// PUBLIC ROUTES
// =============================

Route::get('/', [WarungController::class, 'home'])->name('home');
Route::get('/warung', [WarungController::class, 'index'])->name('warung.index');
Route::get('/warung/{id}', function ($id) {
    return view('public.warung.show', compact('id'));
})->name('warung.show');

// =============================
// AUTH ROUTES
// =============================

Route::middleware('auth')->group(function () {

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =============================
    // MAHASISWA ROUTES
    // =============================

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', fn() => view('dashboard.mahasiswa.index'))->name('dashboard');
        Route::get('/pendaftaran', fn() => view('dashboard.mahasiswa.pendaftaran'))->name('pendaftaran');
        Route::get('/pesan-makanan', fn() => view('dashboard.mahasiswa.pesan-makanan'))->name('pesan');
        Route::get('/pesanan-saya', fn() => view('dashboard.mahasiswa.pesanan-saya'))->name('pesanan');
        Route::get('/riwayat-pesanan', fn() => view('dashboard.mahasiswa.riwayat-pesanan'))->name('riwayat');

        Route::get('/profil', function () {
            return view('dashboard.mahasiswa.profil', ['mahasiswa' => Auth::user()]);
        })->name('profil');

        Route::get('/profil/edit', function () {
            return view('dashboard.mahasiswa.edit-profil', ['mahasiswa' => Auth::user()]);
        })->name('profil.edit');

        Route::patch('/profil', function (Request $request) {
            $request->validate([
                'name'     => ['required', 'string', 'max:255'],
                'nim'      => ['nullable', 'string', 'max:30'],
                'fakultas' => ['nullable', 'string', 'max:255'],
                'prodi'    => ['nullable', 'string', 'max:255'],
                'angkatan' => ['nullable', 'string', 'max:10'],
                'kontak'   => ['nullable', 'string', 'max:30'],
                'alamat'   => ['nullable', 'string'],
                'foto'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);

            $mahasiswa = Auth::user();
            $fotoPath = $mahasiswa->foto;

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('mahasiswa', 'public');
            }

            $mahasiswa->update([
                'name'     => $request->name,
                'nim'      => $request->nim,
                'fakultas' => $request->fakultas,
                'prodi'    => $request->prodi,
                'angkatan' => $request->angkatan,
                'kontak'   => $request->kontak,
                'alamat'   => $request->alamat,
                'foto'     => $fotoPath,
            ]);

            return redirect()->route('mahasiswa.profil')->with('success', 'Profil mahasiswa berhasil diperbarui.');
        })->name('profil.update');
    });

    // =============================
    // PENJUAL ROUTES
    // =============================

    Route::prefix('penjual')->name('penjual.')->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            $warung = Warung::where('user_id', Auth::id())->first();
            $totalMenu    = $warung ? Menu::where('warung_id', $warung->id)->count() : 0;
            $menuTersedia = $warung ? Menu::where('warung_id', $warung->id)->where('tersedia', 1)->count() : 0;
            $pesananMasuk   = 0;
            $pesananSelesai = 0;
            $pesananTerbaru = collect();

            if ($warung && Schema::hasTable('orders')) {
                $pesananMasuk = DB::table('orders')->where('warung_id', $warung->id)
                    ->whereIn('status', ['menunggu', 'diproses', 'siap'])->count();
                $pesananSelesai = DB::table('orders')->where('warung_id', $warung->id)
                    ->where('status', 'selesai')->count();
                $pesananTerbaru = DB::table('orders')->where('warung_id', $warung->id)
                    ->latest()->take(5)->get();
            }

            return view('dashboard.penjual.index', compact(
                'warung', 'totalMenu', 'menuTersedia',
                'pesananMasuk', 'pesananSelesai', 'pesananTerbaru'
            ));
        })->name('dashboard');

        // Toggle Status Buka/Tutup
        Route::patch('/toggle-status', function () {
            $warung = Warung::where('user_id', Auth::id())->first();
            if ($warung) {
                $warung->update(['status' => $warung->status === 'buka' ? 'tutup' : 'buka']);
            }
            return back()->with('success', 'Status warung berhasil diubah!');
        })->name('toggle-status');

        // Menu
        Route::get('/menu', function () {
            $warung = Warung::where('user_id', Auth::id())->first();
            $menus  = $warung ? Menu::where('warung_id', $warung->id)->latest()->get() : collect();
            return view('dashboard.penjual.menu', compact('warung', 'menus'));
        })->name('menu');

        Route::get('/menu/tambah', fn() => view('dashboard.penjual.tambah-menu'))->name('menu.tambah');

        Route::post('/menu', function (Request $request) {
            $request->validate([
                'nama_menu' => ['required', 'string', 'max:255'],
                'harga'     => ['required', 'integer', 'min:0'],
                'deskripsi' => ['nullable', 'string'],
                'varian'    => ['nullable', 'string', 'max:255'],
                'status'    => ['required', 'string'],
                'foto'      => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ]);

            $warung = Warung::where('user_id', Auth::id())->first();
            if (!$warung) {
                return redirect()->route('penjual.profil')->with('error', 'Lengkapi profil warung terlebih dahulu.');
            }

            $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('menu', 'public') : null;

            Menu::create([
                'warung_id' => $warung->id,
                'nama'      => $request->nama_menu,
                'harga'     => $request->harga,
                'deskripsi' => $request->deskripsi,
                'varian'    => $request->varian,
                'tersedia'  => $request->status === 'tersedia' ? 1 : 0,
                'foto'      => $fotoPath,
            ]);

            return redirect()->route('penjual.menu')->with('success', 'Menu berhasil ditambahkan.');
        })->name('menu.store');

        Route::get('/menu/{menu}/edit', function (Menu $menu) {
            $warung = Warung::where('user_id', Auth::id())->first();
            if (!$warung || $menu->warung_id !== $warung->id) abort(403);
            return view('dashboard.penjual.edit-menu', compact('menu'));
        })->name('menu.edit');

        Route::put('/menu/{menu}', function (Request $request, Menu $menu) {
            $request->validate([
                'nama_menu' => ['required', 'string', 'max:255'],
                'harga'     => ['required', 'integer', 'min:0'],
                'deskripsi' => ['nullable', 'string'],
                'varian'    => ['nullable', 'string', 'max:255'],
                'status'    => ['required', 'string'],
                'foto'      => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ]);

            $warung = Warung::where('user_id', Auth::id())->first();
            if (!$warung || $menu->warung_id !== $warung->id) abort(403);

            $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('menu', 'public') : $menu->foto;

            $menu->update([
                'nama'     => $request->nama_menu,
                'harga'    => $request->harga,
                'deskripsi'=> $request->deskripsi,
                'varian'   => $request->varian,
                'tersedia' => $request->status === 'tersedia' ? 1 : 0,
                'foto'     => $fotoPath,
            ]);

            return redirect()->route('penjual.menu')->with('success', 'Menu berhasil diperbarui.');
        })->name('menu.update');

        Route::delete('/menu/{menu}', function (Menu $menu) {
            $warung = Warung::where('user_id', Auth::id())->first();
            if (!$warung || $menu->warung_id !== $warung->id) abort(403);
            $menu->delete();
            return redirect()->route('penjual.menu')->with('success', 'Menu berhasil dihapus.');
        })->name('menu.destroy');

        // Pesanan
        Route::get('/pesanan', fn() => view('dashboard.penjual.pesanan'))->name('pesanan');

        // Profil Warung
        Route::get('/profil', function () {
            $warung = Warung::where('user_id', Auth::id())->first();
            return view('dashboard.penjual.profil', compact('warung'));
        })->name('profil');

        Route::get('/profil/edit', function () {
            $warung = Warung::where('user_id', Auth::id())->first();
            return view('dashboard.penjual.edit-profil', compact('warung'));
        })->name('profil.edit');

        Route::patch('/profil', function (Request $request) {
            $request->validate([
                'nama'          => ['required', 'string', 'max:255'],
                'deskripsi'     => ['nullable', 'string'],
                'status'        => ['required', 'in:buka,tutup'],
                'kategori'      => ['required', 'in:makanan,minuman,snack'],
                'kontak'        => ['nullable', 'string', 'max:30'],
                'area_kampus'   => ['nullable', 'string', 'max:255'],
                'alamat'        => ['nullable', 'string'],
                'estimasi_waktu'=> ['nullable', 'string', 'max:100'],
                'jam_buka'      => ['nullable', 'date_format:H:i'],
                'jam_tutup'     => ['nullable', 'date_format:H:i'],
                'foto'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);

            $warung   = Warung::firstOrNew(['user_id' => Auth::id()]);
            $fotoPath = $warung->foto;

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('warung', 'public');
            }

            $warung->fill([
                'nama'          => $request->nama,
                'deskripsi'     => $request->deskripsi,
                'status'        => $request->status,
                'kategori'      => $request->kategori,
                'kontak'        => $request->kontak,
                'area_kampus'   => $request->area_kampus,
                'alamat'        => $request->alamat,
                'estimasi_waktu'=> $request->estimasi_waktu,
                'jam_buka'      => $request->jam_buka,
                'jam_tutup'     => $request->jam_tutup,
                'foto'          => $fotoPath,
            ])->save();

            return redirect()->route('penjual.profil')->with('success', 'Profil warung berhasil diperbarui.');
        })->name('profil.update');
    });

    // =============================
    // ADMIN ROUTES
    // =============================

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard.admin.index', [
                'totalMahasiswa' => User::where('role', 'pembeli')->count(),
                'totalPenjual'   => User::where('role', 'penjual')->count(),
                'totalWarung'    => Warung::count(),
                'warungPending'  => Warung::where('status_verifikasi', 'pending')->count(),
            ]);
        })->name('dashboard');

        Route::get('/verifikasi-warung', function () {
            $warungs = Warung::with('user')->where('status_verifikasi', 'pending')->latest()->get();
            return view('dashboard.admin.verifikasi-warung', compact('warungs'));
        })->name('verifikasi-warung');

        Route::patch('/verifikasi-warung/{warung}', function (Request $request, Warung $warung) {
            $request->validate([
                'status_verifikasi'  => ['required', 'in:disetujui,ditolak'],
                'catatan_verifikasi' => ['nullable', 'string'],
            ]);
            $warung->update([
                'status_verifikasi'  => $request->status_verifikasi,
                'catatan_verifikasi' => $request->catatan_verifikasi,
                'diverifikasi_oleh'  => Auth::id(),
                'diverifikasi_pada'  => now(),
            ]);
            return redirect()->route('admin.verifikasi-warung')->with('success', 'Status verifikasi berhasil diperbarui.');
        })->name('verifikasi-warung.update');

        Route::get('/users', function (Request $request) {
            $search = $request->query('search');
            $users  = User::whereIn('role', ['pembeli', 'penjual'])
                ->when($search, fn($q) => $q->where(fn($q) =>
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%")
                      ->orWhere('fakultas', 'like', "%{$search}%")
                      ->orWhere('prodi', 'like', "%{$search}%")
                ))->latest()->get();
            return view('dashboard.admin.users', compact('users', 'search'));
        })->name('users');

        Route::patch('/users/{user}/toggle-status', function (User $user) {
            if ($user->role === 'admin') abort(403);
            $user->update(['is_active' => !$user->is_active]);
            return redirect()->route('admin.users')->with('success', 'Status akun berhasil diperbarui.');
        })->name('users.toggle-status');

        Route::get('/users/{user}/edit', function (User $user) {
            if ($user->role === 'admin') abort(403);
            return view('dashboard.admin.edit-user', compact('user'));
        })->name('users.edit');

        Route::patch('/users/{user}', function (Request $request, User $user) {
            if ($user->role === 'admin') abort(403);
            $request->validate([
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'role'     => ['required', Rule::in(['pembeli', 'penjual'])],
                'nim'      => ['nullable', 'string', 'max:30'],
                'fakultas' => ['nullable', 'string', 'max:255'],
                'prodi'    => ['nullable', 'string', 'max:255'],
                'angkatan' => ['nullable', 'string', 'max:10'],
                'kontak'   => ['nullable', 'string', 'max:30'],
                'alamat'   => ['nullable', 'string'],
                'is_active'=> ['nullable', 'boolean'],
                'password' => ['nullable', 'confirmed', 'min:8'],
            ]);

            $data = $request->only(['name', 'email', 'role', 'nim', 'fakultas', 'prodi', 'angkatan', 'kontak', 'alamat']);
            $data['is_active'] = $request->has('is_active');
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui.');
        })->name('users.update');

        Route::get('/warungs', function (Request $request) {
            $search  = $request->query('search');
            $warungs = Warung::with('user')
                ->when($search, fn($q) => $q->where(fn($q) =>
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('area_kampus', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhere('status_verifikasi', 'like', "%{$search}%")
                      ->orWhereHas('user', fn($q) =>
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                      )
                ))->latest()->get();
            return view('dashboard.admin.warungs', compact('warungs', 'search'));
        })->name('warungs');

        Route::get('/warungs/{warung}/edit', fn(Warung $warung) =>
            view('dashboard.admin.edit-warung', compact('warung'))
        )->name('warungs.edit');

        Route::patch('/warungs/{warung}', function (Request $request, Warung $warung) {
            $request->validate([
                'nama'               => ['required', 'string', 'max:255'],
                'deskripsi'          => ['nullable', 'string'],
                'status'             => ['required', 'in:buka,tutup'],
                'kategori'           => ['required', 'in:makanan,minuman,snack'],
                'kontak'             => ['nullable', 'string', 'max:30'],
                'area_kampus'        => ['nullable', 'string', 'max:255'],
                'alamat'             => ['nullable', 'string'],
                'estimasi_waktu'     => ['nullable', 'string', 'max:100'],
                'jam_buka'           => ['nullable'],
                'jam_tutup'          => ['nullable'],
                'status_verifikasi'  => ['required', 'in:pending,disetujui,ditolak'],
                'catatan_verifikasi' => ['nullable', 'string'],
            ]);

            $warung->update([
                ...$request->only(['nama', 'deskripsi', 'status', 'kategori', 'kontak',
                    'area_kampus', 'alamat', 'estimasi_waktu', 'jam_buka', 'jam_tutup',
                    'status_verifikasi', 'catatan_verifikasi']),
                'diverifikasi_oleh' => Auth::id(),
                'diverifikasi_pada' => now(),
            ]);

            return redirect()->route('admin.warungs')->with('success', 'Data warung berhasil diperbarui.');
        })->name('warungs.update');

        Route::get('/profil', fn() => view('dashboard.admin.profil'))->name('profil');
    });
});

require __DIR__.'/auth.php';