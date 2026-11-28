@extends('admin.pasien.layout')

@section('title', 'Tambah pasien')

@section('content')
    <a class="back" href="{{ route('admin.pasien.index') }}">Kembali ke daftar</a>

    <div class="top">
        <h1>Tambah pasien</h1>
    </div>

    <div class="card">
        <p class="hint">Password dibuat otomatis dan ditampilkan satu kali setelah data disimpan.</p>

        <form method="POST" action="{{ route('admin.pasien.store') }}" novalidate>
            @include('admin.pasien._form')

            <div class="form-actions">
                <button type="submit" class="btn">Simpan</button>
                <a class="btn btn-outline" href="{{ route('admin.pasien.index') }}">Batal</a>
            </div>
        </form>
    </div>
@endsection