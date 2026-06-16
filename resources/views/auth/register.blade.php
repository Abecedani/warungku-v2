<x-guest-layout>
    <div class="text-center mb-6">
        <img src="{{ asset('images/WarungKu-Logo.png') }}" alt="Logo WarungKu" class="mx-auto" style="height: 60px; width: auto;">

        <h4 class="fw-bold">Buat Akun Baru</h4>
        <p class="text-muted small">Gabung di WarungKu sekarang!</p>
    </div>

    <div id="step-role">
        <p class="text-center fw-semibold mb-3">Daftar sebagai apa?</p>

        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="role-card p-4 text-center rounded-3 border" onclick="pilihRole('pembeli')" style="cursor: pointer;">
                    <i class="bi bi-mortarboard fs-2 text-orange d-block mb-2"></i>
                    <div class="fw-bold">Mahasiswa</div>
                    <div class="text-muted small">Cari & order menu warung kampus</div>
                </div>
            </div>

            <div class="col-6">
                <div class="role-card p-4 text-center rounded-3 border" onclick="pilihRole('penjual')" style="cursor: pointer;">
                    <i class="bi bi-shop fs-2 text-orange d-block mb-2"></i>
                    <div class="fw-bold">Pemilik Warung</div>
                    <div class="text-muted small">Daftarkan & kelola warungmu</div>
                </div>
            </div>
        </div>

        <p class="text-center small">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-orange fw-bold">Masuk di sini</a>
        </p>
    </div>

    <div id="step-form" style="display: none;" class="text-start">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input type="hidden" name="role" id="role-input" value="{{ old('role') }}">

            <p class="text-center text-muted small mb-4">
                Daftar sebagai <span id="role-label" class="fw-bold" style="color: #f4511e;"></span>
            </p>

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold small text-secondary" id="name-label">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control p-2" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3" id="nama-warung-group" style="display: none;">
                <label for="nama_warung" class="form-label fw-semibold small text-secondary">Nama Warung</label>
                <input type="text" id="nama_warung" name="nama_warung" class="form-control p-2" value="{{ old('nama_warung') }}">
                @error('nama_warung')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small text-secondary">Email</label>
                <input type="email" id="email" name="email" class="form-control p-2" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control p-2 border-end-0" required>
                    <button class="btn border border-start-0 bg-white toggle-password text-secondary" type="button" data-target="password">
                        <i class="bi bi-eye" id="icon-password"></i>
                    </button>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold small text-secondary">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control p-2 border-end-0" required>
                    <button class="btn border border-start-0 bg-white toggle-password text-secondary" type="button" data-target="password_confirmation">
                        <i class="bi bi-eye" id="icon-password_confirmation"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="button" onclick="kembali()" class="btn btn-link text-muted small text-decoration-none p-0">
                    Kembali
                </button>

                <button type="submit" class="btn text-white px-4 py-2 fw-bold" style="background-color: #f4511e; border-radius: 8px;">
                    Daftar
                </button>
            </div>

            <p class="text-center small mt-3 mb-0">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-orange fw-bold text-decoration-none">Masuk di sini</a>
            </p>
        </form>
    </div>

    <script>
        function pilihRole(role) {
            const roleInput = document.getElementById('role-input');
            const roleLabel = document.getElementById('role-label');
            const nameLabel = document.getElementById('name-label');
            const namaWarungGroup = document.getElementById('nama-warung-group');
            const namaWarungInput = document.getElementById('nama_warung');

            roleInput.value = role;

            if (role === 'penjual') {
                roleLabel.innerText = 'Pemilik Warung';
                nameLabel.innerText = 'Nama Lengkap Pemilik';
                namaWarungGroup.style.display = 'block';
                namaWarungInput.required = true;
            } else if (role === 'pembeli') {
                roleLabel.innerText = 'Mahasiswa';
                nameLabel.innerText = 'Nama Lengkap';
                namaWarungGroup.style.display = 'none';
                namaWarungInput.required = false;
                namaWarungInput.value = '';
            }

            document.getElementById('step-role').style.display = 'none';
            document.getElementById('step-form').style.display = 'block';
        }

        function kembali() {
            document.getElementById('step-role').style.display = 'block';
            document.getElementById('step-form').style.display = 'none';
        }

        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
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

        @if($errors->any())
            pilihRole('{{ old('role', 'pembeli') }}');
        @endif
    </script>
</x-guest-layout>