<div class="mb-3">
    <label class="form-label">Nama Poli</label>
    <input type="text" name="nama_poli" class="form-control @error('nama_poli') is-invalid @enderror"
           value="{{ old('nama_poli', $poli->nama_poli ?? '') }}">
    @error('nama_poli') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $poli->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>