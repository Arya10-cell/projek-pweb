@extends('layouts.app')

@section('title', 'Jadwal Dokter - AntriNik')

@section('content')
<div class="page-header">
    <h1>Jadwal Dokter</h1>
    <a href="{{ route('jadwal-dokter.create') }}" class="btn btn-primary">Tambah Jadwal</a>
</div>

@if (session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Dokter</th>
            <th>Poli</th>
            <th>Hari</th>
            <th>Jam Praktik</th>
            <th>Kuota</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($jadwals as $index => $jadwal)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    {{ $jadwal->dokter->nama_dokter ?? '-' }}
                    <span class="subtext">{{ $jadwal->dokter->spesialisasi ?? '' }}</span>
                </td>
                <td>{{ $jadwal->poli->nama_poli ?? '-' }}</td>
                <td>{{ $jadwal->hari }}</td>
                <td>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                <td>{{ $jadwal->kuota_pasien }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('jadwal-dokter.edit', $jadwal->id_jadwal) }}" class="icon-btn icon-edit" title="Edit" aria-label="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                            </svg>
                        </a>

                        <form action="{{ route('jadwal-dokter.destroy', $jadwal->id_jadwal) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn icon-delete" title="Hapus" aria-label="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
                <td colspan="7" class="empty">Belum ada data jadwal dokter.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
