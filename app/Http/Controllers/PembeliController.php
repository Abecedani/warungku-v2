<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PembeliController extends Controller
{
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['warung', 'orderItems.menu.images', 'warungRating'])
            ->latest()
            ->get();

        return view('pembeli.orders', compact('orders'));
    }

    public function editProfil()
    {
        $user = auth()->user();
        return view('pembeli.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
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

        return back()->with('success', 'Profil berhasil diupdate!');
    }
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Foto profil berhasil diupdate!');
    }

    public function destroy(Request $request)
    {
        $request->validate(['password' => 'required']);

        $user = auth()->user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah.');
        }

        auth()->logout();
        $user->delete();

        return redirect()->route('home')->with('success', 'Akun berhasil dihapus.');
    }
}