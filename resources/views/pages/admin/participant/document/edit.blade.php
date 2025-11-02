<div class="modal fade" id="editDocumentModal-{{ $document->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.activity.participant.document.update', [
                'activity' => $participant->activity_id,
                'participant' => $participant->id,
                'document' => $document->id
            ]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Judul Dokumen</label>
                        <input type="text" name="title" class="form-control" value="{{ $document->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Ganti File (Opsional)</label>
                        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
