<x-guest-layout>
    <!-- Session Status -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda">
            @error('name')
                <small style="color: #dc3545; margin-top: 0.25rem;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Masukkan email Anda">
            @error('email')
                <small style="color: #dc3545; margin-top: 0.25rem;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Role Selection (for admin registration) -->
        <div class="form-group">
            <label for="role">Peran</label>
            <select id="role" name="role" required style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #eee; border-radius: 6px; font-size: 0.875rem; transition: all 0.2s; box-sizing: border-box;">
                <option value="kasir">Kasir</option>
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
            </select>
        </div>

        <!-- Phone Number -->
        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required placeholder="Masukkan nomor telepon Anda">
            @error('phone')
                <small style="color: #dc3545; margin-top: 0.25rem;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Masukkan password (min. 8 karakter)">
            @error('password')
                <small style="color: #dc3545; margin-top: 0.25rem;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password Anda">
            @error('password_confirmation')
                <small style="color: #dc3545; margin-top: 0.25rem;">{{ $message }}</small>
            @enderror
        </div>

        <!-- Terms and Conditions -->
        <div class="checkbox-group" style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem;">
            <input id="terms" type="checkbox" name="terms" required style="width: auto; cursor: pointer; accent-color: var(--primary);">
            <label for="terms" style="margin: 0; cursor: pointer; color: #666; font-weight: 500; font-size: 0.875rem;">
                Saya setuju dengan syarat dan ketentuan
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">
            <i class="fas fa-user-plus"></i> Daftar Sekarang
        </button>

        <!-- Login Link -->
        <div style="text-align: center; margin-top: 1.5rem;">
            <p style="color: #666; font-size: 0.875rem;">
                Sudah punya akun? 
                <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Masuk di sini</a>
            </p>
        </div>
    </form>

    <style>
        :root {
            --primary: #ff6b35;
            --primary-dark: #ff8c61;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #eee;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-group input::placeholder {
            color: #ccc;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
        }

        .alert {
            padding: 0.875rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .alert-danger {
            background: #fee;
            color: #c00;
            border: 1px solid #fcc;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        .alert li {
            margin-bottom: 0.25rem;
        }

        small {
            display: block;
            margin-top: 0.25rem;
        }
    </style>
</x-guest-layout>
