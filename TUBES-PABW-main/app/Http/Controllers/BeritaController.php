<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\BeritaLike;
use App\Models\BeritaComment;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::published()->latest()->paginate(10);
        return view('berita.index', compact('beritas'));
    }

    public function show(Berita $berita)
    {
        abort_unless($berita->status === Berita::STATUS_PUBLISHED, 404);

        $berita->load('comments.user', 'likes');
        $liked = false;
        if (auth()->check()) {
            $liked = $berita->likes()->where('user_id', auth()->id())->exists();
        }
        return view('berita.show', compact('berita', 'liked'));
    }

    public function like(Request $request, Berita $berita)
    {
        abort_unless($berita->status === Berita::STATUS_PUBLISHED, 404);

        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect()->route('login');
        }

        $existing = $berita->likes()->where('user_id', auth()->id())->first();
        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            BeritaLike::create(['berita_id' => $berita->id, 'user_id' => auth()->id()]);
            $liked = true;
        }

        $count = $berita->likes()->count();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'liked' => $liked, 'count' => $count]);
        }

        return back();
    }

    public function commentStore(Request $request, Berita $berita)
    {
        abort_unless($berita->status === Berita::STATUS_PUBLISHED, 404);

        // Only allow AJAX requests for comments to prevent double submission
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Only AJAX requests allowed'], 400);
        }

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $comment = BeritaComment::create([
            'berita_id' => $berita->id,
            'user_id' => auth()->id(),
            'body' => $data['body'],
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'user_name' => auth()->user()->name,
                'body' => $comment->body
            ]
        ]);
    }
}
