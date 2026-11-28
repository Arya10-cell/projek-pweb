@extends('layouts.app')

@section('title', 'Dashboard Admin - AntriNik')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
        <p class="text-xs text-slate-500 mt-1">Daftar jadwal dokter yang tersedia di klinik</p>
    </div>
    <a href="{{ route('jadwal-dokter.create') }}"
       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium">
        + Tambah Jadwal
    </a>
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

            <a href="{{ route('laporan.export', request()->query()) }}"
               class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium">
                Export
            </a>
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
                    <th class="py-3 px-4">Jam & Kuota</th>
                    <th class="py-3 px-4 rounded-r-lg">Aksi</th>
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
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="flex items-center gap-3 text-xs font-medium">
                                <a href="{{ route('jadwal-dokter.edit', $jadwal->id_jadwal) }}"
                                   class="text-blue-600 hover:underline">
                                    Edit
                                </a>
                                <form action="{{ route('jadwal-dokter.destroy', $jadwal->id_jadwal) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500">Belum ada jadwal dokter yang tersedia.</td>
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
