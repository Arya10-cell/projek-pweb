<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AntriNik')</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: #ffffff;
            color: #1f2937;
            line-height: 1.5;
            font-size: 14px;
        }
        header {
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 0;
            margin-bottom: 32px;
        }
        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand {
            font-weight: 700;
            font-size: 16px;
            color: #111827;
            text-decoration: none;
        }
        .nav-links a {
            color: #4b5563;
            text-decoration: none;
            margin-left: 20px;
        }
        .nav-links a:hover {
            color: #111827;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
        }
        .btn {
            display: inline-block;
            padding: 8px 14px;
            font-size: 14px;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #1f2937;
        }
        .btn:hover {
            background: #f3f4f6;
        }
        .btn-primary {
            background: #111827;
            color: #ffffff;
            border-color: #111827;
        }
        .btn-primary:hover {
            background: #374151;
        }
        .alert {
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #d1d5db;
            background: #f9fafb;
        }
        .alert-error {
            border-color: #fca5a5;
            background: #fef2f2;
            color: #991b1b;
        }
        .alert-error ul {
            margin-left: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }
        th {
            font-weight: 600;
            color: #6b7280;
            font-size: 13px;
        }
        .subtext {
            display: block;
            font-size: 12px;
            color: #6b7280;
        }
        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            border: none;
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .icon-edit {
            color: #374151;
        }
        .icon-edit:hover {
            background: #f3f4f6;
            color: #111827;
        }
        .icon-delete {
            color: #dc2626;
        }
        .icon-delete:hover {
            background: #fef2f2;
            color: #b91c1c;
        }
        .form-box {
            max-width: 520px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #374151;
        }
        input, select {
            width: 100%;
            padding: 8px 10px;
            font: inherit;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: #ffffff;
        }
        input:focus, select:focus {
            outline: 2px solid #111827;
            border-color: #111827;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
        }
        .empty {
            text-align: center;
            color: #6b7280;
            padding: 32px 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="container nav">
            <a href="{{ route('jadwal-dokter.index') }}" class="brand">AntriNik</a>
            <nav class="nav-links">
                <a href="{{ route('jadwal-dokter.index') }}">Jadwal Dokter</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>
