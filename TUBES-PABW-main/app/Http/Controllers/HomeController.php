<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class HomeController extends Controller
{
    public function index()
    {
        $beritas = Berita::published()->withCount(['likes', 'comments'])->with(['likes' => function($q) {
            if(auth()->check()) {
                $q->where('user_id', auth()->id());
            }
        }, 'comments' => function($q) {
            $q->with('user')->latest();
        }])->latest()->get();

        return view('home', compact('beritas'));
    }
}
