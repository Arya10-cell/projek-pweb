@extends('layouts.app')

@section('title', 'Dashboard Dokter - AntriNik')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Dashboard Dokter</h1>
        <p class="text-xs text-slate-500 mt-1">
            @if ($dokterAktif)
                {{ $dokterAktif->nama_dokter }} — {{ $dokterAktif->spesialisasi ?? 'Dokter Umum' }}
            @else
                Belum ada data dokter di database.
            @endif
        </p>
    </div>

    @if ($semuaDokter->count() > 1)
        <form action="{{ route('dashboard.index') }}" method="GET">
            <select name="dokter_id" onchange="this.form.submit()"
                    class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white text-slate-700">
                @foreach ($semuaDokter as $d)
                    <option value="{{ $d->id_dokter }}" {{ ($dokterAktif->id_dokter ?? null) == $d->id_dokter ? 'selected' : '' }}>
                        Lihat sebagai: {{ $d->nama_dokter }}
                    </option>
                @endforeach
            </select>
        </form>
    @endif
</div>

<div class="bg-white border border-slate-200 rounded-xl p-5">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-semibold text-slate-900">Jadwal Praktik Saya</h2>
        <a href="{{ route('laporan.index') }}"
           class="px-3.5 py-1.5 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-50">
            Lihat Laporan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#edf2fc] text-slate-800 text-xs font-semibold">
                    <th class="py-3 px-4 rounded-l-lg">ID Jadwal</th>
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
                        <td class="py-3.5 px-4 font-medium text-slate-900">{{ $jadwal->poli->nama_poli ?? '-' }}</td>
                        <td class="py-3.5 px-4 text-slate-700">{{ ucfirst($jadwal->hari) }}</td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-[11px] font-bold uppercase bg-green-100 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>Terjadwal
                            </span>
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
                        <td colspan="5" class="py-8 text-center text-slate-500">Belum ada jadwal praktik untuk dokter ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pt-4 text-xs text-slate-500">
        Menampilkan {{ $jadwals->count() }} jadwal praktik
    </div>
</div>
@endsection
