<?php

namespace App\Http\Controllers\Admin\Attendance;

use Exception;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index(Activity $activity)
    {
        try {
            $attendances = Attendance::where('activity_id', $activity->id)
                ->with('participant')
                ->get();

            // Ambil daftar grup unik untuk dropdown
            $groups = Attendance::where('activity_id', $activity->id)
                ->distinct()
                ->pluck('group')
                ->toArray();
            // dd($groups, Attendance::where('activity_id', $activity->id)->get(['group']));

            return view('pages.admin.attendance.index', compact('activity', 'attendances', 'groups'));
        } catch (Exception $e) {
            Log::error('Gagal mengambil absensi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil absensi')->with('swal', 'error');
        }
    }

    public function scan(Request $request, Activity $activity)
    {
        try {
            $request->validate([
                'qr_token' => 'required|string',
                'group' => 'required|string'
            ]);

            $participant = Participant::where('qr_token', $request->qr_token)
                ->where('activity_id', $activity->id)
                ->first();

            if (!$participant) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR token tidak valid atau peserta tidak ditemukan'
                ]);
            }

            // Catat absensi baru
            $attendance = Attendance::create([
                'participant_id' => $participant->id,
                'activity_id' => $activity->id,
                'group' => $request->group,
                'check_in_time' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dicatat',
                'attendance' => [
                    'participant_name' => $participant->full_name,
                    'email' => $participant->user?->email ?? '-',
                    'check_in_time' => $attendance->check_in_time->format('d M Y H:i'),
                    'group' => $attendance->group
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal scan QR: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan absensi'
            ]);
        }
    }
}
