@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

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

.badge-log { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800; text-transform: uppercase; display: inline-block; }
.badge-success { background: #ecfdf5; color: var(--primary); border: 1px solid #a7f3d0; }
.badge-info { background: #eff6ff; color: var(--info); border: 1px solid #bfdbfe; }
.badge-warning { background: #fef3c7; color: var(--warning); border: 1px solid #fde68a; }
.badge-danger { background: #fee2e2; color: var(--danger); border: 1px solid #fecdd3; }

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
        <h3>Riwayat Seluruh Log Aktivitas Sistem</h3>
    </div>

    <div class="table-responsive">
        <table id="logs-table" class="activity-table display" style="width:100%">
            <thead>
                <tr>
                    <th>Judul Aktivitas</th>
                    <th>Pesan / Rincian Aktivitas</th>
                    <th>Pengguna</th>
                    <th style="text-align: center;">Tipe Log</th>
                    <th style="text-align: center;">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $item)
                    <tr>
                        <td>
                            <div class="letter-meta">
                                @php
                                    $bg = '#ecfdf5'; $color = 'var(--primary)'; $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                                    if ($item->tipe === 'info') { $bg = '#eff6ff'; $color = 'var(--info)'; $icon = 'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12'; }
                                    elseif ($item->tipe === 'warning') { $bg = '#fef3c7'; $color = 'var(--warning)'; $icon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'; }
                                    elseif ($item->tipe === 'danger') { $bg = '#fee2e2'; $color = 'var(--danger)'; $icon = 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'; }
                                @endphp
                                <div class="avatar" style="width: 38px; height: 38px; font-size: 15px; background: {{ $bg }}; color: {{ $color }}; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path></svg>
                                </div>
                                <div class="letter-info">
                                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 2px;">{{ $item->judul }}</h4>
                                    <p style="font-size: 12px; color: var(--text-muted); font-weight: 600;">ID Log: #{{ $item->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="color: var(--text-muted); line-height: 1.5; font-weight: 500;">{{ $item->pesan }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--text-main); font-size: 14px;">{{ $item->user ? $item->user->name : 'Sistem Otomatis' }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);">{{ $item->user ? $item->user->email : 'system@ptpn.co.id' }}</div>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-log badge-{{ $item->tipe }}">{{ strtoupper($item->tipe) }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-size: 13px; font-weight: 600; color: var(--text-muted);" title="{{ $item->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}">{{ $item->created_at->locale('id')->diffForHumans() }}</span>
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
        $('#logs-table').DataTable({
            dom: '<"dt-top-container"lf>rt<"dt-bottom-container"ip>',
            language: {
                search: "Cari Log Aktivitas:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ log",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 log",
                infoFiltered: "(disaring dari _MAX_ total log)",
                zeroRecords: "Tidak ada data log yang cocok dengan pencarian",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            ordering: true,
            order: [[4, 'desc']], // Urutkan berdasarkan kolom waktu secara descending
            responsive: true
        });
    });
</script>
@endpush
