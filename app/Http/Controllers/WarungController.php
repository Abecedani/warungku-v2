<?php

namespace App\Http\Controllers;

use App\Models\Warung;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WarungController extends Controller
{
    // ===== PUBLIC =====
    public function index()
    {
        $warungs = Warung::where('is_verified', true)->get();
        return view('pembeli.warungs', compact('warungs'));
    }

    // ===== PENJUAL =====
    public function create()
    {
        return view('warungs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_detail' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Warung::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'location_detail' => $request->location_detail,
            'description' => $request->description,
            'is_open' => false,
        ]);

        return redirect()->route('dashboard')->with('success', 'Warung berhasil didaftarkan!');
    }

    public function dashboard()
    {
        $warung = auth()->user()->warung;
        if (!$warung) {
            return redirect()->route('warungs.create');
        }
        $menus = $warung->menus;
        return view('warungs.dashboard', compact('warung', 'menus'));
    }

    public function toggleStatus(Request $request)
    {
        $warung = auth()->user()->warung;
        $warung->is_open = !$warung->is_open;
        $warung->save();
        return response()->json(['is_open' => (bool) $warung->is_open]);
    }

    public function profil()
    {
        $warung = auth()->user()->warung;
        return view('warungs.profil', compact('warung'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_detail' => 'required|string',
            'description' => 'nullable|string',
        ]);

        auth()->user()->warung->update($request->only('name', 'location_detail', 'description'));
        return back()->with('success', 'Profil warung berhasil diupdate!');
    }

    public function destroyWarung()
    {
        $warung = auth()->user()->warung;
        $warung->delete();
        return redirect()->route('warungs.create')->with('success', 'Warung berhasil dihapus.');
    }
    public function destroyImage($image)
    {
        Storage::disk('public')->delete($image);
        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function editAkun()
    {
        $user = auth()->user();
        return view('warungs.akun', compact('user'));
    }

    public function updateAkun(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update($request->only('name', 'email', 'phone_number'));

        if ($request->filled('password')) {
            if (!\Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Password lama salah.');
            }
            $user->update(['password' => \Hash::make($request->password)]);
        }

        return back()->with('success', 'Akun berhasil diupdate!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|image|max:2048']);

        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Foto profil berhasil diupdate!');
    }
}