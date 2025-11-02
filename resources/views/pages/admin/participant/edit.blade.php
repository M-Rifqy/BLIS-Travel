<div class="modal fade" id="editParticipantModal-{{ $participant->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.activity.participant.update', [$activity->id, $participant->id]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control"
                            value="{{ $participant->full_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{ $participant->user?->email ?? '' }}"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $participant->phone }}">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $participant->status == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="active" {{ $participant->status == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="completed" {{ $participant->status == 'completed' ? 'selected' : '' }}>
                                Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>QR Token</label>
                        <input type="text" class="form-control" value="{{ $participant->qr_token }}" readonly>
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
