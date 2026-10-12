<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'notelp' => 'required',
            'deskripsi' => 'required',
        ]);

        Feedback::create([
            'user_id' => Auth::id(), // ⬅️ INI PENTING
            'nama' => $request->nama,
            'email' => $request->email,
            'notelp' => $request->notelp,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil dikirim');
    }

    public function index()
    {
        $feedbacks = Feedback::latest()->get();
        return view('admin.feedback.index', compact('feedbacks'));
    }
}
