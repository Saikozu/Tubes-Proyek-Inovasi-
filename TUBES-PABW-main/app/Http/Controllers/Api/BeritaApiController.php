<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\BeritaLike;
use App\Models\BeritaComment;

class BeritaApiController extends Controller
{
    public function index()
    {
        $beritas = Berita::published()->with('comments.user', 'likes')->latest()->paginate(10);

        return response()->json($beritas);
    }

    public function show(Berita $berita)
    {
        abort_unless($berita->status === Berita::STATUS_PUBLISHED, 404);

        $berita->load('comments.user', 'likes');
        $liked = false;
        if (auth()->check()) {
            $liked = $berita->likes()->where('user_id', auth()->id())->exists();
        }

        return response()->json([
            'berita' => $berita,
            'liked' => $liked,
        ]);
    }

    public function like(Request $request, Berita $berita)
    {
        abort_unless($berita->status === Berita::STATUS_PUBLISHED, 404);

        $existing = $berita->likes()->where('user_id', auth()->id())->first();
        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            BeritaLike::create(['berita_id' => $berita->id, 'user_id' => auth()->id()]);
            $liked = true;
        }

        $count = $berita->likes()->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $count
        ]);
    }

    public function comment(Request $request, Berita $berita)
    {
        abort_unless($berita->status === Berita::STATUS_PUBLISHED, 404);

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment = BeritaComment::create([
            'berita_id' => $berita->id,
            'user_id' => auth()->id(),
            'body' => $request->comment,
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $comment,
        ], 201);
    }
}