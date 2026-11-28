<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use RuntimeException;

class AntreanController extends Controller
{
    /** Daftar antrean + status. */
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        $antrean = Antrean::denganDetail()
            ->whereDate('antrean.tanggal_antrean', $tanggal)
            ->when($request->poli, fn ($q, $poli) => $q->where('jadwal_dokter.id_poli', $poli))
            ->when($request->status, fn ($q, $status) => $q->where('antrean.status_antrean', $status))
            ->orderBy('poli.nama_poli')
            ->orderBy('antrean.nomor_antrean')
            ->paginate(15)
            ->withQueryString();

        $dipanggil = Antrean::denganDetail()
            ->whereDate('antrean.tanggal_antrean', $tanggal)
            ->where('antrean.status_antrean', Antrean::DIPANGGIL)
            ->orderBy('poli.nama_poli')
            ->get();

        $daftarPoli = Poli::orderBy('nama_poli')->get();

        return view('antrean.index', compact('antrean', 'dipanggil', 'daftarPoli', 'tanggal'));
    }

    /** Pendaftaran yang belum punya nomor antrean. */
    public function create()
    {
        $pendaftaran = DB::table('pendaftaran')
            ->leftJoin('antrean', 'antrean.id_pendaftaran', '=', 'pendaftaran.id_pendaftaran')
            ->join('user', 'pendaftaran.id_user', '=', 'user.id_user')
            ->join('jadwal_dokter', 'pendaftaran.id_jadwal', '=', 'jadwal_dokter.id_jadwal')
            ->join('dokter', 'jadwal_dokter.id_dokter', '=', 'dokter.id_dokter')
            ->join('poli', 'jadwal_dokter.id_poli', '=', 'poli.id_poli')
            ->whereNull('antrean.id_antrean')
            ->whereDate('pendaftaran.tanggal_kunjungan', '>=', now()->toDateString())
            ->orderBy('pendaftaran.tanggal_kunjungan')
            ->orderBy('pendaftaran.id_pendaftaran')
            ->select(
                'pendaftaran.id_pendaftaran',
                'pendaftaran.tanggal_kunjungan',
                'pendaftaran.keluhan',
                'user.nama as nama_pasien',
                'dokter.nama_dokter',
                'poli.nama_poli'
            )
            ->paginate(15);

        return view('antrean.create', compact('pendaftaran'));
    }

    /** Terbitkan nomor antrean. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_pendaftaran' => 'required|integer|exists:pendaftaran,id_pendaftaran',
        ]);

        try {
            $antrean = Antrean::terbitkan($data['id_pendaftaran']);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('antrean.index', ['tanggal' => $antrean->tanggal_antrean->toDateString()])
            ->with('success', "Nomor antrean {$antrean->nomor_antrean} berhasil diterbitkan.");
    }

    /** Detail keluhan. */
    public function show(int $id)
    {
        $antrean = Antrean::denganDetail()
            ->where('antrean.id_antrean', $id)
            ->firstOrFail();

        return view('antrean.show', compact('antrean'));
    }

    /** Panggil satu antrean tertentu. */
    public function panggil(int $id)
    {
        $antrean = Antrean::findOrFail($id);

        if ($antrean->status_antrean !== Antrean::MENUNGGU) {
            return back()->with('error', 'Hanya antrean berstatus menunggu yang bisa dipanggil.');
        }

        $this->ubahStatus($antrean->id_antrean, Antrean::DIPANGGIL);

        return back()->with('success', "Antrean nomor {$antrean->nomor_antrean} dipanggil.");
    }

    /** Panggil nomor menunggu terkecil di sebuah poli untuk hari ini. */
    public function panggilBerikutnya(Request $request)
    {
        $data = $request->validate([
            'id_poli' => 'required|integer|exists:poli,id_poli',
        ]);

        $berikutnya = Antrean::denganDetail()
            ->whereDate('antrean.tanggal_antrean', now()->toDateString())
            ->where('jadwal_dokter.id_poli', $data['id_poli'])
            ->where('antrean.status_antrean', Antrean::MENUNGGU)
            ->orderBy('antrean.nomor_antrean')
            ->first();

        if (! $berikutnya) {
            return back()->with('error', 'Tidak ada antrean menunggu di poli ini untuk hari ini.');
        }

        $this->ubahStatus($berikutnya->id_antrean, Antrean::DIPANGGIL);

        return back()->with('success', "Antrean nomor {$berikutnya->nomor_antrean} ({$berikutnya->nama_poli}) dipanggil.");
    }

    /** Ubah status: menunggu, dipanggil, selesai, batal. */
    public function updateStatus(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(Antrean::STATUS)],
        ]);

        $antrean = Antrean::findOrFail($id);
        $this->ubahStatus($antrean->id_antrean, $data['status']);

        return back()->with('success', "Status antrean nomor {$antrean->nomor_antrean} menjadi {$data['status']}.");
    }

    private function ubahStatus(int $id, string $status): void
    {
        $nilai = ['status_antrean' => $status];

        if ($status === Antrean::DIPANGGIL) {
            $nilai['waktu_dipanggil'] = now();
        }

        Antrean::whereKey($id)->update($nilai);
    }
}