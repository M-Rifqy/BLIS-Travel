<div class="modal fade" id="editDocumentModal-{{ $doc->id }}" tabindex="-1" aria-labelledby="editDocumentModalLabel-{{ $doc->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDocumentModalLabel-{{ $doc->id }}">Edit Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.activity.document.update', ['activity' => $activity->id, 'document' => $doc->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title-{{ $doc->id }}" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" id="title-{{ $doc->id }}" value="{{ $doc->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="file-{{ $doc->id }}" class="form-label">File (opsional)</label>
                        <input type="file" name="file" class="form-control" id="file-{{ $doc->id }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Visibility</label>
                        <select name="visibility" class="form-select">
                            <option value="publish" {{ $doc->visibility == 'publish' ? 'selected' : '' }}>publish</option>
                            <option value="draft" {{ $doc->visibility == 'draft' ? 'selected' : '' }}>draft</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
