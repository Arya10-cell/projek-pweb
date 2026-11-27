@extends('layouts.app')
@section('title', 'Edit Poli')

@section('content')
<h4 class="mb-3">Edit Poli</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('poli.update', $poli) }}" method="POST">
            @csrf
            @method('PUT')
            @include('poli._form')
            <a href="{{ route('poli.index') }}" class="btn btn-secondary">Batal</a>
            <button class="btn btn-primary">Perbarui</button>
        </form>
    </div>
</div>
@endsection