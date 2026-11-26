@extends('layouts.app')

@section('title', 'Tambah Jadwal Dokter - AntriNik')

@section('content')
<div class="page-header">
    <h1>Tambah Jadwal Dokter</h1>
</div>

<div class="form-box">
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jadwal-dokter.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="id_dokter">Dokter</label>
            <select id="id_dokter" name="id_dokter" required>
                <option value="">Pilih dokter</option>
                @foreach ($dokters as $dokter)
                    <option value="{{ $dokter->id_dokter }}" {{ old('id_dokter') == $dokter->id_dokter ? 'selected' : '' }}>
                        {{ $dokter->nama_dokter }} - {{ $dokter->spesialisasi }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="id_poli">Poli</label>
            <select id="id_poli" name="id_poli" required>
                <option value="">Pilih poli</option>
                @foreach ($polis as $poli)
                    <option value="{{ $poli->id_poli }}" {{ old('id_poli') == $poli->id_poli ? 'selected' : '' }}>
                        {{ $poli->nama_poli }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="hari">Hari</label>
            <select id="hari" name="hari" required>
                <option value="">Pilih hari</option>
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                    <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input id="jam_mulai" type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
            </div>
            <div class="form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input id="jam_selesai" type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="kuota_pasien">Kuota Pasien</label>
            <input id="kuota_pasien" type="number" name="kuota_pasien" min="1" value="{{ old('kuota_pasien', 20) }}" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('jadwal-dokter.index') }}" class="btn">Kembali</a>
        </div>
    </form>
</div>
@endsection
