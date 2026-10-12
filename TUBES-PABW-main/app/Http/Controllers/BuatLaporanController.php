<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuatLaporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BuatLaporanController extends Controller
{
    public function form()
    {
        return view('buatlaporan');
    }

    public function simpan(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'polres' => 'required|string|max:100',
            'alamat' => 'required|string|max:2000',
            'kategori' => ['required', 'string', Rule::in(array_keys(BuatLaporan::KATEGORI_PRIORITAS))],
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
            'deskripsi' => 'required|string',
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('uploads', 'public');
        }

        BuatLaporan::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'notelp' => $user->notelp,
            'kategori' => $validated['kategori'],
            'prioritas' => BuatLaporan::KATEGORI_PRIORITAS[$validated['kategori']],
            'status' => 'pending',
            'date' => $validated['date'],
            'time' => $validated['time'],
            'polres' => $validated['polres'],
            'alamat' => $validated['alamat'],
            'foto' => $path,
            'deskripsi' => $validated['deskripsi'],
        ]);

        return redirect()->route('laporansaya')
                         ->with('success', 'Laporan berhasil dikirim.');
    }

    public function index()
{
    $buatlaporan = BuatLaporan::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('laporansaya', compact('buatlaporan'));
}

}
