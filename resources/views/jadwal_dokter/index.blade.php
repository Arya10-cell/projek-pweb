@extends('layouts.app')

@section('title', 'Kelola Jadwal Dokter - AntriNik')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Kelola Jadwal Dokter</h1>
        <p class="text-slate-500 mt-1">Tambah, ubah, dan hapus jadwal praktik dokter</p>
    </div>
    <a href="{{ route('jadwal-dokter.create') }}"
       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium">
        + Tambah Jadwal
    </a>
</div>

@if (session('success'))
    <div class="mb-5 px-4 py-3 rounded-lg border border-green-200 bg-green-50 text-green-800">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border border-slate-200 rounded-lg p-5">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <h2 class="text-base font-semibold text-slate-900">Daftar Jadwal</h2>

        <form action="{{ route('jadwal-dokter.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
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
                <a href="{{ route('jadwal-dokter.index') }}"
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
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Dokter</th>
                    <th class="py-3 px-4">Poli</th>
                    <th class="py-3 px-4">Hari</th>
                    <th class="py-3 px-4">Jam Praktik</th>
                    <th class="py-3 px-4">Kuota</th>
                    <th class="py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($jadwals as $jadwal)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 font-medium text-blue-600">
                            JDW-{{ str_pad($jadwal->id_jadwal, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium text-slate-900">{{ $jadwal->dokter->nama_dokter ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $jadwal->dokter->spesialisasi ?? '' }}</div>
                        </td>
                        <td class="py-3 px-4">{{ $jadwal->poli->nama_poli ?? '-' }}</td>
                        <td class="py-3 px-4">{{ ucfirst($jadwal->hari) }}</td>
                        <td class="py-3 px-4">
                            {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB
                        </td>
                        <td class="py-3 px-4">{{ $jadwal->kuota_pasien }} pasien</td>
                        <td class="py-3 px-4">
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
                                    <button type="submit" class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-500">Belum ada data jadwal dokter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
