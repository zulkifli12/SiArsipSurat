@extends('layouts.app')

@section('title', 'Riwayat Notifikasi Sistem')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<style>
/* --- PREMIUM DATATABLES KUSTOMISASI --- */
.dataTables_wrapper {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-main);
    padding-top: 12px;
}

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

.dataTables_wrapper .dataTables_length { margin: 0; float: none; display: flex; align-items: center; font-size: 14px; font-weight: 600; color: var(--text-muted); }
.dataTables_wrapper .dataTables_length select { border: 1px solid #cbd5e1; border-radius: 12px; padding: 8px 16px; margin: 0 8px; outline: none; font-family: inherit; font-size: 14px; font-weight: 700; color: var(--text-main); background-color: #f8fafc; cursor: pointer; transition: all 0.2s ease; }
.dataTables_wrapper .dataTables_length select:hover, .dataTables_wrapper .dataTables_length select:focus { background-color: white; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1); }

.dataTables_wrapper .dataTables_filter { margin: 0; float: none; display: flex; align-items: center; font-size: 14px; font-weight: 600; color: var(--text-muted); }
.dataTables_wrapper .dataTables_filter input { border: 1px solid #cbd5e1; border-radius: 14px; padding: 10px 18px; margin-left: 12px; outline: none; font-family: inherit; font-size: 14px; font-weight: 500; color: var(--text-main); background-color: #f8fafc; width: 280px; transition: all 0.2s ease; }
.dataTables_wrapper .dataTables_filter input:focus { background-color: white; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1); width: 320px; }

table.dataTable { border-collapse: collapse !important; width: 100% !important; margin: 0 !important; border: none !important; }
table.dataTable thead th { background: #f1f5f9; padding: 16px 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); border-bottom: none !important; letter-spacing: 0.5px; }
table.dataTable thead th:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
table.dataTable thead th:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

table.dataTable tbody td { padding: 20px 20px; vertical-align: middle; border-bottom: 1px solid #f1f5f9 !important; font-size: 14px; }
table.dataTable tbody tr { transition: background 0.2s ease; }
table.dataTable tbody tr:hover { background-color: #f8fafc; }
table.dataTable.no-footer { border-bottom: none !important; }

.dt-bottom-container { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-top: 28px; padding-top: 24px; border-top: 1px solid var(--border); }
.dataTables_wrapper .dataTables_info { margin: 0; padding: 0; float: none; font-size: 13px; font-weight: 600; color: var(--text-muted); }
.dataTables_wrapper .dataTables_paginate { margin: 0; padding: 0; float: none; display: flex; align-items: center; gap: 4px; }
.dataTables_wrapper .dataTables_paginate .paginate_button { display: inline-flex; align-items: center; justify-content: center; min-width: 38px; height: 38px; padding: 0 14px !important; margin: 0 2px; border-radius: 12px !important; border: 1px solid var(--border) !important; background: #f8fafc !important; font-size: 13px; font-weight: 700; color: var(--text-muted) !important; transition: all 0.2s ease; cursor: pointer; box-shadow: var(--shadow-sm); }
.dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) { background: white !important; color: var(--primary) !important; border-color: var(--primary) !important; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15); }
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important; color: white !important; border-color: var(--primary) !important; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25); }
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover { opacity: 0.5; cursor: not-allowed; background: #f1f5f9 !important; border-color: var(--border) !important; color: #94a3b8 !important; box-shadow: none; transform: none; }

.badge-notif { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800; text-transform: uppercase; display: inline-block; }
.badge-unread { background: #fee2e2; color: #e11d48; border: 1px solid #fecdd3; }
.badge-read { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

@media (max-width: 768px) {
    .dt-top-container, .dt-bottom-container { flex-direction: column; align-items: stretch; gap: 20px; }
    .dataTables_wrapper .dataTables_filter input { width: 100%; margin-left: 0; margin-top: 8px; }
    .dataTables_wrapper .dataTables_filter { flex-direction: column; align-items: flex-start; }
    .dataTables_wrapper .dataTables_paginate { justify-content: center; flex-wrap: wrap; }
    .dataTables_wrapper .dataTables_info { text-align: center; }
}
</style>
@endpush

@section('content')
<div class="card-container">
    <div class="card-header" style="margin-bottom: 24px;">
        <h3>Riwayat Seluruh Notifikasi Sistem</h3>
        <div class="header-actions">
            <button type="button" class="btn btn-secondary" onclick="markAllNotificationsAsRead()" style="padding: 10px 20px; font-weight: 700; border-radius: 12px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:inline-block; vertical-align:middle; margin-right:6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Tandai Semua Dibaca</span>
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="notifications-table" class="activity-table display" style="width:100%">
            <thead>
                <tr>
                    <th>Judul Notifikasi</th>
                    <th>Pesan / Rincian</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as $item)
                    <tr>
                        <td>
                            <div class="letter-meta">
                                <div class="avatar" style="width: 38px; height: 38px; font-size: 15px; background: #eff6ff; color: var(--info); box-shadow: 0 4px 8px rgba(59,130,246,0.15);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                </div>
                                <div class="letter-info">
                                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 2px;">{{ $item->data['title'] ?? 'Informasi Sistem' }}</h4>
                                    <p style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Tipe: {{ strtoupper($item->type) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="color: var(--text-muted); line-height: 1.5; font-weight: 500;">{{ $item->data['message'] ?? '—' }}</div>
                        </td>
                        <td style="text-align: center;">
                            @if(!$item->read_at)
                                <span class="badge-notif badge-unread">Belum Dibaca</span>
                            @else
                                <span class="badge-notif badge-read">Sudah Dibaca</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <span style="font-size: 13px; font-weight: 600; color: var(--text-muted);">{{ $item->created_at->locale('id')->diffForHumans() }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#notifications-table').DataTable({
            dom: '<"dt-top-container"lf>rt<"dt-bottom-container"ip>',
            language: {
                search: "Cari Notifikasi:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ notifikasi",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 notifikasi",
                infoFiltered: "(disaring dari _MAX_ total notifikasi)",
                zeroRecords: "Tidak ada data notifikasi yang cocok dengan pencarian",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            ordering: true,
            order: [[3, 'desc']], // Urutkan berdasarkan kolom waktu
            responsive: true
        });
    });
</script>
@endpush
