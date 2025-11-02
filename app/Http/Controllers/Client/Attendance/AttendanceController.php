<?php

namespace App\Http\Controllers\Client\Attendance;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
        public function index(Activity $activity)
    {
        $user = auth()->user();
        $participant = $activity->participants()->where('user_id', $user->id)->first();

        $attendances = $participant
            ? $participant->attendances()->orderBy('check_in_time', 'desc')->get()
            : collect();

        return view('pages.client.attendance.index', compact('activity', 'attendances'));
    }
}
