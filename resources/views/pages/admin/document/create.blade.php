<div class="modal fade" id="createDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.activity.document.store', $activity->id) }}" method="POST"
            enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Dokumen</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">File</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="visibility" class="form-label">Visibility</label>
                    <select name="visibility" class="form-select">
                        <option value="publish" selected>Publish</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" type="submit" id="submitBtn">
                    <span class="spinner-border spinner-border-sm d-none"></span>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
