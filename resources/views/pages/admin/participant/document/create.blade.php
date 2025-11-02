<div class="modal fade" id="createDocumentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.activity.participant.document.store', [
                'activity' => $participant->activity_id,
                'participant' => $participant->id
            ]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Upload Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Judul Dokumen</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>File Dokumen</label>
                        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
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
