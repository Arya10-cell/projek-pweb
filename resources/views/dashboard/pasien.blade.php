@extends('layouts.app')

@section('title', 'Dashboard Pasien - AntriNik')

@section('content')
<div class="mb-5">
    <h1 class="text-2xl font-bold text-slate-900">Dashboard Pasien</h1>
    <p class="text-xs text-slate-500 mt-1">Lihat jadwal dokter yang tersedia hari ini</p>
</div>

<div class="bg-white border border-slate-200 rounded-xl p-5">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <h2 class="text-base font-semibold text-slate-900">Jadwal Dokter Tersedia</h2>

        <form action="{{ route('dashboard.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            @if ($search)
                <input type="hidden" name="q" value="{{ $search }}">
            @endif

            <select name="poli" onchange="this.form.submit()"
                    class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white text-slate-700">
                <option value="">Semua Poli</option>
                @foreach ($polis as $poli)
                    <option value="{{ $poli->id_poli }}" {{ (string) $poliId === (string) $poli->id_poli ? 'selected' : '' }}>
                        {{ $poli->nama_poli }}
                    </option>
                @endforeach
            </select>

            <select name="hari" onchange="this.form.submit()"
                    class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white text-slate-700">
                <option value="">Semua Hari</option>
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                    <option value="{{ $h }}" {{ strtolower((string) $hari) === strtolower($h) ? 'selected' : '' }}>
                        {{ $h }}
                    </option>
                @endforeach
            </select>

            @if ($hasFilter)
                <a href="{{ route('dashboard.index') }}"
                   class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs text-slate-600 hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#edf2fc] text-slate-800 text-xs font-semibold">
                    <th class="py-3 px-4 rounded-l-lg">ID Jadwal</th>
                    <th class="py-3 px-4">Nama Dokter</th>
                    <th class="py-3 px-4">Poli</th>
                    <th class="py-3 px-4">Hari</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 rounded-r-lg">Jam & Kuota</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($jadwals as $jadwal)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3.5 px-4 font-semibold text-blue-600 whitespace-nowrap">
                            JDW-{{ str_pad($jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-medium text-slate-900">{{ $jadwal->dokter->nama_dokter ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $jadwal->dokter->spesialisasi ?? '' }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-slate-700">{{ $jadwal->poli->nama_poli ?? '-' }}</td>
                        <td class="py-3.5 px-4 text-slate-700">{{ ucfirst($jadwal->hari) }}</td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            @if ($jadwal->kuota_pasien > 10)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-[11px] font-bold uppercase bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-[11px] font-bold uppercase bg-amber-100 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>Terbatas
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="font-medium text-slate-900">
                                {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB
                            </div>
                            <div class="text-xs text-slate-500">Kuota {{ $jadwal->kuota_pasien }} pasien</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">Tidak ada jadwal dokter yang cocok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pt-4 text-xs text-slate-500">
        Menampilkan {{ $jadwals->count() }} jadwal dokter
    </div>
</div>
@endsection
