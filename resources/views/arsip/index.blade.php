@extends('layouts.app')

@section('title', 'Semua Arsip Surat')

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

.badge-status { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800; text-transform: uppercase; display: inline-block; }
.status-success { background: #ecfdf5; color: var(--primary); border: 1px solid #a7f3d0; }
.status-info { background: #eff6ff; color: var(--info); border: 1px solid #bfdbfe; }

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
        <h3>Daftar Seluruh Arsip Surat (Gabungan)</h3>
    </div>

    <div class="table-responsive">
        <table id="arsip-table" class="activity-table display" style="width:100%">
            <thead>
                <tr>
                    <th>Nomor / Perihal Surat</th>
                    <th>Asal / Tujuan</th>
                    <th>Kategori</th>
                    <th style="text-align: center;">Tanggal Surat</th>
                    <th style="text-align: center;">Jenis Arsip</th>
                </tr>
            </thead>
            <tbody>
                @foreach($arsip as $item)
                    <tr>
                        <td>
                            <div class="letter-meta">
                                <div class="letter-icon" style="width: 38px; height: 38px; display:flex; align-items:center; justify-content:center; border-radius:12px; background: {{ $item->jenis === 'Surat Masuk' ? '#ecfdf5' : '#eff6ff' }}; color: {{ $item->jenis === 'Surat Masuk' ? 'var(--primary)' : 'var(--info)' }}; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                    @if($item->jenis === 'Surat Masuk')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    @endif
                                </div>
                                <div class="letter-info">
                                    <h4 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 2px;">{{ $item->no_surat }}</h4>
                                    <p style="font-size: 12px; color: var(--text-muted); font-weight: 600;">{{ $item->perihal }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--text-main); font-size: 14px;">{{ $item->asal_tujuan }}</div>
                        </td>
                        <td>
                            <div style="font-size: 13px; font-weight: 600; color: var(--text-muted);">{{ $item->kategori_nama }}</div>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-size: 13px; font-weight: 600; color: var(--text-muted);">{{ \Carbon\Carbon::parse($item->tgl)->locale('id')->isoFormat('D MMM YYYY') }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-status {{ $item->badge }}">{{ $item->jenis }}</span>
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
        $('#arsip-table').DataTable({
            dom: '<"dt-top-container"lf>rt<"dt-bottom-container"ip>',
            language: {
                search: "Cari Arsip:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ arsip",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 arsip",
                infoFiltered: "(disaring dari _MAX_ total arsip)",
                zeroRecords: "Tidak ada data arsip yang cocok dengan pencarian",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            ordering: true,
            order: [[3, 'desc']], // Urutkan berdasarkan kolom tanggal
            responsive: true,
            columnDefs: [
                { orderable: false, targets: 4 } // Kolom aksi dinonaktifkan
            ]
        });
    });
</script>
@endpush
