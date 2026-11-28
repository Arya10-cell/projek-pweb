@extends('layouts.app')
@section('title', 'Antrean')

@section('content')
@php
    $warna = ['menunggu' => 'warning', 'dipanggil' => 'info', 'selesai' => 'success', 'batal' => 'danger'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Antrean Pasien</h4>
    <a href="{{ route('antrean.create') }}" class="btn btn-primary">+ Terbitkan Antrean</a>
</div>

<div class="row g-2 mb-3">
    @forelse ($dipanggil as $d)
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body py-2">
                    <small class="text-muted">Sedang dipanggil &middot; {{ $d->nama_poli }}</small>
                    <div class="fs-2 fw-bold">{{ $d->nomor_antrean }}</div>
                    <small>{{ $d->nama_pasien }}</small>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-muted">Belum ada antrean yang sedang dipanggil.</div>
    @endforelse
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label mb-0">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label mb-0">Poli</label>
                <select name="poli" class="form-select">
                    <option value="">Semua poli</option>
                    @foreach ($daftarPoli as $p)
                        <option value="{{ $p->id_poli }}" @selected(request('poli') == $p->id_poli)>{{ $p->nama_poli }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label mb-0">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua status</option>
                    @foreach (['menunggu', 'dipanggil', 'selesai', 'batal'] as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary w-100">Terapkan</button>
            </div>
        </form>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('antrean.panggil-berikutnya') }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-9">
                <label class="form-label mb-0">Panggil nomor berikutnya (hari ini)</label>
                <select name="id_poli" class="form-select" required>
                    <option value="">Pilih poli...</option>
                    @foreach ($daftarPoli as $p)
                        <option value="{{ $p->id_poli }}">{{ $p->nama_poli }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-success w-100">Panggil Berikutnya</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>No. Antrean</th>
                    <th>Pasien</th>
                    <th>Poli</th>
                    <th>Dokter</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($antrean as $item)
                    <tr>
                        <td class="fw-bold fs-5">{{ $item->nomor_antrean }}</td>
                        <td>{{ $item->nama_pasien }}</td>
                        <td>{{ $item->nama_poli }}</td>
                        <td>{{ $item->nama_dokter }}</td>
                        <td>
                            <span class="badge bg-{{ $warna[$item->status_antrean] ?? 'secondary' }}">
                                {{ ucfirst($item->status_antrean) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('antrean.show', $item->id_antrean) }}" class="btn btn-sm btn-outline-primary">Detail</a>

                            @if ($item->status_antrean === 'menunggu')
                                <form action="{{ route('antrean.panggil', $item->id_antrean) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-info">Panggil</button>
                                </form>
                            @endif

                            @if ($item->status_antrean === 'dipanggil')
                                <form action="{{ route('antrean.status', $item->id_antrean) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="selesai">
                                    <button class="btn btn-sm btn-success">Selesai</button>
                                </form>
                            @endif

                            @if (in_array($item->status_antrean, ['menunggu', 'dipanggil']))
                                <form action="{{ route('antrean.status', $item->id_antrean) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Batalkan antrean nomor {{ $item->nomor_antrean }}?')">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="batal">
                                    <button class="btn btn-sm btn-danger">Batal</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada antrean pada tanggal ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $antrean->links('pagination::bootstrap-5') }}</div>
@endsection