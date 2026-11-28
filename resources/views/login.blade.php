<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

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
            padding: 48px 24px;
        }

        .form-wrap {
            width: 100%;
            max-width: 490px;
        }

        h1 {
            margin: 0 0 40px;
            text-align: center;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .field { margin-bottom: 28px; }

        label.title {
            display: block;
            margin-bottom: 10px;
            font-size: 1.15rem;
            font-weight: 700;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            height: 48px;
            padding: 0 14px;
            font: inherit;
            border: 1px solid #222;
            border-radius: 6px;
            background: #fff;
        }

        input[type="email"]:focus-visible,
        input[type="password"]:focus-visible,
        .remember input:focus-visible,
        button:focus-visible,
        .register a:focus-visible {
            outline: 3px solid var(--navy);
            outline-offset: 2px;
        }

        .has-error input { border-color: var(--error); }

        .error {
            margin: 8px 0 0;
            font-size: 0.9rem;
            color: var(--error);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 32px;
            font-weight: 600;
            color: var(--navy);
            cursor: pointer;
        }

        .remember input {
            width: 28px;
            height: 28px;
            margin: 0;
            accent-color: var(--navy);
            cursor: pointer;
        }

        button[type="submit"] {
            width: 100%;
            height: 52px;
            border: 0;
            background: var(--navy);
            color: #fff;
            font: inherit;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
        }

        button[type="submit"]:hover { background: #00306e; }

        .register {
            margin: 24px 0 0;
            text-align: center;
            color: var(--navy);
        }

        .register a {
            color: var(--navy);
            font-weight: 600;
        }

        /* ===== Kolom kanan: foto ===== */
        .photo {
            background-color: var(--muted-bg);
            background-image: url("{{ asset('images/fotologin.jpg') }}");
            background-size: cover;
            background-position: center;
        }

        /* ===== Layar kecil: foto disembunyikan ===== */
        @media (max-width: 800px) {
            .page { grid-template-columns: 1fr; }
            .photo { display: none; }
            h1 { font-size: 2.4rem; }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="panel">
            <div class="form-wrap">
                <h1>Login</h1>

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <div class="field @error('email') has-error @enderror">
                        <label class="title" for="email">Email</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               autocomplete="email" required autofocus>
                        @error('email')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field @error('password') has-error @enderror">
                        <label class="title" for="password">Password</label>
                        <input type="password" id="password" name="password"
                               autocomplete="current-password" required>
                        @error('password')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="remember">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember Me
                    </label>

                    <button type="submit">Login</button>
                </form>

                <p class="register">
                    Don’t have an account?
                    <a href="{{ route('register') }}">Sign Up</a>
                </p>
            </div>
        </section>

        <aside class="photo" aria-hidden="true"></aside>
    </main>
</body>
</html>