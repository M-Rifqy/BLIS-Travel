<div class="modal fade" id="createGalleryModal" tabindex="-1" aria-labelledby="createGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.activity.gallery.store', $activity->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Caption</label>
                        <input type="text" name="caption" class="form-control">
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
</div>
