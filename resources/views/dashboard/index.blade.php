@extends('layouts.app')

@section('title', 'Kelola Jadwal Dokter - AntriNik')

@section('content')
<div class="flex flex-wrap items-start justify-between gap-4 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Kelola Jadwal Dokter</h1>
        <p class="text-[13px] text-slate-500 mt-1">Tambah, ubah, dan hapus jadwal praktik dokter di setiap poli</p>
    </div>
    <a href="{{ route('jadwal-dokter.create') }}"
       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-[13px] font-medium transition">
        + Tambah Jadwal
    </a>
</div>

@if (session('success'))
    <div class="mb-4 px-4 py-3 rounded-xl border border-green-200 bg-green-50 text-green-800 text-[13.5px]">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border border-slate-200 rounded-xl p-5">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <div class="flex items-center gap-2.5 text-base font-semibold text-slate-900">
            <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <span>Daftar Jadwal Praktik</span>
        </div>

        <form action="{{ route('jadwal-dokter.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
            @if ($search)
                <input type="hidden" name="q" value="{{ $search }}">
            @endif

            <select name="poli" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-lg border border-slate-200 bg-white text-[13px] text-slate-700 cursor-pointer focus:outline-none focus:border-blue-600">
                <option value="">Semua Poli</option>
                @foreach ($polis as $poli)
                    <option value="{{ $poli->id_poli }}" {{ (string) $poliId === (string) $poli->id_poli ? 'selected' : '' }}>
                        {{ $poli->nama_poli }}
                    </option>
                @endforeach
            </select>

            <select name="hari" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-lg border border-slate-200 bg-white text-[13px] text-slate-700 cursor-pointer focus:outline-none focus:border-blue-600">
                <option value="">Semua Hari</option>
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                    <option value="{{ $h }}" {{ $hari === $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>

            @if ($search || $poliId || $hari)
                <a href="{{ route('jadwal-dokter.index') }}"
                   class="px-3.5 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-[13px] font-medium text-slate-700">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#edf2fc] text-slate-800 text-[13px] font-semibold">
                    <th class="px-3.5 py-3 rounded-l-lg whitespace-nowrap">ID Jadwal</th>
                    <th class="px-3.5 py-3 whitespace-nowrap">Nama Dokter</th>
                    <th class="px-3.5 py-3 whitespace-nowrap">Poli</th>
                    <th class="px-3.5 py-3 whitespace-nowrap">Hari</th>
                    <th class="px-3.5 py-3 whitespace-nowrap">Jam Praktik</th>
                    <th class="px-3.5 py-3 whitespace-nowrap">Kuota Pasien</th>
                    <th class="px-3.5 py-3 rounded-r-lg whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-[13.5px]">
                @forelse ($jadwals as $jadwal)
                    <tr class="hover:bg-slate-50">
                        <td class="px-3.5 py-3.5 font-semibold text-blue-600 whitespace-nowrap">
                            JDW-{{ str_pad($jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-3.5 py-3.5">
                            <div class="font-semibold text-slate-900">{{ $jadwal->dokter->nama_dokter ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $jadwal->dokter->spesialisasi ?? '' }}</div>
                        </td>
                        <td class="px-3.5 py-3.5 text-slate-700">{{ $jadwal->poli->nama_poli ?? '-' }}</td>
                        <td class="px-3.5 py-3.5 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold uppercase bg-blue-100 text-blue-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>{{ $jadwal->hari }}
                            </span>
                        </td>
                        <td class="px-3.5 py-3.5 whitespace-nowrap">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</td>
                        <td class="px-3.5 py-3.5 whitespace-nowrap"><strong>{{ $jadwal->kuota_pasien }}</strong> pasien</td>
                        <td class="px-3.5 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('jadwal-dokter.edit', $jadwal->id_jadwal) }}" title="Edit" aria-label="Edit"
                                   class="w-8 h-8 rounded-md inline-flex items-center justify-center text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"/>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('jadwal-dokter.destroy', $jadwal->id_jadwal) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus" aria-label="Hapus"
                                            class="w-8 h-8 rounded-md inline-flex items-center justify-center text-red-600 hover:bg-red-50 hover:text-red-700 transition">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                            <path d="M10 11v6"/>
                                            <path d="M14 11v6"/>
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-slate-500 py-8">Belum ada data jadwal dokter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pt-3.5 text-[13px] text-slate-500">
        Menampilkan {{ $jadwals->count() }} jadwal praktik
    </div>
</div>
@endsection
