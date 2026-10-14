<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('laporan')->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifikasi', compact('notifications'));
    }

    public function bap($id)
    {
        $notification = Notification::with('laporan')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        abort_unless($notification->laporan?->status === 'selesai', 404);

        return view('bap', ['laporan' => $notification->laporan]);
    }

    // tandai notifikasi sebagai dibaca (opsional)
    public function read($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notif->update(['is_read' => true]);

        return back();
    }
}
