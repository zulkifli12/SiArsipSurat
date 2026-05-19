@extends('layouts.app')

@section('title', 'Surat Keluar')

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
    max-width: 650px;
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

/* --- STYLING SPESIFIK SURAT KELUAR --- */
.badge-category {
    background: #f1f5f9;
    color: #475569;
    font-weight: 700;
    font-size: 12px;
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    display: inline-block;
}

.btn-download {
    background: #eff6ff;
    color: var(--info);
    border: 1px solid #bfdbfe;
    padding: 8px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-download:hover {
    background: var(--info);
    color: white;
    border-color: var(--info);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

/* Responsif DataTables & Modal */
@media (max-width: 768px) {
    .dt-top-container, .dt-bottom-container { flex-direction: column; align-items: stretch; gap: 20px; }
    .dataTables_wrapper .dataTables_filter input { width: 100%; margin-left: 0; margin-top: 8px; }
    .dataTables_wrapper .dataTables_filter { flex-direction: column; align-items: flex-start; }
    .dataTables_wrapper .dataTables_paginate { justify-content: center; flex-wrap: wrap; }
    .dataTables_wrapper .dataTables_info { text-align: center; }
    .modal-card { padding: 28px 24px; }
    .form-grid-2 { grid-template-columns: 1fr; gap: 0; }
}
</style>
@endpush

@section('content')
<div class="card-container">
    <div class="card-header" style="margin-bottom: 24px;">
        <h3>Daftar Surat Keluar</h3>
        <div class="header-actions">
            @if(config('app.demo_mode', true))
            <button type="button" class="btn btn-primary" onclick="showPremiumContactPopup('Registrasi Surat Keluar')" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <span style="font-size: 16px;">🔒</span>
                <span>Registrasi Surat Keluar</span>
            </button>
            @else
            <button type="button" class="btn btn-primary" onclick="openAddModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Registrasi Surat Keluar</span>
            </button>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table id="surat-keluar-table" class="activity-table display" style="width:100%">
            <thead>
                <tr>
                    <th>Nomor & Perihal Surat</th>
                    <th>Penerima / Tujuan</th>
                    <th>Kategori</th>
                    <th>Tanggal Surat</th>
                    <th style="text-align: center;">Lampiran</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suratKeluar as $item)
                    <tr>
                        <td>
                            <div class="letter-meta">
                                <div class="avatar" style="width: 38px; height: 38px; font-size: 15px; background: #eff6ff; color: var(--info); box-shadow: 0 4px 8px rgba(59,130,246,0.15);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                </div>
                                <div class="letter-info">
                                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 2px;">{{ $item->no_surat }}</h4>
                                    <p style="font-size: 13px; color: var(--text-muted); font-weight: 600;">{{ $item->perihal }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--text-main);">{{ $item->penerima }}</div>
                        </td>
                        <td>
                            <span class="badge-category">{{ $item->kategori->nama ?? 'Tanpa Kategori' }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--text-main); font-size: 13px;">{{ \Carbon\Carbon::parse($item->tgl_surat)->locale('id')->isoFormat('D MMM YYYY') }}</div>
                        </td>
                        <td style="text-align: center;">
                            @if($item->dokumen)
                                @if(config('app.demo_mode', true))
                                    <a href="#" onclick="event.preventDefault(); showPremiumContactPopup('Unduh Dokumen Lampiran')" class="btn-download" title="Fitur Terkunci (Edisi GitHub)" style="background: #fff1f2; color: #e11d48; border-color: #fecdd3;">
                                        <span style="font-size: 14px;">🔒</span>
                                        <span>Unduh</span>
                                    </a>
                                @else
                                    <a href="{{ route('surat-keluar.download', $item->id) }}" class="btn-download" title="Unduh Dokumen">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        <span>Unduh</span>
                                    </a>
                                @endif
                            @else
                                <span style="color: var(--text-muted); font-size: 12px; font-weight: 500;">— Tidak ada —</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons" style="justify-content: flex-end;">
                                @if(config('app.demo_mode', true))
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="showPremiumContactPopup('Edit Surat Keluar')" title="Fitur Terkunci (Edisi GitHub)" style="padding: 8px 14px; font-weight: 700; border-radius: 10px; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0;">
                                        <span>🔒 Edit</span>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="showPremiumContactPopup('Hapus Surat Keluar')" title="Fitur Terkunci (Edisi GitHub)" style="padding: 8px 14px; font-weight: 700; border-radius: 10px; background: #fff1f2; color: #f43f5e; border: 1px solid #ffe4e6;">
                                        <span>🔒 Hapus</span>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->no_surat) }}', '{{ addslashes($item->penerima) }}', '{{ addslashes($item->perihal) }}', '{{ $item->kategori_id }}', '{{ $item->tgl_surat }}', '{{ addslashes($item->keterangan ?: '') }}')" title="Edit Surat Keluar" style="padding: 8px 14px; font-weight: 700; border-radius: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        <span>Edit</span>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('surat-keluar.destroy', $item->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $item->id }}', '{{ addslashes($item->no_surat) }}')" title="Hapus Surat Keluar" style="padding: 8px 14px; font-weight: 700; border-radius: 10px;">
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

<!-- MODAL TAMBAH SURAT KELUAR -->
<div id="add-surat-modal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Registrasi Surat Keluar</h3>
            <button type="button" class="btn-close" onclick="closeAddModal()" title="Tutup Modal">×</button>
        </div>

        <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-grid-2">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="add-no_surat" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Nomor Surat *</label>
                    <input type="text" id="add-no_surat" name="no_surat" class="form-control" value="{{ old('no_surat', $defaultNoSurat) }}" placeholder="Contoh: PTPN/SK/2026/05/001" required autofocus style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                    @if($errors->any() && !old('_method'))
                        @error('no_surat') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                    @endif
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="add-kategori_id" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Kategori Surat *</label>
                    <select id="add-kategori_id" name="kategori_id" class="form-control" required style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                    @if($errors->any() && !old('_method'))
                        @error('kategori_id') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                    @endif
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="add-penerima" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Penerima / Instansi Tujuan *</label>
                <input type="text" id="add-penerima" name="penerima" class="form-control" value="{{ old('penerima') }}" placeholder="Contoh: PT Pertamina / Dinas Pendidikan..." required style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                @if($errors->any() && !old('_method'))
                    @error('penerima') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                @endif
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="add-perihal" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Perihal / Subjek *</label>
                <input type="text" id="add-perihal" name="perihal" class="form-control" value="{{ old('perihal') }}" placeholder="Contoh: Surat Pengantar Laporan Bulanan..." required style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                @if($errors->any() && !old('_method'))
                    @error('perihal') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                @endif
            </div>

            <div class="form-grid-2">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="add-tgl_surat" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Tanggal Surat *</label>
                    <input type="date" id="add-tgl_surat" name="tgl_surat" class="form-control" value="{{ old('tgl_surat', date('Y-m-d')) }}" required style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                    @if($errors->any() && !old('_method'))
                        @error('tgl_surat') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                    @endif
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="add-dokumen" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Upload Dokumen Lampiran (PDF/JPG/PNG, Max {{ $maxUploadMB }}MB)</label>
                    <input type="file" id="add-dokumen" name="dokumen" class="form-control" accept=".pdf,.jpg,.jpeg,.png" style="width:100%; padding:10px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                    @if($errors->any() && !old('_method'))
                        @error('dokumen') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                    @endif
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 36px;">
                <label for="add-keterangan" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Keterangan / Catatan Tambahan (Opsional)</label>
                <textarea id="add-keterangan" name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan khusus jika ada..." style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">{{ old('keterangan') }}</textarea>
                @if($errors->any() && !old('_method'))
                    @error('keterangan') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                @endif
            </div>

            <div style="display: flex; gap: 16px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeAddModal()" style="padding:12px 24px; border-radius:12px; font-weight:700; background:#f1f5f9; border:1px solid #cbd5e1; color:#64748b; cursor:pointer;">Batal</button>
                <button type="submit" class="btn btn-primary" style="padding:12px 24px; border-radius:12px; font-weight:700; background:linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border:none; color:white; cursor:pointer; display:flex; align-items:center; gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Surat Keluar</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT SURAT KELUAR -->
<div id="edit-surat-modal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Edit Surat Keluar</h3>
            <button type="button" class="btn-close" onclick="closeEditModal()" title="Tutup Modal">×</button>
        </div>

        <form id="edit-surat-form" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id" name="id" value="{{ old('id') }}">

            <div class="form-grid-2">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="edit-no_surat" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Nomor Surat *</label>
                    <input type="text" id="edit-no_surat" name="no_surat" class="form-control" value="{{ old('no_surat') }}" placeholder="Contoh: PTPN/SK/2026/05/001" required autofocus style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                    @if($errors->any() && old('_method') === 'PUT')
                        @error('no_surat') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                    @endif
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="edit-kategori_id" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Kategori Surat *</label>
                    <select id="edit-kategori_id" name="kategori_id" class="form-control" required style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                    @if($errors->any() && old('_method') === 'PUT')
                        @error('kategori_id') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                    @endif
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="edit-penerima" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Penerima / Instansi Tujuan *</label>
                <input type="text" id="edit-penerima" name="penerima" class="form-control" value="{{ old('penerima') }}" placeholder="Contoh: PT Pertamina / Dinas Pendidikan..." required style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                @if($errors->any() && old('_method') === 'PUT')
                    @error('penerima') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                @endif
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="edit-perihal" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Perihal / Subjek *</label>
                <input type="text" id="edit-perihal" name="perihal" class="form-control" value="{{ old('perihal') }}" placeholder="Contoh: Surat Pengantar Laporan Bulanan..." required style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                @if($errors->any() && old('_method') === 'PUT')
                    @error('perihal') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                @endif
            </div>

            <div class="form-grid-2">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="edit-tgl_surat" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Tanggal Surat *</label>
                    <input type="date" id="edit-tgl_surat" name="tgl_surat" class="form-control" value="{{ old('tgl_surat') }}" required style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                    @if($errors->any() && old('_method') === 'PUT')
                        @error('tgl_surat') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                    @endif
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="edit-dokumen" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Ganti Dokumen Lampiran (PDF/JPG/PNG, Max {{ $maxUploadMB }}MB - Biarkan kosong jika tidak ganti)</label>
                    <input type="file" id="edit-dokumen" name="dokumen" class="form-control" accept=".pdf,.jpg,.jpeg,.png" style="width:100%; padding:10px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                    @if($errors->any() && old('_method') === 'PUT')
                        @error('dokumen') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                    @endif
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 36px;">
                <label for="edit-keterangan" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Keterangan / Catatan Tambahan (Opsional)</label>
                <textarea id="edit-keterangan" name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan khusus jika ada..." style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">{{ old('keterangan') }}</textarea>
                @if($errors->any() && old('_method') === 'PUT')
                    @error('keterangan') <span class="text-danger" style="font-size:12px; color:var(--danger); margin-top:6px; display:block;">{{ $message }}</span> @enderror
                @endif
            </div>

            <div style="display: flex; gap: 16px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()" style="padding:12px 24px; border-radius:12px; font-weight:700; background:#f1f5f9; border:1px solid #cbd5e1; color:#64748b; cursor:pointer;">Batal</button>
                <button type="submit" class="btn btn-primary" style="padding:12px 24px; border-radius:12px; font-weight:700; background:linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border:none; color:white; cursor:pointer; display:flex; align-items:center; gap:8px;">
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
        $('#surat-keluar-table').DataTable({
            dom: '<"dt-top-container"lf>rt<"dt-bottom-container"ip>',
            language: {
                search: "Cari Surat Keluar:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ surat keluar",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 surat keluar",
                infoFiltered: "(disaring dari _MAX_ total surat keluar)",
                zeroRecords: "Tidak ada data surat keluar yang cocok dengan pencarian",
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
                { orderable: false, targets: [4, 5] } // Kolom lampiran dan aksi dinonaktifkan dari pengurutan
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

    // SweetAlert2 Konfirmasi Hapus Surat Keluar
    function confirmDelete(formId, noSurat) {
        Swal.fire({
            title: 'Hapus Surat Keluar?',
            text: "Anda yakin ingin menghapus surat nomor '" + noSurat + "' beserta file lampirannya? Tindakan ini tidak dapat dibatalkan.",
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

    // Fungsi Buka & Tutup Modal Tambah Surat Keluar
    function openAddModal() {
        const modal = document.getElementById('add-surat-modal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('add-no_surat').focus(), 100);
        }
    }

    function closeAddModal() {
        const modal = document.getElementById('add-surat-modal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Fungsi Buka & Tutup Modal Edit Surat Keluar
    function openEditModal(id, no_surat, penerima, perihal, kategori_id, tgl_surat, keterangan) {
        const modal = document.getElementById('edit-surat-modal');
        const form = document.getElementById('edit-surat-form');
        if (modal && form) {
            form.action = '/surat-keluar/' + id;
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-no_surat').value = no_surat;
            document.getElementById('edit-penerima').value = penerima;
            document.getElementById('edit-perihal').value = perihal;
            document.getElementById('edit-kategori_id').value = kategori_id;
            document.getElementById('edit-tgl_surat').value = tgl_surat;
            document.getElementById('edit-keterangan').value = keterangan;
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('edit-no_surat').focus(), 100);
        }
    }

    function closeEditModal() {
        const modal = document.getElementById('edit-surat-modal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Menutup modal jika mengklik area overlay di luar kartu modal
    window.addEventListener('click', function(event) {
        const addModal = document.getElementById('add-surat-modal');
        const editModal = document.getElementById('edit-surat-modal');
        if (event.target === addModal) closeAddModal();
        if (event.target === editModal) closeEditModal();
    });

    // Menutup modal dengan tombol Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const addModal = document.getElementById('add-surat-modal');
            const editModal = document.getElementById('edit-surat-modal');
            if (addModal && addModal.classList.contains('active')) closeAddModal();
            if (editModal && editModal.classList.contains('active')) closeEditModal();
        }
    });

    // Otomatis membuka modal jika terdapat error validasi dari backend Laravel
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            @if(old('_method') === 'PUT')
                openEditModal({{ old('id') ?? 0 }}, '{{ addslashes(old('no_surat')) }}', '{{ addslashes(old('penerima')) }}', '{{ addslashes(old('perihal')) }}', '{{ old('kategori_id') }}', '{{ old('tgl_surat') }}', '{{ addslashes(old('keterangan')) }}');
            @else
                openAddModal();
            @endif
        });
    @endif
</script>
@endpush
