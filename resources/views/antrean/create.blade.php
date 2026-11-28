@extends('layouts.app')
@section('title', 'Terbitkan Antrean')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Terbitkan Antrean</h4>
    <a href="{{ route('antrean.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<p class="text-muted">Pendaftaran berikut belum memiliki nomor antrean.</p>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tgl Kunjungan</th>
                    <th>Pasien</th>
                    <th>Poli</th>
                    <th>Dokter</th>
                    <th>Keluhan</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendaftaran as $item)
                    <tr>
                        <td>{{ \Illuminate\Support\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                        <td>{{ $item->nama_pasien }}</td>
                        <td>{{ $item->nama_poli }}</td>
                        <td>{{ $item->nama_dokter }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item->keluhan ?? '-', 40) }}</td>
                        <td class="text-end">
                            <form action="{{ route('antrean.store') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id_pendaftaran" value="{{ $item->id_pendaftaran }}">
                                <button class="btn btn-sm btn-primary">Terbitkan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Semua pendaftaran sudah memiliki nomor antrean.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $pendaftaran->links('pagination::bootstrap-5') }}</div>
@endsection