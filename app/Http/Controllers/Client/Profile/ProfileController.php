<?php

namespace App\Http\Controllers\Client\Profile;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil data participant yang terkait dengan user login
        $participant = Participant::with('activity')
            ->where('user_id', $user->id)
            ->latest()
            ->first(); // ambil salah satu (kalau user ikut beberapa kegiatan, bisa disesuaikan nanti)

        return view('pages.client.profile.index', compact('user', 'participant'));
    }
}
