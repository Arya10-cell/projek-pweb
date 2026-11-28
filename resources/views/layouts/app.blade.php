<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AntriNik')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 text-sm antialiased flex flex-col md:flex-row min-h-screen print:block print:bg-white">
    @php
        $activeRole = auth()->check()
            ? strtolower(auth()->user()->role ?? 'admin')
            : session('demo_role', 'admin');
    @endphp

    <aside class="w-full md:w-60 bg-[#1d3584] text-white flex flex-col justify-between p-4 shrink-0 md:sticky md:top-0 md:h-screen print:hidden">
        <div>
            <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-2 pt-1 pb-6">
                <div class="w-9 h-9 bg-white/15 rounded-lg flex items-center justify-center font-bold text-base">
                    A
                </div>
                <div>
                    <div class="text-lg font-bold leading-tight">AntriNik</div>
                    <div class="text-[11px] text-indigo-200">Manajemen Klinik</div>
                </div>
            </a>

            <nav class="space-y-1.5">
                <a href="{{ route('dashboard.index') }}"
                   class="block px-3.5 py-2.5 rounded-lg font-medium transition {{ request()->routeIs('dashboard.*') ? 'bg-[#5a84f2] text-white font-semibold' : 'text-indigo-100 hover:bg-white/10' }}">
                    Dashboard
                </a>

                @if ($activeRole === 'admin')
                    <a href="{{ route('jadwal-dokter.index') }}"
                       class="block px-3.5 py-2.5 rounded-lg font-medium transition {{ request()->routeIs('jadwal-dokter.*') ? 'bg-[#5a84f2] text-white font-semibold' : 'text-indigo-100 hover:bg-white/10' }}">
                        Jadwal Dokter
                    </a>
                @endif

                @if (in_array($activeRole, ['admin', 'dokter']))
                    <a href="{{ route('laporan.index') }}"
                       class="block px-3.5 py-2.5 rounded-lg font-medium transition {{ request()->routeIs('laporan.*') ? 'bg-[#5a84f2] text-white font-semibold' : 'text-indigo-100 hover:bg-white/10' }}">
                        Laporan
                    </a>
                @endif
            </nav>
        </div>

        @if ($activeRole === 'admin')
            <div class="hidden md:block bg-[#2d49a3] rounded-xl p-4 mt-6">
                <p class="text-xs text-indigo-100 leading-relaxed mb-3">
                    Atur jadwal praktik dokter dan kuota poli dengan cepat
                </p>
                <a href="{{ route('jadwal-dokter.create') }}"
                   class="w-full bg-white text-[#1d3584] hover:bg-blue-50 rounded-lg px-3 py-2 text-xs font-semibold flex items-center justify-between">
                    <span>Tambah Jadwal</span>
                    <span>&#8250;</span>
                </a>
            </div>
        @endif
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b border-slate-200 px-6 py-3 flex flex-wrap items-center justify-between gap-4 sticky top-0 z-10 print:hidden">
            <form action="{{ url()->current() }}" method="GET"
                  class="flex items-center justify-between gap-2 border border-slate-200 bg-slate-50 focus-within:bg-white focus-within:border-blue-600 rounded-lg px-3 py-1.5 w-full sm:w-80">
                <input
                    type="text"
                    id="global-search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari dokter, poli, atau hari..."
                    class="w-full bg-transparent outline-none text-xs text-slate-800 placeholder:text-slate-400"
                >
                <span class="text-[11px] text-slate-400 bg-white border border-slate-200 rounded px-1.5 py-0.5 whitespace-nowrap">
                    Ctrl + K
                </span>
            </form>

            <div class="flex flex-wrap items-center gap-4">
                @guest
                    <div class="flex items-center bg-slate-100 p-0.5 rounded-lg border border-slate-200 text-xs">
                        @foreach (['admin', 'dokter', 'pasien'] as $roleItem)
                            <a href="{{ route('role.switch', $roleItem) }}"
                               class="px-2.5 py-1 rounded-md {{ $activeRole === $roleItem ? 'bg-white text-[#1d3584] font-semibold shadow-sm' : 'text-slate-600' }}">
                                {{ ucfirst($roleItem) }}
                            </a>
                        @endforeach
                    </div>
                @endguest

                <span class="hidden sm:inline text-xs font-medium text-slate-600">
                    {{ now()->format('d M Y') }}
                </span>

                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-[#1d3584] font-bold text-xs flex items-center justify-center">
                        {{ strtoupper(substr($activeRole, 0, 2)) }}
                    </div>
                    <div class="leading-tight">
                        <div class="text-xs font-semibold text-slate-900">
                            {{ auth()->check() ? auth()->user()->name : 'Youhana Aulia Zahwa' }}
                        </div>
                        <div class="text-[11px] text-slate-500">{{ ucfirst($activeRole) }}</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-6 print:p-0">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('keydown', function (e) {
            if (e.ctrlKey && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                const input = document.getElementById('global-search');
                if (input) input.focus();
            }
        });
    </script>
</body>
</html>
