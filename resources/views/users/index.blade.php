@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<style>
/* --- PREMIUM DATATABLES KUSTOMISASI --- */
.dataTables_wrapper {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-main);
    padding-top: 12px;
}

/* Bagian Atas DataTables (Length & Search) */
.dt-top-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 28px;
    padding-bottom: 24px;
    border-bottom: 1px solid var(--border);
}

.dataTables_wrapper .dataTables_length {
    margin: 0;
    float: none;
    display: flex;
    align-items: center;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-muted);
}

.dataTables_wrapper .dataTables_length select {
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    padding: 8px 16px;
    margin: 0 8px;
    outline: none;
    font-family: inherit;
    font-size: 14px;
    font-weight: 700;
    color: var(--text-main);
    background-color: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
}

.dataTables_wrapper .dataTables_length select:hover,
.dataTables_wrapper .dataTables_length select:focus {
    background-color: white;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
}

.dataTables_wrapper .dataTables_filter {
    margin: 0;
    float: none;
    display: flex;
    align-items: center;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-muted);
}

.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #cbd5e1;
    border-radius: 14px;
    padding: 10px 18px;
    margin-left: 12px;
    outline: none;
    font-family: inherit;
    font-size: 14px;
    font-weight: 500;
    color: var(--text-main);
    background-color: #f8fafc;
    width: 280px;
    transition: all 0.2s ease;
}

.dataTables_wrapper .dataTables_filter input:focus {
    background-color: white;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
    width: 320px;
}

/* Tabel Body & Header Bawaan DataTables */
table.dataTable {
    border-collapse: collapse !important;
    width: 100% !important;
    margin: 0 !important;
    border: none !important;
}

table.dataTable thead th {
    background: #f1f5f9;
    padding: 16px 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-muted);
    border-bottom: none !important;
    letter-spacing: 0.5px;
}

table.dataTable thead th:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
table.dataTable thead th:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

table.dataTable tbody td {
    padding: 20px 20px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9 !important;
    font-size: 14px;
}

table.dataTable tbody tr {
    transition: background 0.2s ease;
}

table.dataTable tbody tr:hover {
    background-color: #f8fafc;
}

table.dataTable.no-footer {
    border-bottom: none !important;
}

/* Bagian Bawah DataTables (Info & Pagination) */
.dt-bottom-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid var(--border);
}

.dataTables_wrapper .dataTables_info {
    margin: 0;
    padding: 0;
    float: none;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-muted);
}

.dataTables_wrapper .dataTables_paginate {
    margin: 0;
    padding: 0;
    float: none;
    display: flex;
    align-items: center;
    gap: 4px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0 14px !important;
    margin: 0 2px;
    border-radius: 12px !important;
    border: 1px solid var(--border) !important;
    background: #f8fafc !important;
    font-size: 13px;
    font-weight: 700;
    color: var(--text-muted) !important;
    transition: all 0.2s ease;
    cursor: pointer;
    box-shadow: var(--shadow-sm);
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
    background: white !important;
    color: var(--primary) !important;
    border-color: var(--primary) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
    color: white !important;
    border-color: var(--primary) !important;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f1f5f9 !important;
    border-color: var(--border) !important;
    color: #94a3b8 !important;
    box-shadow: none;
    transform: none;
}

/* --- STYLING MODAL (TAMBAH & EDIT) --- */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: all 0.3s ease;
    padding: 20px;
}

.modal-overlay.active {
    opacity: 1;
    pointer-events: auto;
}

.modal-card {
    background: white;
    border-radius: var(--radius-xl);
    width: 100%;
    max-width: 550px;
    padding: 36px 40px;
    box-shadow: var(--shadow-lg);
    transform: scale(0.95) translateY(20px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    border: 1px solid var(--border);
    max-height: 90vh;
    overflow-y: auto;
}

.modal-overlay.active .modal-card {
    transform: scale(1) translateY(0);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 20px;
}

.modal-header h3 {
    font-size: 20px;
    font-weight: 800;
    color: var(--text-main);
}

.btn-close {
    background: #f1f5f9;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    font-size: 20px;
    font-weight: 700;
    color: var(--text-muted);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.btn-close:hover {
    background: var(--danger-light);
    color: var(--danger);
    transform: rotate(90deg);
}

/* --- KUSTOMISASI SWEETALERT2 --- */
div.swal-premium-popup {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    border-radius: 24px !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    padding: 32px 24px !important;
    border: 1px solid var(--border) !important;
}

div.swal-premium-popup .swal2-title {
    font-weight: 800 !important;
    color: var(--text-main) !important;
    font-size: 22px !important;
}

div.swal-premium-popup .swal2-html-container {
    font-weight: 500 !important;
    color: var(--text-muted) !important;
    font-size: 15px !important;
    margin-top: 12px !important;
}

div.swal-premium-popup .swal2-actions {
    margin-top: 28px !important;
    gap: 16px !important;
}

div.swal-premium-popup .swal2-actions button {
    border-radius: 14px !important;
    padding: 14px 28px !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    transition: all 0.2s ease !important;
}

/* Responsif DataTables & Modal */
@media (max-width: 768px) {
    .dt-top-container, .dt-bottom-container { flex-direction: column; align-items: stretch; gap: 20px; }
    .dataTables_wrapper .dataTables_filter input { width: 100%; margin-left: 0; margin-top: 8px; }
    .dataTables_wrapper .dataTables_filter { flex-direction: column; align-items: flex-start; }
    .dataTables_wrapper .dataTables_paginate { justify-content: center; flex-wrap: wrap; }
    .dataTables_wrapper .dataTables_info { text-align: center; }
    .modal-card { padding: 28px 24px; }
}
</style>
@endpush

@section('content')
<div class="card-container">
    <div class="card-header" style="margin-bottom: 24px;">
        <h3>Daftar Pengguna Sistem</h3>
        <div class="header-actions">
            <button type="button" class="btn btn-primary" onclick="openAddModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Pengguna</span>
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="users-table" class="activity-table display" style="width:100%">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Alamat Email</th>
                    <th>Tanggal Terdaftar</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="letter-meta">
                                <div class="avatar" style="width: 38px; height: 38px; font-size: 15px; box-shadow: 0 4px 8px rgba(5,150,105,0.15);">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="letter-info">
                                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 2px;">{{ $user->name }}</h4>
                                    <p style="font-size: 12px; color: var(--text-muted); font-weight: 600;">ID Pengguna: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="font-weight: 500;">{{ $user->email }}</td>
                        <td style="font-weight: 500; color: var(--text-muted);">{{ $user->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                        <td>
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" title="Edit Pengguna" style="padding: 8px 14px; font-weight: 700; border-radius: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    <span>Edit</span>
                                </button>
                                @if(auth()->id() !== $user->id)
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $user->id }}', '{{ addslashes($user->name) }}')" title="Hapus Pengguna" style="padding: 8px 14px; font-weight: 700; border-radius: 10px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH PENGGUNA -->
<div id="add-user-modal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Tambah Pengguna Baru</h3>
            <button type="button" class="btn-close" onclick="closeAddModal()" title="Tutup Modal">×</button>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="add-modal-name" class="form-label">Nama Lengkap Pengguna</label>
                <input type="text" id="add-modal-name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap..." required autofocus>
                @if($errors->any() && old('_method') !== 'PUT')
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                @endif
            </div>

            <div class="form-group">
                <label for="add-modal-email" class="form-label">Alamat Email</label>
                <input type="email" id="add-modal-email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@ptpn.co.id" required>
                @if($errors->any() && old('_method') !== 'PUT')
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                @endif
            </div>

            <div class="form-group" style="margin-bottom: 36px;">
                <label for="add-modal-password" class="form-label">Kata Sandi</label>
                <div class="password-wrapper" style="position: relative; display: flex; align-items: center;">
                    <input type="password" id="add-modal-password" name="password" class="form-control" placeholder="Minimal 6 karakter..." required style="padding-right: 42px;">
                    <button type="button" class="password-toggle" onclick="toggleModalPassword(this)" title="Tampilkan sandi" style="position: absolute; right: 12px; background: none; border: none; color: #64748b; cursor: pointer; padding: 4px; display: flex; align-items: center; justify-content: center;">
                        <svg class="eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                    </button>
                </div>
                @if($errors->any() && old('_method') !== 'PUT')
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                @endif
            </div>

            <div style="display: flex; gap: 16px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Pengguna</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PENGGUNA -->
<div id="edit-user-modal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Edit Data Pengguna</h3>
            <button type="button" class="btn-close" onclick="closeEditModal()" title="Tutup Modal">×</button>
        </div>

        <form id="edit-user-form" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-modal-id" value="{{ old('id') }}">
            
            <div class="form-group">
                <label for="edit-modal-name" class="form-label">Nama Lengkap Pengguna</label>
                <input type="text" id="edit-modal-name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap..." required autofocus>
                @if($errors->any() && old('_method') === 'PUT')
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                @endif
            </div>

            <div class="form-group">
                <label for="edit-modal-email" class="form-label">Alamat Email</label>
                <input type="email" id="edit-modal-email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@ptpn.co.id" required>
                @if($errors->any() && old('_method') === 'PUT')
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                @endif
            </div>

            <div class="form-group" style="margin-bottom: 36px;">
                <label for="edit-modal-password" class="form-label">Kata Sandi (Opsional)</label>
                <div class="password-wrapper" style="position: relative; display: flex; align-items: center;">
                    <input type="password" id="edit-modal-password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah kata sandi..." style="padding-right: 42px;">
                    <button type="button" class="password-toggle" onclick="toggleModalPassword(this)" title="Tampilkan sandi" style="position: absolute; right: 12px; background: none; border: none; color: #64748b; cursor: pointer; padding: 4px; display: flex; align-items: center; justify-content: center;">
                        <svg class="eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                    </button>
                </div>
                <span style="font-size: 12px; color: var(--text-muted); margin-top: 6px; display: block;">* Isi hanya jika Anda ingin mengganti kata sandi pengguna ini.</span>
                @if($errors->any() && old('_method') === 'PUT')
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                @endif
            </div>

            <div style="display: flex; gap: 16px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Inisialisasi DataTables
    $(document).ready(function() {
        $('#users-table').DataTable({
            dom: '<"dt-top-container"lf>rt<"dt-bottom-container"ip>',
            language: {
                search: "Cari Pengguna:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pengguna",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 pengguna",
                infoFiltered: "(disaring dari _MAX_ total pengguna)",
                zeroRecords: "Tidak ada data pengguna yang cocok dengan pencarian",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            ordering: true,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 3 } // Kolom aksi dinonaktifkan dari pengurutan
            ]
        });
    });

    // SweetAlert2 Notifikasi Sukses & Error dari Session Laravel
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false,
            customClass: { popup: 'swal-premium-popup' }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 4000,
            showConfirmButton: true,
            confirmButtonColor: '#e11d48',
            customClass: { popup: 'swal-premium-popup' }
        });
    @endif

    // SweetAlert2 Konfirmasi Hapus Pengguna
    function confirmDelete(formId, userName) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: "Anda yakin ingin menghapus akun '" + userName + "'? Tindakan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'swal-premium-popup',
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    // Fungsi Buka & Tutup Modal Tambah Pengguna
    const addModal = document.getElementById('add-user-modal');

    function openAddModal() {
        addModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('add-modal-name').focus(), 100);
    }

    function closeAddModal() {
        addModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Fungsi Buka & Tutup Modal Edit Pengguna
    const editModal = document.getElementById('edit-user-modal');

    function openEditModal(id, name, email) {
        const form = document.getElementById('edit-user-form');
        form.action = '/users/' + id;
        document.getElementById('edit-modal-id').value = id;
        document.getElementById('edit-modal-name').value = name;
        document.getElementById('edit-modal-email').value = email;
        document.getElementById('edit-modal-password').value = '';
        
        editModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('edit-modal-name').focus(), 100);
    }

    function closeEditModal() {
        editModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Menutup modal jika mengklik area overlay di luar kartu modal
    window.addEventListener('click', function(event) {
        if (event.target === addModal) closeAddModal();
        if (event.target === editModal) closeEditModal();
    });

    // Menutup modal dengan tombol Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (addModal.classList.contains('active')) closeAddModal();
            if (editModal.classList.contains('active')) closeEditModal();
        }
    });

    // Otomatis membuka modal jika terdapat error validasi dari backend Laravel
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            @if(old('_method') === 'PUT')
                openEditModal({{ old('id') ?? 0 }}, '{{ addslashes(old('name')) }}', '{{ addslashes(old('email')) }}');
            @else
                openAddModal();
            @endif
        });
    @endif

    // Toggle lihat kata sandi (eye on / eye off) di dalam modal
    function toggleModalPassword(button) {
        const wrapper = button.closest('.password-wrapper');
        const input = wrapper.querySelector('input');
        const isPassword = input.type === 'password';
        
        input.type = isPassword ? 'text' : 'password';
        button.title = isPassword ? 'Sembunyikan sandi' : 'Tampilkan sandi';
        
        button.innerHTML = isPassword 
            ? '<svg class="eye-on" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>'
            : '<svg class="eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
    }
</script>
@endpush
