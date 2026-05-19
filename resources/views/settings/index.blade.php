@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@push('styles')
<style>
/* --- STYLING PENGATURAN SISTEM --- */
.settings-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
}

@media (max-width: 1024px) {
    .settings-grid {
        grid-template-columns: 1fr;
    }
}

.section-card {
    background: white;
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    padding: 36px 40px;
    margin-bottom: 32px;
    transition: all 0.3s ease;
}

.section-card:hover {
    box-shadow: var(--shadow-md);
    border-color: #cbd5e1;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 32px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
}

.section-icon {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    background: var(--primary-light);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.section-title h3 {
    font-size: 18px;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 4px;
}

.section-title p {
    font-size: 13px;
    color: var(--text-muted);
}

.form-group-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 640px) {
    .form-group-grid {
        grid-template-columns: 1fr;
    }
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
</style>
@endpush

@section('content')
<form action="{{ route('settings.update') }}" method="POST">
    @csrf

    <div class="settings-grid">
        <!-- SEKSI 1: IDENTITAS & KONTAK INSTANSI -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="section-title">
                    <h3>Identitas & Kontak Instansi</h3>
                    <p>Konfigurasi nama aplikasi, deskripsi, dan informasi kontak resmi surat-menyurat.</p>
                </div>
            </div>

            <div class="form-group">
                <label for="app_name" class="form-label">Nama Aplikasi / Instansi</label>
                <input type="text" id="app_name" name="app_name" class="form-control" value="{{ old('app_name', $settings['app_name'] ?? 'Arsip Surat PTPN IV') }}" placeholder="Contoh: Arsip Surat PTPN IV" required>
                @error('app_name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="app_description" class="form-label">Deskripsi Sistem</label>
                <textarea id="app_description" name="app_description" class="form-control" rows="3" placeholder="Sistem manajemen arsip digital terintegrasi...">{{ old('app_description', $settings['app_description'] ?? 'Sistem Manajemen Arsip Digital Terintegrasi PTPN Holding') }}</textarea>
                @error('app_description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group-grid">
                <div class="form-group">
                    <label for="contact_email" class="form-label">Email Kontak Resmi</label>
                    <input type="email" id="contact_email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? 'arsip@ptpn4.co.id') }}" placeholder="arsip@ptpn.co.id" required>
                    @error('contact_email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="contact_phone" class="form-label">Nomor Telepon / WhatsApp</label>
                    <input type="text" id="contact_phone" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '(061) 4567890') }}" placeholder="(061) 4567890">
                    @error('contact_phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="company_address" class="form-label">Alamat Lengkap Kantor</label>
                <input type="text" id="company_address" name="company_address" class="form-control" value="{{ old('company_address', $settings['company_address'] ?? 'Jl. Letjen Suprapto No.2, Medan, Sumatera Utara') }}" placeholder="Jl. Letjen Suprapto No.2...">
                @error('company_address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- SEKSI 2: PREFERENSI PENGARSIPAN & SISTEM -->
        <div>
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon" style="background: #eff6ff; color: var(--info);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    </div>
                    <div class="section-title">
                        <h3>Preferensi Pengarsipan & Sistem</h3>
                        <p>Atur format penomoran surat otomatis dan batasan ukuran file lampiran digital.</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="max_upload_size" class="form-label">Batas Maksimal Ukuran File Scan (MB)</label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input type="number" id="max_upload_size" name="max_upload_size" class="form-control" value="{{ old('max_upload_size', $settings['max_upload_size'] ?? '10') }}" min="1" max="50" required style="padding-right: 50px;">
                        <span style="position: absolute; right: 18px; font-weight: 700; color: var(--text-muted); font-size: 14px;">MB</span>
                    </div>
                    <span style="font-size: 12px; color: var(--text-muted); margin-top: 6px; display: block;">* Batas ukuran lampiran PDF yang diizinkan saat mengunggah arsip (Maksimal 50 MB).</span>
                    @error('max_upload_size') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="letter_number_format" class="form-label">Format Penomoran Surat Default</label>
                    <input type="text" id="letter_number_format" name="letter_number_format" class="form-control" value="{{ old('letter_number_format', $settings['letter_number_format'] ?? 'PTPN-IV/SM/{tahun}/{bulan}/{nomor}') }}" required>
                    <span style="font-size: 12px; color: var(--text-muted); margin-top: 6px; display: block;">* Variabel yang didukung: <code style="background:#f1f5f9; padding:2px 6px; border-radius:4px;">{tahun}</code>, <code style="background:#f1f5f9; padding:2px 6px; border-radius:4px;">{bulan}</code>, <code style="background:#f1f5f9; padding:2px 6px; border-radius:4px;">{nomor}</code>.</span>
                    @error('letter_number_format') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- CARD AKSI SIMPAN -->
            <div class="section-card" style="display: flex; align-items: center; justify-content: space-between; padding: 28px 40px; background: linear-gradient(135deg, var(--primary-light) 0%, white 100%); border-color: #a7f3d0;">
                <div>
                    <h4 style="font-size: 16px; font-weight: 800; color: var(--primary); margin-bottom: 2px;">Simpan Perubahan Sistem</h4>
                    <p style="font-size: 13px; color: var(--text-muted);">Pastikan seluruh data yang dimasukkan sudah benar dan valid.</p>
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 16px 32px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // SweetAlert2 Notifikasi Sukses & Error dari Session Laravel (Tanpa Progress Bar)
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
</script>
@endpush
