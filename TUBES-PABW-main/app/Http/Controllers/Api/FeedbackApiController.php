<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackApiController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::where('user_id', auth()->id())->latest()->get();

        return response()->json($feedbacks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'notelp' => 'required|string|max:50',
            'deskripsi' => 'required|string',
        ]);

        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'email' => $request->email,
            'notelp' => $request->notelp,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json([
            'message' => 'Feedback berhasil dikirim',
            'feedback' => $feedback,
        ], 201);
    }
}