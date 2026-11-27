@extends('layouts.app')
@section('title', 'Data Poli')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Kelola Data Poli</h4>
    <a href="{{ route('poli.create') }}" class="btn btn-primary">+ Tambah Poli</a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama poli...">
        <button class="btn btn-outline-secondary">Cari</button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Poli</th>
                    <th>Deskripsi</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($poli as $item)
                    <tr>
                        <td>{{ $poli->firstItem() + $loop->index }}</td>
                        <td>{{ $item->nama_poli }}</td>
                        <td>{{ $item->deskripsi ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('poli.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('poli.destroy', $item) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus poli {{ $item->nama_poli }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data poli.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $poli->links('pagination::bootstrap-5') }}</div>
@endsection