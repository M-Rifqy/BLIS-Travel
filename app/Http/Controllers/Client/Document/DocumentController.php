<?php

namespace App\Http\Controllers\Client\Document;

use App\Models\Activity;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index(Activity $activity)
    {
        $user = auth()->user();

        // Cari participant user di activity ini
        $participant = $activity->participants()
            ->where('user_id', $user->id)
            ->first();

        // Jika user belum jadi participant, bisa tampilkan kosong atau public doc aja
        if (!$participant) {
            $documents = Document::where('activity_id', $activity->id)
                ->whereNull('participant_id') // hanya dokumen publik
                ->get();
        } else {
            // Ambil dokumen publik + dokumen khusus participant tsb
            $documents = Document::where('activity_id', $activity->id)
                ->where(function ($query) use ($participant) {
                    $query->whereNull('participant_id') // publik
                        ->orWhere('participant_id', $participant->id); // khusus user
                })
                ->get();
        }

        return view('pages.client.document.index', compact('activity', 'documents'));
    }
}
