<div class="modal fade" id="editGalleryModal-{{ $gallery->id }}" tabindex="-1" aria-labelledby="editGalleryModalLabel-{{ $gallery->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.activity.gallery.update', ['activity' => $activity->id, 'gallery' => $gallery->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Gambar (opsional)</label>
                        <input type="file" name="image" class="form-control">
                        <small>Gambar lama: <img src="{{ asset('storage/' . $gallery->image) }}" width="100"></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Caption</label>
                        <input type="text" name="caption" class="form-control" value="{{ $gallery->caption }}">
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
