@extends('layouts.app')
@section('title', 'Detail Keluhan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Detail Keluhan</h4>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <small class="text-muted">Nomor Antrean</small>
                <div class="display-3 fw-bold">{{ $antrean->nomor_antrean }}</div>
                <span class="badge bg-secondary">{{ ucfirst($antrean->status_antrean) }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Pasien</dt>
                    <dd class="col-sm-8">{{ $antrean->nama_pasien }} ({{ $antrean->telepon_pasien ?? '-' }})</dd>

                    <dt class="col-sm-4">Poli</dt>
                    <dd class="col-sm-8">{{ $antrean->nama_poli }}</dd>

                    <dt class="col-sm-4">Dokter</dt>
                    <dd class="col-sm-8">{{ $antrean->nama_dokter }}</dd>

                    <dt class="col-sm-4">Jadwal</dt>
                    <dd class="col-sm-8">
                        {{ $antrean->tanggal_antrean->format('d/m/Y') }},
                        {{ substr($antrean->jam_mulai, 0, 5) }} - {{ substr($antrean->jam_selesai, 0, 5) }}
                    </dd>

                    <dt class="col-sm-4">Keluhan</dt>
                    <dd class="col-sm-8">{!! nl2br(e($antrean->keluhan ?? 'Tidak ada keluhan yang dicatat.')) !!}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection