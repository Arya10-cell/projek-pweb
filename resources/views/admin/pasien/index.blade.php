@extends('admin.pasien.layout')

@section('title', 'Data pasien')

@section('content')
    <div class="top">
        <h1>Data pasien</h1>

        @unless ($arsip)
            <a class="btn" href="{{ route('admin.pasien.create') }}">Tambah pasien</a>
        @endunless
    </div>

    <div class="card">
        <div class="tabs">
            <a href="{{ route('admin.pasien.index') }}" class="{{ $arsip ? '' : 'active' }}">Aktif</a>
            <a href="{{ route('admin.pasien.index', ['arsip' => 1]) }}" class="{{ $arsip ? 'active' : '' }}">Arsip</a>
        </div>

        <form class="search" method="GET" action="{{ route('admin.pasien.index') }}">
            @if ($arsip) <input type="hidden" name="arsip" value="1"> @endif
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email">
            <button type="submit" class="btn btn-outline">Cari</button>
        </form>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. telepon</th>
                        <th>Gender</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftarPasien as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->no_telepon ?? '-' }}</td>
                            <td>{{ $p->jenis_kelamin }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($p->alamat ?? '-', 40) }}</td>
                            <td>
                                <div class="aksi">
                                    @if ($arsip)
                                        <form method="POST" action="{{ route('admin.pasien.restore', $p->id_user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline btn-sm">Pulihkan</button>
                                        </form>
                                    @else
                                        <a class="btn btn-outline btn-sm" href="{{ route('admin.pasien.edit', $p) }}">Edit</a>

                                        <form method="POST" action="{{ route('admin.pasien.destroy', $p) }}"
                                              onsubmit="return confirm('Hapus pasien ini? Riwayat pendaftarannya tetap tersimpan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="kosong">
                                {{ $arsip ? 'Arsip masih kosong.' : 'Belum ada data pasien. Tambahkan pasien pertama.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection