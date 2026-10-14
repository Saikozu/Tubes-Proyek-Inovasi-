<?php

namespace App\Http\Controllers;

use App\Models\BuatLaporan;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function index()
    {
        $laporan = BuatLaporan::orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END")
            ->orderByDesc('created_at')
            ->get();

        return view('petugas.laporan', compact('laporan'));
    }

    public function show(BuatLaporan $laporan)
    {
        return view('petugas.detail', compact('laporan'));
    }

    public function complete(BuatLaporan $laporan)
    {
        if ($laporan->status === 'rejected') {
            return back()->withErrors(['status' => 'Laporan yang ditolak tidak dapat diselesaikan.']);
        }

        DB::transaction(function () use ($laporan) {
            if ($laporan->status === 'selesai') {
                return;
            }

            $laporan->update(['status' => 'selesai']);

            Notification::create([
                'user_id' => $laporan->user_id,
                'laporan_id' => $laporan->id,
                'title' => 'BAP Laporan Selesai',
                'message' => 'Laporan Anda telah selesai ditindaklanjuti. Berita Acara Pemeriksaan sudah tersedia.',
            ]);
        });

        return redirect()->route('petugas.laporan.show', $laporan)->with('success', 'Laporan diselesaikan dan BAP tersedia untuk pelapor.');
    }
}
