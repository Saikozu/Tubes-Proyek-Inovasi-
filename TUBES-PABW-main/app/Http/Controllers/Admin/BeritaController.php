<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $statuses = ['all', Berita::STATUS_DRAFT, Berita::STATUS_PUBLISHED, Berita::STATUS_TAKEDOWN];
        $status = $request->query('status', 'all');
        if (!in_array($status, $statuses, true)) {
            $status = 'all';
        }

        $beritas = Berita::when($status !== 'all', function ($query) use ($status) {
            $query->where('status', $status);
        })->latest()->paginate(10)->withQueryString();

        return view('admin.berita.index', compact('beritas', 'status'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:20480',
        ]);

        if ($request->hasFile('media')) {
            $data['gambar'] = $request->file('media')->store('berita', 'public');
        }

        Berita::create([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $data['gambar'] ?? null,
            'status' => Berita::STATUS_DRAFT,
        ]);

        return redirect()->route('admin.berita.index', ['status' => 'draft'])->with('success', 'Berita disimpan sebagai Draft');
    }

    public function show(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:20480',
        ]);

        if ($request->hasFile('media')) {
            $data['gambar'] = $request->file('media')->store('berita', 'public');
        }

        $berita->update([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $data['gambar'] ?? $berita->gambar,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita diperbarui');
    }

    public function destroy(Berita $berita)
    {
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita dihapus');
    }

    public function publish(Berita $berita)
    {
        abort_unless($berita->status === Berita::STATUS_DRAFT, 403);

        $berita->update(['status' => Berita::STATUS_PUBLISHED]);

        return back()->with('success', 'Berita berhasil dipublish');
    }

    public function takedown(Berita $berita)
    {
        abort_unless($berita->status === Berita::STATUS_PUBLISHED, 403);

        $berita->update(['status' => Berita::STATUS_TAKEDOWN]);

        return back()->with('success', 'Berita berhasil ditakedown');
    }

    public function restoreDraft(Berita $berita)
    {
        abort_unless($berita->status === Berita::STATUS_TAKEDOWN, 403);

        $berita->update(['status' => Berita::STATUS_DRAFT]);

        return back()->with('success', 'Berita dikembalikan menjadi Draft');
    }
}

// <?php

// namespace App\Http\Controllers\Admin;

// use App\Models\Berita;
// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class BeritaController extends Controller
// {
//     public function index()
//     {
//         $beritas = Berita::latest()->get();
//         return view('admin.berita.index', compact('beritas'));
//     }

//     public function create()
//     {
//         return view('admin.berita.create');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'judul' => 'required',
//             'deskripsi' => 'required',
//             'gambar' => 'nullable|image'
//         ]);

//         $gambar = null;
//         if ($request->hasFile('gambar')) {
//             $gambar = $request->file('gambar')->store('berita', 'public');
//         }

//         Berita::create([
//             'judul' => $request->judul,
//             'deskripsi' => $request->deskripsi,
//             'gambar' => $gambar
//         ]);

//         return redirect()->route('admin.berita')->with('success', 'Berita ditambahkan');
//     }
// }
