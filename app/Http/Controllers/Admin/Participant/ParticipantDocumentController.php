<?php

namespace App\Http\Controllers\Admin\Participant;

use Exception;
use App\Models\Activity;
use App\Models\Document;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ParticipantDocumentController extends Controller
{
    public function index($activityId, $participantId)
    {
        $participant = Participant::with('activity')->findOrFail($participantId);
        $documents = Document::where('activity_id', $activityId)
            ->where('participant_id', $participantId)
            ->get();

        return view('pages.admin.participant.document.index', compact('participant', 'documents'));
    }

    public function store(Request $request, $activityId, $participantId)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'file'  => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            ], [
                'title.required' => 'Judul dokumen wajib diisi.',
                'title.max' => 'Judul maksimal 255 karakter.',
                'file.required' => 'File wajib diunggah.',
                'file.mimes' => 'Format file tidak valid (pdf, doc, docx, jpg, jpeg, png).',
                'file.max' => 'Ukuran file maksimal 5MB.',
            ]);

            $filePath = $request->file('file')->store('documents', 'public');

            Document::create([
                'activity_id'    => $activityId,
                'participant_id' => $participantId,
                'title'          => $request->title,
                'file'           => $filePath,
                'visibility'     => 'publish',
            ]);

            return back()->with('success', 'Dokumen berhasil diunggah.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Gagal mengunggah dokumen: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengunggah dokumen.')->with('swal', 'error');
        }
    }

    public function update(Request $request, $activityId, $participantId, $documentId)
    {
        try {
            $document = Document::findOrFail($documentId);

            $request->validate([
                'title' => 'required|string|max:255',
                'file'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            ], [
                'title.required' => 'Judul dokumen wajib diisi.',
                'title.max' => 'Judul maksimal 255 karakter.',
                'file.mimes' => 'Format file tidak valid (pdf, doc, docx, jpg, jpeg, png).',
                'file.max' => 'Ukuran file maksimal 5MB.',
            ]);

            if ($request->hasFile('file')) {
                if ($document->file && Storage::disk('public')->exists($document->file)) {
                    Storage::disk('public')->delete($document->file);
                }
                $document->file = $request->file('file')->store('documents', 'public');
            }

            $document->title = $request->title;
            $document->save();

            return back()->with('success', 'Dokumen berhasil diperbarui.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Gagal memperbarui dokumen: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui dokumen.')->with('swal', 'error');
        }
    }

    public function destroy($activityId, $participantId, $documentId)
    {
        try {
            $document = Document::findOrFail($documentId);

            if ($document->file && Storage::disk('public')->exists($document->file)) {
                Storage::disk('public')->delete($document->file);
            }

            $document->delete();

            return back()->with('success', 'Dokumen berhasil dihapus.')->with('swal', 'success');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Gagal menghapus dokumen: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus dokumen.')->with('swal', 'error');
        }
    }
}
