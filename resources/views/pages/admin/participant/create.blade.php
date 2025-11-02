<div class="modal fade" id="createParticipantModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.activity.participant.store', $activity->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Status Default</label>
                        <select name="status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="active" selected>Active</option>
                            <option value="completed">Completed</option>
                        </select>
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
