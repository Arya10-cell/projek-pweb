@extends('layouts.app')

@section('title', 'Laporan & Rekap - AntriNik')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Laporan & Rekap</h1>
        <p class="text-slate-500 mt-1">Rekapitulasi jadwal praktik, kuota pasien, dan pendaftaran per poli</p>
    </div>

    <div class="flex items-center gap-2 print:hidden">
        <button type="button" onclick="window.print()"
                class="px-4 py-2 border border-slate-300 bg-white hover:bg-slate-50 rounded-md font-medium">
            Cetak
        </button>
        <a href="{{ route('laporan.export', request()->query()) }}"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium">
            Export CSV
        </a>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-slate-200 rounded-lg p-4">
        <div class="text-xs text-slate-500">Total Pendaftaran</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalPendaftaran }}</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-lg p-4">
        <div class="text-xs text-slate-500">Total Antrean</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalAntrean }}</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-lg p-4">
        <div class="text-xs text-slate-500">Jadwal Direkap</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalJadwal }}</div>
    </div>
    <div class="bg-white border border-slate-200 rounded-lg p-4">
        <div class="text-xs text-slate-500">Total Kapasitas Kuota</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalKuota }}</div>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-lg p-5 mb-6">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <h2 class="text-base font-semibold text-slate-900">Rekap Jadwal per Dokter</h2>

        <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap items-center gap-2 print:hidden">
            @if ($search)
                <input type="hidden" name="q" value="{{ $search }}">
            @endif

            <select name="poli" onchange="this.form.submit()"
                    class="px-3 py-1.5 border border-slate-300 rounded-md text-xs bg-white">
                <option value="">Semua Poli</option>
                @foreach ($polis as $poli)
                    <option value="{{ $poli->id_poli }}" {{ (string) $poliId === (string) $poli->id_poli ? 'selected' : '' }}>
                        {{ $poli->nama_poli }}
                    </option>
                @endforeach
            </select>

            <select name="hari" onchange="this.form.submit()"
                    class="px-3 py-1.5 border border-slate-300 rounded-md text-xs bg-white">
                <option value="">Semua Hari</option>
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                    <option value="{{ $h }}" {{ $hari === $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>

            @if ($hasFilter)
                <a href="{{ route('laporan.index') }}"
                   class="px-3 py-1.5 border border-slate-300 rounded-md text-xs hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50 text-xs text-slate-600 uppercase">
                    <th class="py-3 px-4">No. Rekap</th>
                    <th class="py-3 px-4">Poli</th>
                    <th class="py-3 px-4">Dokter</th>
                    <th class="py-3 px-4">Hari & Jam</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Terdaftar / Kuota</th>
                    <th class="py-3 px-4">Utilisasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($rekap as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 font-medium text-blue-600">
                            RKP-{{ str_pad($item->id_jadwal, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="py-3 px-4 font-medium text-slate-900">{{ $item->poli->nama_poli ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <div>{{ $item->dokter->nama_dokter ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $item->dokter->spesialisasi ?? '' }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div>{{ ucfirst($item->hari) }}</div>
                            <div class="text-xs text-slate-500">
                                {{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }} WIB
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            @if ($item->status_kuota === 'PENUH')
                                <span class="px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-700">Penuh</span>
                            @elseif ($item->status_kuota === 'BERJALAN')
                                <span class="px-2 py-1 rounded text-xs font-medium bg-amber-100 text-amber-700">Berjalan</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-700">Tersedia</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $item->total_terdaftar }} / {{ $item->kuota_pasien }} pasien</td>
                        <td class="py-3 px-4">{{ $item->utilisasi_persen }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-500">Tidak ada data rekap.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-lg p-5">
    <h2 class="text-base font-semibold text-slate-900 mb-4">Ringkasan per Poli</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50 text-xs text-slate-600 uppercase">
                    <th class="py-3 px-4">No</th>
                    <th class="py-3 px-4">Nama Poli</th>
                    <th class="py-3 px-4">Jumlah Dokter</th>
                    <th class="py-3 px-4">Jumlah Jadwal</th>
                    <th class="py-3 px-4">Total Kuota</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($rekapPerPoli as $index => $poli)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 text-slate-500">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 font-medium text-slate-900">{{ $poli->nama_poli }}</td>
                        <td class="py-3 px-4">{{ $poli->jumlah_dokter }} dokter</td>
                        <td class="py-3 px-4">{{ $poli->jumlah_jadwal }} jadwal</td>
                        <td class="py-3 px-4">{{ $poli->total_kuota }} pasien</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-slate-500">Belum ada data poli.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
