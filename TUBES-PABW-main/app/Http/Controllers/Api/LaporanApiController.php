<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuatLaporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LaporanApiController extends Controller
{
    public function index()
    {
        $laporans = BuatLaporan::where('user_id', auth()->id())->latest()->get();

        return response()->json($laporans);
    }

    public function store(Request $request)
    {
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

        $laporan = BuatLaporan::create([
            'user_id' => Auth::id(),
            'nama' => Auth::user()->name,
            'email' => Auth::user()->email,
            'notelp' => Auth::user()->notelp,
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

        return response()->json([
            'message' => 'Laporan berhasil dikirim.',
            'laporan' => $laporan,
        ], 201);
    }

    public function show(BuatLaporan $laporan)
    {
        // Ensure user can only view their own reports
        if ($laporan->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($laporan);
    }

    public function update(Request $request, BuatLaporan $laporan)
    {
        // Ensure user can only update their own reports
        if ($laporan->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'polres' => 'required|string|max:100',
            'alamat' => 'required|string|max:2000',
            'kategori' => ['required', 'string', Rule::in(array_keys(BuatLaporan::KATEGORI_PRIORITAS))],
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
            'deskripsi' => 'required|string',
            'status' => 'nullable|string',
        ]);

        $path = $laporan->foto;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('uploads', 'public');
        }

        $laporan->update([
            'notelp' => Auth::user()->notelp,
            'kategori' => $validated['kategori'],
            'prioritas' => BuatLaporan::KATEGORI_PRIORITAS[$validated['kategori']],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'polres' => $validated['polres'],
            'alamat' => $validated['alamat'],
            'foto' => $path,
            'deskripsi' => $validated['deskripsi'],
            'status' => $validated['status'] ?? $laporan->status,
        ]);

        return response()->json([
            'message' => 'Laporan berhasil diperbarui.',
            'laporan' => $laporan,
        ]);
    }

    public function destroy(BuatLaporan $laporan)
    {
        // Ensure user can only delete their own reports
        if ($laporan->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $laporan->delete();

        return response()->json(['message' => 'Laporan berhasil dihapus.']);
    }
}