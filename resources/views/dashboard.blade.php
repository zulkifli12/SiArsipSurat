@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- WELCOME BANNER -->
<div class="welcome-banner">
    <div class="welcome-text">
        <h1>Selamat Datang di {{ \App\Models\Setting::get('app_name', 'Portal Arsip Surat') }}, {{ explode(' ', Auth::user()->name ?? 'Administrator')[0] }}!</h1>
        <p>{{ \App\Models\Setting::get('app_description', 'Sistem manajemen dokumen digital terintegrasi PTPN Holding. Pantau lalu lintas arsip surat masuk dan surat keluar secara real-time dengan aman, rapi, dan efisien.') }}</p>
    </div>
</div>

<!-- STATS GRID -->
<div class="stats-grid">
    <div class="stat-card" onclick="window.location.href='{{ route('surat-masuk.index') }}'" style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;" title="Klik untuk mengelola Surat Masuk">
        <div class="stat-header">
            <div>
                <div class="stat-title">Surat Masuk</div>
                <div class="stat-value">{{ number_format($totalSuratMasuk) }}</div>
            </div>
            <div class="stat-icon inbox">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 11-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-up">↑ Terbaru:</span>
            <span class="trend-text" style="font-weight: 600; color: var(--text-main);">{{ $suratMasukTerbaru ? $suratMasukTerbaru->no_surat : 'Belum ada surat masuk' }}</span>
        </div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('surat-keluar.index') }}'" style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;" title="Klik untuk mengelola Surat Keluar">
        <div class="stat-header">
            <div>
                <div class="stat-title">Surat Keluar</div>
                <div class="stat-value">{{ number_format($totalSuratKeluar) }}</div>
            </div>
            <div class="stat-icon outbox">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-up">↑ Terbaru:</span>
            <span class="trend-text" style="font-weight: 600; color: var(--text-main);">{{ $suratKeluarTerbaru ? $suratKeluarTerbaru->no_surat : 'Belum ada surat keluar' }}</span>
        </div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('kategori.index') }}'" style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;" title="Klik untuk mengelola kategori">
        <div class="stat-header">
            <div>
                <div class="stat-title">Kategori Klasifikasi</div>
                <div class="stat-value">{{ number_format($totalKategori) }}</div>
            </div>
            <div class="stat-icon category">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-up">↑ Terbaru:</span>
            <span class="trend-text" style="font-weight: 600; color: var(--text-main);">{{ $kategoriTerbaru ? $kategoriTerbaru->nama : 'Belum ada kategori' }}</span>
        </div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('dokumen-arsip.index') }}'" style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;" title="Klik untuk mengelola Dokumen Arsip">
        <div class="stat-header">
            <div>
                <div class="stat-title">Dokumen Arsip</div>
                <div class="stat-value">{{ number_format($totalDokumen) }}</div>
            </div>
            <div class="stat-icon" style="background: #fef3c7; color: var(--warning);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-up" style="color: var(--warning);">↑ Terbaru:</span>
            <span class="trend-text" style="font-weight: 600; color: var(--text-main);">{{ $dokumenTerbaru ? $dokumenTerbaru->no_dokumen : 'Belum ada dokumen' }}</span>
        </div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('arsip.index') }}'" style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;" title="Klik untuk melihat Semua Arsip">
        <div class="stat-header">
            <div>
                <div class="stat-title">Total Arsip Keseluruhan</div>
                <div class="stat-value">{{ number_format($totalArsip) }}</div>
            </div>
            <div class="stat-icon pending" style="background: #eff6ff; color: var(--info);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-up" style="color: var(--info);">↑ Arsip Terakhir:</span>
            <span class="trend-text" style="font-weight: 600; color: var(--text-main);">{{ $arsipTerbaru->first() ? $arsipTerbaru->first()->no_surat : 'Belum ada arsip' }}</span>
        </div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('users.index') }}'" style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;" title="Klik untuk mengelola Pengguna Sistem">
        <div class="stat-header">
            <div>
                <div class="stat-title">Pengguna Sistem</div>
                <div class="stat-value">{{ number_format($totalUsers) }}</div>
            </div>
            <div class="stat-icon" style="background: #f3e8ff; color: #9333ea;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-up" style="color: #9333ea;">↑ Pengguna Terbaru:</span>
            <span class="trend-text" style="font-weight: 600; color: var(--text-main);">{{ $userTerbaru ? $userTerbaru->name : 'Belum ada pengguna' }}</span>
        </div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('notifications.index') }}'" style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;" title="Klik untuk melihat Notifikasi Sistem">
        <div class="stat-header">
            <div>
                <div class="stat-title">Notifikasi Sistem</div>
                <div class="stat-value">{{ number_format($totalNotif) }}</div>
            </div>
            <div class="stat-icon" style="background: #fee2e2; color: #ef4444;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-up" style="color: #ef4444;">↑ Belum Dibaca:</span>
            <span class="trend-text" style="font-weight: 600; color: var(--text-main);">{{ number_format($notifUnread) }} notifikasi</span>
        </div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('logs.index') }}'" style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease;" title="Klik untuk melihat Log Aktivitas">
        <div class="stat-header">
            <div>
                <div class="stat-title">Log Aktivitas Sistem</div>
                <div class="stat-value">{{ number_format($totalLogs) }}</div>
            </div>
            <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-up" style="color: #0284c7;">↑ Aktivitas Terakhir:</span>
            <span class="trend-text" style="font-weight: 600; color: var(--text-main);">{{ $logTerbaru ? ($logTerbaru->user ? $logTerbaru->user->name : 'Sistem') . ': ' . Str::limit($logTerbaru->aktivitas, 18) : 'Belum ada log' }}</span>
        </div>
    </div>
</div>

<!-- GRID LAYOUT (RECENT ACTIVITY & TIMELINE) -->
<div class="grid-layout">
    <!-- RECENT ACTIVITY TABLE -->
    <div class="card-container">
        <div class="card-header">
            <h3>Daftar Arsip Surat Terbaru</h3>
            <a href="{{ route('arsip.index') }}" class="btn-link">
                Lihat Semua Arsip
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="table-responsive">
            <table class="activity-table">
                <thead>
                    <tr>
                        <th>Nomor / Perihal Surat</th>
                        <th>Asal / Tujuan</th>
                        <th>Tanggal Arsip</th>
                        <th>Jenis Arsip</th>
                    </tr>
                <tbody>
                    @forelse($arsipTerbaru as $item)
                        <tr>
                            <td>
                                <div class="letter-meta">
                                    <div class="letter-icon">
                                        @if($item->jenis === 'Surat Masuk')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                        @endif
                                    </div>
                                    <div class="letter-info">
                                        <h4>{{ $item->no_surat }}</h4>
                                        <p>{{ $item->perihal }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->asal_tujuan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl)->locale('id')->isoFormat('D MMM YYYY') }}</td>
                            <td><span class="badge-status {{ $item->badge }}">{{ $item->jenis }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 32px 20px; color: var(--text-muted); font-weight: 500;">Belum ada arsip surat yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SYSTEM LOG TIMELINE -->
    <div class="card-container">
        <div class="card-header">
            <h3>Log Aktivitas Sistem</h3>
            <a href="{{ route('logs.index') }}" class="btn-link">
                Lihat Semua Log
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="timeline-list">
            @forelse($logAktivitas as $log)
                <div class="timeline-item">
                    @php
                        $bg = '#ecfdf5'; $color = 'var(--primary)'; $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                        if ($log->tipe === 'info') { $bg = '#eff6ff'; $color = 'var(--info)'; $icon = 'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12'; }
                        elseif ($log->tipe === 'warning') { $bg = '#fef3c7'; $color = 'var(--warning)'; $icon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'; }
                        elseif ($log->tipe === 'danger') { $bg = '#fee2e2'; $color = 'var(--danger)'; $icon = 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'; }
                    @endphp
                    <div class="timeline-icon" style="background: {{ $bg }}; color: {{ $color }};">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path></svg>
                    </div>
                    <div class="timeline-content">
                        <h5>{{ $log->judul }}</h5>
                        <p>{{ $log->pesan }}</p>
                        <span class="timeline-time">{{ $log->created_at->locale('id')->diffForHumans() }} {{ $log->user ? '• oleh ' . $log->user->name : '' }}</span>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 32px 20px; color: var(--text-muted); font-weight: 500;">Belum ada log aktivitas sistem.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
