<?php

namespace App\Http\Controllers;

use App\Models\BuatLaporan;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Berita;

class AdminController extends Controller
{
    // halaman daftar laporan (admin)
    public function index()
    {
        $laporan = BuatLaporan::orderBy('created_at', 'desc')->get();
        return view('admin.laporan', compact('laporan'));
    }

    // update status laporan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $laporan = BuatLaporan::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        // buat notifikasi
        Notification::create([
            'user_id' => $laporan->user_id,
            'laporan_id' => $laporan->id,
            'title' => 'Status Laporan',
            'message' => match ($request->status) {
                'pending'  => 'Laporan Anda sedang diproses.',
                'approved' => 'Laporan Anda telah disetujui.',
                'rejected' => 'Laporan Anda ditolak.',
            },
        ]);

        return back()->with('success', 'Status laporan diperbarui.');
    }

    public function statistik()
    {
        $data = BuatLaporan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.statistik', compact('data'));
    }

    public function berita()
    {
        $berita = Berita::all();
        return view('admin.berita', compact('berita'));
    }

    public function storeBerita(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        Berita::create($request->all());
        return back()->with('success', 'Berita ditambahkan');
    }

    public function feedback()
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        return view('admin.feedback', compact('feedbacks'));
    }
}
