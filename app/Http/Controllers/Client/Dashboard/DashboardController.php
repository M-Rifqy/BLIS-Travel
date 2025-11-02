<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Models\Activity;
use App\Models\Document;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil kegiatan yang diikuti user
        $joinedActivities = Activity::whereHas('participants', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        // Ambil semua participant_id milik user
        $participantIds = $user->participants()->pluck('id');

        // Ambil semua dokumen dari semua participant tersebut
        $documents = Document::whereIn('participant_id', $participantIds)->get();

        // Ambil kehadiran user dari semua kegiatan yang diikuti
        $attendances = Attendance::whereHas('participant', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        return view('pages.client.dashboard.index', compact('joinedActivities', 'documents', 'attendances'));
    }
}
