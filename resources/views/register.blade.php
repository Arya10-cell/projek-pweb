<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <style>
        :root {
            --navy: #001b3e;
            --ink: #000;
            --muted-bg: #cfd8e3;
            --error: #b00020;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            min-height: 100%;
            font-family: "Helvetica Neue", Arial, sans-serif;
            color: var(--ink);
            background: #fff;
        }

        .page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ===== Kolom kiri: form ===== */
        .panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .form-wrap {
            width: 100%;
            max-width: 420px;
        }

        h1 {
            margin: 0 0 28px;
            text-align: center;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .field { margin-bottom: 18px; }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        label.title {
            display: block;
            margin-bottom: 6px;
            font-size: 1rem;
            font-weight: 700;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 0 12px;
            font: inherit;
            border: 1px solid #222;
            border-radius: 6px;
            background: #fff;
            color: var(--ink);
        }

        input, select { height: 42px; }

        textarea {
            height: 84px;
            padding: 10px 12px;
            resize: vertical;
        }

        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible,
        button:focus-visible,
        .login a:focus-visible {
            outline: 3px solid var(--navy);
            outline-offset: 2px;
        }

        .has-error input,
        .has-error select,
        .has-error textarea { border-color: var(--error); }

        .error {
            margin: 6px 0 0;
            font-size: 0.875rem;
            color: var(--error);
        }

        button[type="submit"] {
            width: 100%;
            height: 48px;
            margin-top: 8px;
            border: 0;
            background: var(--navy);
            color: #fff;
            font: inherit;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
        }

        button[type="submit"]:hover { background: #00306e; }

        .login {
            margin: 20px 0 0;
            text-align: center;
            color: var(--navy);
        }

        .login a {
            color: var(--navy);
            font-weight: 600;
        }

        /* ===== Kolom kanan: foto ===== */
        .photo {
            background-color: var(--muted-bg);
            overflow: hidden;
        }

        .photo img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ===== Layar kecil ===== */
        @media (max-width: 800px) {
            .page { grid-template-columns: 1fr; }
            .photo { display: none; }
        }

        @media (max-width: 480px) {
            .row { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="panel">
            <div class="form-wrap">
                <h1>Sign Up</h1>

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <div class="field @error('nama') has-error @enderror">
                        <label class="title" for="nama">Full name</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                               autocomplete="name" required>
                        @error('nama') <p class="error">{{ $message }}</p> @enderror
                    </div>

                    <div class="field @error('email') has-error @enderror">
                        <label class="title" for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               autocomplete="email" required>
                        @error('email') <p class="error">{{ $message }}</p> @enderror
                    </div>

                    <div class="row">
                        <div class="field @error('password') has-error @enderror">
                            <label class="title" for="password">Password</label>
                            <input type="password" id="password" name="password"
                                   autocomplete="new-password" required>
                            @error('password') <p class="error">{{ $message }}</p> @enderror
                        </div>

                        <div class="field">
                            <label class="title" for="password_confirmation">Confirm password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   autocomplete="new-password" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="field @error('no_telepon') has-error @enderror">
                            <label class="title" for="no_telepon">Phone number</label>
                            <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                                   autocomplete="tel">
                            @error('no_telepon') <p class="error">{{ $message }}</p> @enderror
                        </div>

                        <div class="field @error('jenis_kelamin') has-error @enderror">
                            <label class="title" for="jenis_kelamin">Gender</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Select</option>
                                <option value="Laki-laki" @selected(old('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
                                <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <p class="error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="field @error('alamat') has-error @enderror">
                        <label class="title" for="alamat">Address</label>
                        <textarea id="alamat" name="alamat" autocomplete="street-address">{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="error">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit">Create Account</button>
                </form>

                <p class="login">
                    Already have an account?
                    <a href="{{ route('login') }}">Login</a>
                </p>
            </div>
        </section>

        <aside class="photo" aria-hidden="true">
            <img src="{{ asset('images/fotologin.jpg') }}" alt="">
        </aside>
    </main>
</body>
</html>