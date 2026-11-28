@csrf

<div class="grid">
    <div class="field @error('nama') has-error @enderror">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $pasien->nama ?? '') }}" required>
        @error('nama') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field @error('email') has-error @enderror">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $pasien->email ?? '') }}" required>
        @error('email') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field @error('no_telepon') has-error @enderror">
        <label for="no_telepon">No. telepon</label>
        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pasien->no_telepon ?? '') }}">
        @error('no_telepon') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field @error('jenis_kelamin') has-error @enderror">
        <label for="jenis_kelamin">Jenis kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="">Pilih</option>
            @foreach (['Laki-laki', 'Perempuan'] as $jk)
                <option value="{{ $jk }}" @selected(old('jenis_kelamin', $pasien->jenis_kelamin ?? '') === $jk)>{{ $jk }}</option>
            @endforeach
        </select>
        @error('jenis_kelamin') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field span2 @error('alamat') has-error @enderror">
        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
        @error('alamat') <p class="error">{{ $message }}</p> @enderror
    </div>
</div>