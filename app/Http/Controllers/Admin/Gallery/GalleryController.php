<?php

namespace App\Http\Controllers\Admin\Gallery;

use Exception;
use App\Models\Gallery;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class GalleryController extends Controller
{
    public function index(Activity $activity)
    {
        try {
            $galleries = Gallery::where('activity_id', $activity->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('pages.admin.gallery.index', compact('activity', 'galleries'));
        } catch (Exception $e) {
            Log::error('Gagal mengambil gallery: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil gallery')->with('swal', 'error');
        }
    }

    public function store(Request $request, Activity $activity)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
                'caption' => 'nullable|string|max:255',
            ], [
                'image.required' => 'Gambar wajib diunggah.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Format gambar tidak didukung.',
                'image.max' => 'Ukuran gambar maksimal 5MB.',
            ]);

            $filePath = $request->file('image')->store('galleries', 'public');

            Gallery::create([
                'activity_id' => $activity->id,
                'image' => $filePath,
                'caption' => $request->caption,
            ]);

            return back()->with('success', 'Gallery berhasil ditambahkan.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Gagal menambahkan gallery: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan gallery.')->with('swal', 'error');
        }
    }

    public function update(Request $request, Activity $activity, Gallery $gallery)
    {
        try {
            $request->validate([
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'caption' => 'nullable|string|max:255',
            ]);

            $data = ['caption' => $request->caption];

            if ($request->hasFile('image')) {
                if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                    Storage::disk('public')->delete($gallery->image);
                }
                $data['image'] = $request->file('image')->store('galleries', 'public');
            }

            $gallery->update($data);

            return back()->with('success', 'Gallery berhasil diperbarui.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Gagal memperbarui gallery: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui gallery.')->with('swal', 'error');
        }
    }

    public function destroy(Activity $activity, Gallery $gallery)
    {
        try {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            $gallery->delete();

            return back()->with('success', 'Gallery berhasil dihapus.')->with('swal', 'success');
        } catch (Exception $e) {
            Log::error('Gagal menghapus gallery: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus gallery.')->with('swal', 'error');
        }
    }
}

