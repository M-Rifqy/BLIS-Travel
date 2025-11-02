<?php

namespace App\Http\Controllers\Admin\Participant;

use Exception;
use App\Models\User;
use App\Models\Activity;
use Endroid\QrCode\QrCode;
use App\Models\Participant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Encoding\Encoding;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class ParticipantController extends Controller
{
    public function index(Activity $activity)
    {
        try {
            $participants = $activity->participants()->with('user')->get();
            return view('pages.admin.participant.index', compact('participants', 'activity'));
        } catch (Exception $e) {
            Log::error('Gagal mengambil peserta: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil peserta.')->with('swal', 'error');
        }
    }

    public function downloadQr(Activity $activity, Participant $participant)
    {
        $fileName = 'QR_' . $participant->full_name . '.png';

        $qrCode = new QrCode($participant->qr_token);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return response($result->getString(), 200)
            ->header('Content-Type', $result->getMimeType())
            ->header('Content-Disposition', "attachment; filename=\"$fileName\"");
    }

    public function store(Request $request, Activity $activity)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:pending,active,completed',
        ], [
            'full_name.required' => 'Nama peserta wajib diisi.',
            'full_name.max' => 'Nama maksimal 255 karakter.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        DB::beginTransaction();

        try {
            $user = null;

            if ($request->email) {
                $password = 'client!123';
                $user = User::create([
                    'name' => $request->full_name,
                    'email' => $request->email,
                    'password' => bcrypt($password),
                    'role' => 'client',
                ]);
            }

            Participant::create([
                'user_id' => $user?->id,
                'activity_id' => $activity->id,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'qr_token' => Str::random(64),
                'status' => $request->status,
            ]);

            DB::commit();

            return back()->with('success', 'Participant berhasil ditambahkan.')->with('swal', 'success');
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan participant: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan participant.')->with('swal', 'error');
        }
    }

    public function resetPassword(Activity $activity, Participant $participant)
    {
        try {
            if (!$participant->user) {
                return back()->with('error', 'Peserta ini tidak memiliki akun.');
            }

            $newPassword = 'client!123';

            $participant->user->update([
                'password' => bcrypt($newPassword)
            ]);

            // Kirim email
            Mail::to($participant->user->email)->send(new ResetPasswordMail($newPassword));

            return back()->with('success', "Password baru telah dikirim ke email peserta")->with('swal', 'success');
        } catch (\Exception $e) {
            Log::error('Gagal reset password: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mereset password')->with('swal', 'error');
        }
    }

    public function update(Request $request, Activity $activity, Participant $participant)
    {
        try {
            $request->validate([
                'full_name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'status' => 'required|in:pending,active,completed',
            ], [
                'full_name.required' => 'Nama peserta wajib diisi.',
                'full_name.max' => 'Nama maksimal 255 karakter.',
                'status.required' => 'Status wajib dipilih.',
            ]);

            $participant->update([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'status' => $request->status,
            ]);

            return back()->with('success', 'Participant berhasil diperbarui.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Gagal memperbarui participant: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui participant.')->with('swal', 'error');
        }
    }

    public function destroy(Activity $activity, Participant $participant)
    {
        try {
            $participant->delete();

            if ($participant->user) {
                $participant->user->delete();
            }

            return back()->with('success', 'Participant beserta user berhasil dihapus.')->with('swal', 'success');
        } catch (Exception $e) {
            Log::error('Gagal menghapus participant: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus participant.')->with('swal', 'error');
        }
    }
}
