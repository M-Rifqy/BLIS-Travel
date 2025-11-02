<div class="modal fade" id="editActivityModal-{{ $activity->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.activity.update', $activity->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ $activity->title }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ $activity->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Lokasi</label>
                        <input type="text" name="location" class="form-control" value="{{ $activity->location }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ $activity->start_date }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $activity->end_date }}"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit" id="submitBtn">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
