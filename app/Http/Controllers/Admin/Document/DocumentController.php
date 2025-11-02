<?php

namespace App\Http\Controllers\Admin\Document;

use Exception;
use App\Models\Activity;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Activity $activity)
    {
        try {
            $documents = Document::where('activity_id', $activity->id)
                ->whereNull('participant_id')
                ->with('participant')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('pages.admin.document.index', compact('activity', 'documents'));
        } catch (Exception $e) {
            Log::error('Gagal mengambil dokumen: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil dokumen')->with('swal', 'error');
        }
    }

    public function store(Request $request, Activity $activity)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240', // max 10MB
                'visibility' => 'required|in:publish,draft',
            ], [
                'title.required' => 'Judul dokumen wajib diisi.',
                'file.required' => 'File wajib diunggah.',
                'file.mimes' => 'Format file tidak didukung.',
                'file.max' => 'Ukuran file maksimal 10MB.',
            ]);

            $filePath = $request->file('file')->store('documents', 'public');

            Document::create([
                'activity_id' => $activity->id,
                'participant_id' => $request->participant_id ?? null,
                'title' => $request->title,
                'file' => $filePath,
                'visibility' => $request->visibility,
            ]);

            return back()->with('success', 'Dokumen berhasil ditambahkan.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Gagal menambahkan dokumen: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan dokumen.')->with('swal', 'error');
        }
    }

    public function update(Request $request, Activity $activity, Document $document)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:10240',
                'visibility' => 'required|in:publish,draft',
            ], [
                'title.required' => 'Judul dokumen wajib diisi.',
                'file.mimes' => 'Format file tidak didukung.',
                'file.max' => 'Ukuran file maksimal 10MB.',
            ]);

            $data = [
                'title' => $request->title,
                'visibility' => $request->visibility,
            ];

            if ($request->hasFile('file')) {
                // Hapus file lama
                if ($document->file && Storage::disk('public')->exists($document->file)) {
                    Storage::disk('public')->delete($document->file);
                }
                $data['file'] = $request->file('file')->store('documents', 'public');
            }

            $document->update($data);

            return back()->with('success', 'Dokumen berhasil diperbarui.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Gagal memperbarui dokumen: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui dokumen.')->with('swal', 'error');
        }
    }

    public function destroy(Activity $activity, Document $document)
    {
        try {
            if ($document->file && Storage::disk('public')->exists($document->file)) {
                Storage::disk('public')->delete($document->file);
            }

            $document->delete();

            return back()->with('success', 'Dokumen berhasil dihapus.')->with('swal', 'success');
        } catch (Exception $e) {
            Log::error('Gagal menghapus dokumen: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus dokumen.')->with('swal', 'error');
        }
    }
}
