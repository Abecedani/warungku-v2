<x-guest-layout>
    {{-- Bagian Header & Logo --}}
    <div class="text-center mb-5">
        <h4 class="fw-bold">Selamat Datang Kembali</h4>
        <p class="text-muted small mb-4">Masuk ke akun WarungKu kamu.</p>
        <img src="{{ asset('images/WarungKu-Logo.png') }}" alt="Logo WarungKu" class="mx-auto" style="height: 60px; width: auto;">
    </div>

    {{-- Session Status (Untuk nampilin pesan error/sukses dari Laravel) --}}
    <x-auth-session-status class="mb-4 text-success text-center fw-bold" :status="session('status')" />

    {{-- Form Login --}}
    <div class="text-start">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Input Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small text-secondary">Email</label>
                <input type="email" id="email" name="email" class="form-control p-2" value="{{ old('email') }}" required autofocus>
                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            {{-- Input Password + Tombol Mata --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control p-2 border-end-0" required>
                    <button class="btn border border-start-0 bg-white toggle-password text-secondary" type="button" data-target="password">
                        <i class="bi bi-eye" id="icon-password"></i>
                    </button>
                </div>
                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label small text-secondary">Ingat saya</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="text-muted small text-decoration-none" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('register') }}" class="text-muted small text-decoration-none">Belum punya akun?</a>
                <button type="submit" class="btn text-white px-4 py-2 fw-bold" style="background-color: #f4511e; border-radius: 8px;">
                    Masuk
                </button>
            </div>
        </form>
    </div>

    {{-- Script Show/Hide Password (Sama seperti di Register) --}}
    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = document.getElementById('icon-' + targetId);

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    </script>
</x-guest-layout>