@extends('layouts.app')

@section('title', 'Tambah Jadwal Dokter - AntriNik')

@section('content')
<div class="max-w-xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Tambah Jadwal Dokter</h1>
        <a href="{{ route('jadwal-dokter.index') }}" class="text-xs text-slate-600 hover:underline">
            Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg p-6">
        @if ($errors->any())
            <div class="mb-4 px-4 py-3 rounded-lg border border-red-200 bg-red-50 text-red-700 text-xs">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jadwal-dokter.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="id_dokter" class="block text-xs font-medium text-slate-700 mb-1">Dokter</label>
                <select id="id_dokter" name="id_dokter" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-md bg-white">
                    <option value="">Pilih dokter</option>
                    @foreach ($dokters as $dokter)
                        <option value="{{ $dokter->id_dokter }}" {{ old('id_dokter') == $dokter->id_dokter ? 'selected' : '' }}>
                            {{ $dokter->nama_dokter }} - {{ $dokter->spesialisasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="id_poli" class="block text-xs font-medium text-slate-700 mb-1">Poli</label>
                <select id="id_poli" name="id_poli" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-md bg-white">
                    <option value="">Pilih poli</option>
                    @foreach ($polis as $poli)
                        <option value="{{ $poli->id_poli }}" {{ old('id_poli') == $poli->id_poli ? 'selected' : '' }}>
                            {{ $poli->nama_poli }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="hari" class="block text-xs font-medium text-slate-700 mb-1">Hari</label>
                <select id="hari" name="hari" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-md bg-white">
                    <option value="">Pilih hari</option>
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                        <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="jam_mulai" class="block text-xs font-medium text-slate-700 mb-1">Jam Mulai</label>
                    <input id="jam_mulai" type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-md">
                </div>
                <div>
                    <label for="jam_selesai" class="block text-xs font-medium text-slate-700 mb-1">Jam Selesai</label>
                    <input id="jam_selesai" type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-md">
                </div>
            </div>

            <div>
                <label for="kuota_pasien" class="block text-xs font-medium text-slate-700 mb-1">Kuota Pasien</label>
                <input id="kuota_pasien" type="number" name="kuota_pasien" min="1" value="{{ old('kuota_pasien', 20) }}" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-md">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium">
                    Simpan
                </button>
                <a href="{{ route('jadwal-dokter.index') }}"
                   class="px-4 py-2 border border-slate-300 rounded-md text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
