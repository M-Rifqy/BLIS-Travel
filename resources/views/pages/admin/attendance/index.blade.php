@extends('layouts.admin.index')

@section('title', 'Absensi Kegiatan')

@section('content')
    <div class="pagetitle">
        <h1>Absensi: {{ $activity->title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.activity.index') }}">Kegiatan</a></li>
                <li class="breadcrumb-item active">Absensi</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Absensi</h5>

            <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#scanAttendanceModal">
                <i class="bi bi-qr-code-scan"></i> Scan Absensi
            </button>

            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="attendance-table">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>Email</th>
                            <th>Check-in Time</th>
                            <th>Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $index => $attendance)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $attendance->participant->full_name }}</td>
                                <td>{{ $attendance->participant->user?->email ?? '-' }}</td>
                                <td>{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('d M Y H:i') : '-' }}
                                </td>
                                <td>{{ $attendance->group ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Scan QR --}}
    <div class="modal fade" id="scanAttendanceModal" tabindex="-1" aria-labelledby="scanAttendanceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scan QR Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="stopScanner()"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Grup</label>
                        <div class="d-flex gap-2">
                            <select id="scanGroup" class="form-select flex-grow-1">
                                <option value="">-- Pilih Grup --</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group }}">{{ $group }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-primary" id="newGroupBtn">Group Baru</button>
                        </div>
                        <div class="mt-2 d-none" id="newGroupInputWrapper">
                            <input type="text" id="newGroupInput" class="form-control" placeholder="Nama group baru">
                            <button type="button" class="btn btn-success mt-2" id="setNewGroupBtn">Simpan Group
                                Baru</button>
                        </div>

                        <div class="mt-2 d-none" id="newGroupInputWrapper">
                            <input type="text" id="newGroupInput" class="form-control" placeholder="Nama group baru">
                            <button type="button" class="btn btn-success mt-2" id="setNewGroupBtn">Simpan Group
                                Baru</button>
                        </div>
                    </div>

                    <div id="reader" style="width:100%; max-width:600px; aspect-ratio:4/3; margin:auto;"></div>
                    <div class="mt-3 text-center">
                        <span id="scan-result" class="text-success"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="stopScanner()">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        let html5QrcodeScanner;
        let selectedGroup = null;
        let scanning = false;

        $(document).ready(function() {
            // Pilih grup
            $('#scanGroup').on('change', function() {
                selectedGroup = $(this).val() || null;
            });

            // Tombol Group Baru
            $('#newGroupBtn').click(() => {
                $('#newGroupInputWrapper').removeClass('d-none');
                $('#scanGroup').val('');
                selectedGroup = null;
            });

            $('#setNewGroupBtn').click(() => {
                const newGroup = $('#newGroupInput').val().trim();
                if (!newGroup) return alert('Nama group baru wajib diisi');

                selectedGroup = newGroup;
                const newOption = new Option(newGroup, newGroup, true, true);
                $('#scanGroup').append(newOption);
                $('#scanGroup').val(newGroup);

                $('#newGroupInputWrapper').addClass('d-none');
                $('#newGroupInput').val('');
            });
        });

        // Scanner
        function startScanner() {
            const readerElement = document.getElementById("reader");
            const qrBoxSize = Math.min(readerElement.offsetWidth, 400);

            html5QrcodeScanner = new Html5Qrcode("reader");
            const qrConfig = {
                fps: 10,
                qrbox: qrBoxSize
            };

            html5QrcodeScanner.start({
                    facingMode: "environment"
                },
                qrConfig,
                qrCodeMessage => {
                    if (scanning) return;
                    scanning = true;

                    if (!selectedGroup) {
                        Swal.fire('Info', 'Pilih grup terlebih dahulu sebelum scan!', 'info');
                        scanning = false;
                        return;
                    }

                    $('#scan-result').text(`QR Terdeteksi: ${qrCodeMessage}`);

                    fetch("{{ route('admin.activity.attendance.scan', $activity->id) }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                qr_token: qrCodeMessage,
                                group: selectedGroup
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                addAttendanceRow(data.attendance);

                                if ($('#scanGroup option[value="' + data.attendance.group + '"]').length === 0) {
                                    const newOption = new Option(data.attendance.group, data.attendance.group);
                                    $('#scanGroup').append(newOption);
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        })
                        .catch(err => Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan.',
                            timer: 1500,
                            showConfirmButton: false
                        }))
                        .finally(() => setTimeout(() => scanning = false, 2000));
                },
                errorMessage => console.log('QR scan error:', errorMessage)
            ).catch(err => console.error('Unable to start scanner', err));
        }

        function stopScanner() {
            if (html5QrcodeScanner) html5QrcodeScanner.stop().then(() => html5QrcodeScanner.clear()).catch(err => console
                .error(err));
        }

        // Tambah row ke tabel
        function addAttendanceRow(attendance) {
            const table = document.querySelector('#attendance-table tbody');
            const rowCount = table.rows.length + 1;
            const row = table.insertRow();
            row.innerHTML = `
        <td class="text-center">${rowCount}</td>
        <td>${attendance.participant_name}</td>
        <td>${attendance.email}</td>
        <td>${attendance.check_in_time}</td>
        <td>${attendance.group}</td>
    `;
        }

        // Event modal
        const scanModal = document.getElementById('scanAttendanceModal');
        scanModal.addEventListener('shown.bs.modal', startScanner);
        scanModal.addEventListener('hidden.bs.modal', stopScanner);
    </script>
@endpush
