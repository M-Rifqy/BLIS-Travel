<?php

namespace App\Http\Controllers\Admin\Activity;

use Exception;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::select('id', 'title', 'description', 'location', 'start_date', 'end_date')
            ->orderBy('start_date', 'desc')
            ->get();

        return view('pages.admin.activity.index', compact('activities'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'location' => 'nullable|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'title.required' => 'Judul kegiatan wajib diisi.',
                'title.max' => 'Judul maksimal 255 karakter.',
                'start_date.required' => 'Tanggal mulai wajib diisi.',
                'end_date.required' => 'Tanggal selesai wajib diisi.',
                'end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            ]);

            Activity::create($request->only([
                'title',
                'description',
                'location',
                'start_date',
                'end_date'
            ]));

            return back()->with('success', 'Kegiatan berhasil ditambahkan.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan kegiatan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan kegiatan.')->with('swal', 'error');
        }
    }

    public function update(Request $request, Activity $activity)
    {
        try {
            // $activity = Activity::findOrFail($request->id);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'location' => 'nullable|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'title.required' => 'Judul kegiatan wajib diisi.',
                'title.max' => 'Judul maksimal 255 karakter.',
                'start_date.required' => 'Tanggal mulai wajib diisi.',
                'end_date.required' => 'Tanggal selesai wajib diisi.',
                'end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            ]);

            $activity->update($request->only([
                'title',
                'description',
                'location',
                'start_date',
                'end_date'
            ]));

            return back()->with('success', 'Kegiatan berhasil diperbarui.')->with('swal', 'success');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui kegiatan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui kegiatan.')->with('swal', 'error');
        }
    }

    public function destroy(Request $request, Activity $activity)
    {
        try {
            // $activity = Activity::findOrFail($request->id);
            $activity->delete();

            return back()->with('success', 'Kegiatan berhasil dihapus.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Gagal menghapus kegiatan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus kegiatan.')->with('swal', 'error');
        }
    }
}
