<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Data pasien')</title>

    <style>
        :root {
            --navy: #001b3e;
            --ink: #000;
            --line: #d9dde3;
            --muted: #5b6472;
            --error: #b00020;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Helvetica Neue", Arial, sans-serif;
            color: var(--ink);
            background: #f6f7f9;
        }

        .wrap { max-width: 1040px; margin: 0 auto; padding: 32px 24px 56px; }

        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 28px;
        }

        h1 {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 2rem;
            line-height: 1.1;
        }

        .top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            height: 40px;
            padding: 0 18px;
            line-height: 40px;
            border: 1px solid var(--navy);
            border-radius: 6px;
            background: var(--navy);
            color: #fff;
            font: inherit;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover { background: #00306e; }

        .btn-outline { background: #fff; color: var(--navy); }
        .btn-outline:hover { background: #eef2f8; }

        .btn-danger { background: #fff; color: var(--error); border-color: var(--error); }
        .btn-danger:hover { background: #fdecea; }

        .btn-sm { height: 32px; line-height: 30px; padding: 0 12px; font-size: 0.875rem; }

        .btn:focus-visible, a:focus-visible, input:focus-visible,
        select:focus-visible, textarea:focus-visible {
            outline: 3px solid var(--navy);
            outline-offset: 2px;
        }

        .alert {
            padding: 10px 14px;
            margin-bottom: 18px;
            border-radius: 6px;
            font-size: 0.95rem;
        }
        .alert.ok  { background: #e6f4ea; color: #14532d; }
        .alert.err { background: #fdecea; color: var(--error); }

        .tabs { display: flex; gap: 20px; margin-bottom: 18px; border-bottom: 1px solid var(--line); }
        .tabs a {
            padding: 8px 2px;
            color: var(--muted);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 3px solid transparent;
            margin-bottom: -1px;
        }
        .tabs a.active { color: var(--navy); border-bottom-color: var(--navy); }

        .search { display: flex; gap: 8px; margin-bottom: 18px; }
        .search input { max-width: 280px; }

        .table-scroll { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
        th {
            text-align: left;
            padding: 10px 8px;
            color: var(--muted);
            font-weight: 600;
            border-bottom: 1px solid var(--ink);
            white-space: nowrap;
        }
        td { padding: 12px 8px; border-bottom: 1px solid var(--line); vertical-align: top; }
        .aksi { display: flex; gap: 6px; white-space: nowrap; }
        .kosong { padding: 28px 8px; text-align: center; color: var(--muted); }

        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .span2 { grid-column: 1 / -1; }

        label { display: block; margin-bottom: 6px; font-weight: 700; }

        input[type="text"], input[type="email"], input[type="search"], select, textarea {
            width: 100%;
            padding: 0 12px;
            font: inherit;
            border: 1px solid #222;
            border-radius: 6px;
            background: #fff;
        }
        input, select { height: 42px; }
        textarea { height: 96px; padding: 10px 12px; resize: vertical; }

        .field.has-error input, .field.has-error select, .field.has-error textarea { border-color: var(--error); }
        .error { margin: 6px 0 0; font-size: 0.875rem; color: var(--error); }

        .hint { margin: 0 0 20px; color: var(--muted); font-size: 0.95rem; }
        .form-actions { display: flex; gap: 10px; margin-top: 24px; }
        .back { display: inline-block; margin-bottom: 14px; color: var(--navy); font-weight: 600; }

        @media (max-width: 640px) {
            .grid { grid-template-columns: 1fr; }
            .top { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <main class="wrap">
        @if (session('success')) <div class="alert ok">{{ session('success') }}</div> @endif
        @if (session('error'))   <div class="alert err">{{ session('error') }}</div> @endif

        @yield('content')
    </main>
</body>
</html>