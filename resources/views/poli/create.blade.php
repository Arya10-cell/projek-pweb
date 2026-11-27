@extends('layouts.app')
@section('title', 'Tambah Poli')

@section('content')
<h4 class="mb-3">Tambah Poli</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('poli.store') }}" method="POST">
            @csrf
            @include('poli._form')
            <a href="{{ route('poli.index') }}" class="btn btn-secondary">Batal</a>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection