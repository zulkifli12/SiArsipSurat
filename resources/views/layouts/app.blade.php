<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Eksekutif') | {{ \App\Models\Setting::get('app_name', 'Arsip Surat PTPN IV') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logos/ptpn_holding.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('asset/dashboard.css') }}">
    @stack('styles')
</head>
<body>
    <!-- SIDEBAR OVERLAY (UNTUK MOBILE) -->
    <div id="sidebar-overlay" class="sidebar-overlay"></div>

    <!-- SIDEBAR -->
    <aside id="main-sidebar">
        <script>
            if (window.innerWidth > 1024 && localStorage.getItem('sidebar_collapsed') === 'true') {
                document.getElementById('main-sidebar').classList.add('collapsed');
            }
        </script>
        <div class="sidebar-brand">
            <div class="logo-lockup-badge" title="{{ \App\Models\Setting::get('app_name', 'Portal Arsip Surat') }}">
                <div class="logo-item logo-danantara">
                    <img src="{{ asset('images/logos/danantara.png') }}" alt="Danantara" class="logo-img" title="Danantara">
                </div>
                <div class="logo-separator"></div>
                <div class="logo-item logo-ptpn">
                    <img src="{{ asset('images/logos/ptpn_holding.png') }}" alt="PTPN Nusantara" class="logo-img" title="PTPN Nusantara">
                </div>
                <div class="logo-separator"></div>
                <div class="logo-item logo-ptpn4">
                    <img src="{{ asset('images/logos/ptpn4.png') }}" alt="PTPN IV" class="logo-img" title="PTPN IV">
                </div>
            </div>
            <div class="brand-title">{{ \App\Models\Setting::get('app_name', 'Portal Arsip Surat') }}</div>
        </div>

        <!-- SIDEBAR SCROLLABLE AREA -->
        <div class="sidebar-scrollable">
            <div class="nav-group">
                <div class="nav-label">Menu Navigasi</div>
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('surat-masuk.index') }}" class="nav-item {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}" title="Surat Masuk">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <span>Surat Masuk</span>
                    <span class="badge-count">{{ \App\Models\SuratMasuk::count() }}</span>
                </a>
                <a href="{{ route('surat-keluar.index') }}" class="nav-item {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}" title="Surat Keluar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    <span>Surat Keluar</span>
                    <span class="badge-count" style="background: #eff6ff; color: var(--info);">{{ \App\Models\SuratKeluar::count() }}</span>
                </a>
                <a href="{{ route('dokumen-arsip.index') }}" class="nav-item {{ request()->routeIs('dokumen-arsip.*') ? 'active' : '' }}" title="Dokumen Arsip">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Dokumen Arsip</span>
                    <span class="badge-count" style="background: #fef3c7; color: var(--warning);">{{ \App\Models\DokumenArsip::count() }}</span>
                </a>
                <a href="{{ route('arsip.index') }}" class="nav-item {{ request()->routeIs('arsip.*') ? 'active' : '' }}" title="Semua Arsip Gabungan">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Semua Arsip</span>
                    <span class="badge-count" style="background: #eff6ff; color: var(--info);">{{ \App\Models\SuratMasuk::count() + \App\Models\SuratKeluar::count() + \App\Models\DokumenArsip::count() }}</span>
                </a>
                <a href="{{ route('kategori.index') }}" class="nav-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}" title="Kategori Surat">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    <span>Kategori Surat</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">Manajemen Sistem</div>
                <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}" title="Manajemen Pengguna">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Manajemen Pengguna</span>
                    @if(config('app.demo_mode', true))
                        <span style="margin-left: auto; color: #e11d48; font-size: 14px;" title="Fitur Terkunci (Edisi GitHub)">🔒</span>
                    @endif
                </a>
                <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}" title="Pengaturan Sistem">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    <span>Pengaturan Sistem</span>
                    @if(config('app.demo_mode', true))
                        <span style="margin-left: auto; color: #e11d48; font-size: 14px;" title="Fitur Terkunci (Edisi GitHub)">🔒</span>
                    @endif
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">Sistem & Riwayat</div>
                <a href="{{ route('notifications.index') }}" class="nav-item {{ request()->routeIs('notifications.index') ? 'active' : '' }}" title="Riwayat Notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span>Riwayat Notifikasi</span>
                </a>
                <a href="{{ route('logs.index') }}" class="nav-item {{ request()->routeIs('logs.index') ? 'active' : '' }}" title="Log Aktivitas Sistem">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Log Aktivitas Sistem</span>
                </a>
            </div>
        </div>

        <!-- SIDEBAR FOOTER (USER & LOGOUT) -->
        <div class="sidebar-footer">
            <div class="user-profile-card" onclick="openMyProfileModal()" title="Klik untuk mengedit profil Anda: {{ Auth::user()->name ?? 'Administrator Utama' }} ({{ Auth::user()->email ?? 'admin@ptpn.co.id' }})">
                <div class="avatar">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? 'Administrator Utama' }}</div>
                    <div class="user-role">{{ Auth::user()->email ?? 'admin@ptpn.co.id' }}</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" title="Keluar dari Aplikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar Aplikasi</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main>
        @if(config('app.demo_mode', true))
        <div class="demo-premium-banner" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #f8fafc; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; border-bottom: 1px solid #334155; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; z-index: 1000; position: relative;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="background: #e11d48; color: white; padding: 4px 10px; border-radius: 8px; font-weight: 800; font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase; box-shadow: 0 2px 4px rgba(225,29,72,0.3);">Edisi Portofolio / GitHub</span>
                <span style="font-weight: 500; color: #cbd5e1;">Beberapa fitur krusial (Unduh Lampiran, Manajemen Pengguna, Pengaturan, dll.) dikunci untuk melindungi hak cipta.</span>
            </div>
            <button type="button" onclick="showPremiumContactPopup()" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; border: none; padding: 6px 16px; border-radius: 10px; font-weight: 700; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 10px rgba(5,150,105,0.3); transition: all 0.2s ease;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span>Buka Akses Penuh / Hubungi Pengembang</span>
            </button>
        </div>
        @endif
        <!-- TOPBAR HEADER -->
        <header>
            <div class="header-left">
                <!-- HAMBURGER MENU ICON -->
                <button id="menu-toggle" class="btn-icon" title="Buka/Tutup Menu Navigasi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>

            <div class="header-actions">
                <div class="date-display">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>

                <div class="notification-wrapper" style="position: relative;">
                    <button id="notification-bell" class="btn-icon" title="Notifikasi Sistem" style="border: none; background: #f8fafc; cursor: pointer;">
                        <span class="indicator-pulse" id="notification-pulse" style="display: none;"></span>
                        <span class="badge-count" id="notification-badge" style="position: absolute; top: -4px; right: -4px; background: #e11d48; color: white; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 10px; display: none;">0</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>

                    <!-- NOTIFICATION DROPDOWN -->
                    <div id="notification-dropdown" class="notification-dropdown">
                        <div class="dropdown-header">
                            <h4>Notifikasi Sistem</h4>
                            <button type="button" onclick="markAllNotificationsAsRead()" class="btn-mark-all">Tandai semua dibaca</button>
                        </div>
                        <div class="dropdown-body" id="notification-list">
                            <div class="empty-notif">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#cbd5e1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                <p>Memuat notifikasi...</p>
                            </div>
                        </div>
                        <div class="dropdown-footer">
                            <a href="{{ route('notifications.index') }}">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- DYNAMIC CONTENT -->
        <div class="content">
            @yield('content')
        </div>
    </main>

    <!-- JAVASCRIPT UNTUK INTERAKSI MENU HAMBURGER & NOTIFIKASI REAL-TIME -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('main-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function handleMenuClick() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.toggle('collapsed');
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebar_collapsed', isCollapsed ? 'true' : 'false');
                } else {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                }
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', handleMenuClick);
            }

            if (overlay) {
                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }

            // --- LOGIKA MEMPERTAHANKAN POSISI SCROLL SIDEBAR ---
            const sidebarScrollable = document.querySelector('.sidebar-scrollable');
            if (sidebarScrollable) {
                const savedScrollPos = sessionStorage.getItem('sidebar_scroll_pos');
                if (savedScrollPos !== null) {
                    sidebarScrollable.scrollTop = parseInt(savedScrollPos, 10);
                } else {
                    const activeItem = sidebarScrollable.querySelector('.nav-item.active');
                    if (activeItem) {
                        activeItem.scrollIntoView({ block: 'center' });
                    }
                }
                sidebarScrollable.addEventListener('scroll', function() {
                    sessionStorage.setItem('sidebar_scroll_pos', sidebarScrollable.scrollTop);
                });
            }

            // --- LOGIKA POLLING NOTIFIKASI REAL-TIME ---
            let lastUnreadId = null;

            function fetchNotifications() {
                fetch('{{ route('notifications.fetch') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    const countBadge = document.getElementById('notification-badge');
                    const pulse = document.getElementById('notification-pulse');
                    const list = document.getElementById('notification-list');

                    if (data.unread_count > 0) {
                        countBadge.style.display = 'inline-block';
                        countBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                        pulse.style.display = 'inline-block';
                    } else {
                        countBadge.style.display = 'none';
                        pulse.style.display = 'none';
                    }

                    if (data.html) {
                        list.innerHTML = data.html;
                    }

                    // Memunculkan Toast SweetAlert2 jika ada notifikasi baru masuk
                    if (data.latest_unread && lastUnreadId !== null && data.latest_unread.id !== lastUnreadId) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: data.latest_unread.title,
                            text: data.latest_unread.message,
                            showConfirmButton: false,
                            timer: 4000,
                            customClass: { popup: 'swal-premium-popup' }
                        });
                    }

                    if (data.latest_unread) {
                        lastUnreadId = data.latest_unread.id;
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
            }

            // Toggle dropdown notifikasi
            const notifBell = document.getElementById('notification-bell');
            const notifDropdown = document.getElementById('notification-dropdown');

            if (notifBell && notifDropdown) {
                notifBell.addEventListener('click', function(event) {
                    event.stopPropagation();
                    notifDropdown.classList.toggle('active');
                });

                window.addEventListener('click', function(event) {
                    if (!notifDropdown.contains(event.target)) {
                        notifDropdown.classList.remove('active');
                    }
                });
            }

            // Polling pertama dan berkala setiap 15 detik
            fetchNotifications();
            setInterval(fetchNotifications, 15000);
        });

        // Tandai semua notifikasi dibaca via AJAX
        function markAllNotificationsAsRead() {
            fetch('{{ route('notifications.readAll') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const countBadge = document.getElementById('notification-badge');
                    const pulse = document.getElementById('notification-pulse');
                    const notifDropdown = document.getElementById('notification-dropdown');
                    
                    if (countBadge) countBadge.style.display = 'none';
                    if (pulse) pulse.style.display = 'none';
                    if (notifDropdown) notifDropdown.classList.remove('active');

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Seluruh notifikasi telah ditandai dibaca.',
                        showConfirmButton: false,
                        timer: 2500
                    });

                    // Muat ulang daftar notifikasi
                    setTimeout(() => {
                        window.dispatchEvent(new Event('DOMContentLoaded'));
                    }, 500);
                }
            });
        }

        // --- FUNGSI MODAL EDIT PROFIL SAYA (GLOBAL) ---
        function openMyProfileModal() {
            const modal = document.getElementById('my-profile-modal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
                setTimeout(() => document.getElementById('my-profile-name').focus(), 100);
            }
        }

        function closeMyProfileModal() {
            const modal = document.getElementById('my-profile-modal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        function toggleMyProfilePassword(button) {
            const wrapper = button.closest('.password-wrapper');
            const input = wrapper.querySelector('input');
            const isPassword = input.type === 'password';
            
            input.type = isPassword ? 'text' : 'password';
            button.title = isPassword ? 'Sembunyikan sandi' : 'Tampilkan sandi';
            
            button.innerHTML = isPassword 
                ? '<svg class="eye-on" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>'
                : '<svg class="eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
        }

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('my-profile-modal');
            if (event.target === modal) closeMyProfileModal();
        });

        document.addEventListener('keydown', function(event) {
            const modal = document.getElementById('my-profile-modal');
            if (event.key === 'Escape' && modal && modal.classList.contains('active')) {
                closeMyProfileModal();
            }
        });

        // SweetAlert2 Notifikasi Sukses & Error Global (Tanpa Progress Bar)
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    customClass: { popup: 'swal-premium-popup' }
                });
            });
        @endif

        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function() {
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

        // --- FUNGSI POPUP PREMIUM / DEMO MODE ---
        function showPremiumContactPopup(featureName = null) {
            let featureText = featureName ? `<p style="color: #e11d48; font-weight: 800; margin-bottom: 16px; font-size: 18px; display: flex; align-items: center; gap: 8px;"><span style="font-size: 22px;">🔒</span> Akses Ditolak: Fitur ${featureName} Dikunci</p>` : '';
            Swal.fire({
                title: '<span style="font-weight: 800; color: #0f172a; font-size: 24px;">Dapatkan Versi Penuh (Pro License)</span>',
                html: `
                    <div style="font-family: 'Plus Jakarta Sans', sans-serif; color: #475569; font-size: 15px; line-height: 1.6; text-align: left;">
                        ${featureText}
                        <p style="margin-bottom: 16px;">Aplikasi <b>Arsip Surat PTPN IV (Eksekutif Dashboard)</b> yang Anda unduh dari GitHub ini merupakan <b>Edisi Lite / Portofolio</b>. Untuk mencegah penyalahgunaan dan menjaga lisensi eksklusif, beberapa fitur krusial telah disembunyikan/dikunci, antara lain:</p>
                        <ul style="background: #f8fafc; padding: 16px 24px; border-radius: 16px; border: 1px solid #e2e8f0; margin-bottom: 20px; list-style-type: none; gap: 10px; display: flex; flex-direction: column;">
                            <li style="display: flex; align-items: center; gap: 12px;"><span style="color: #059669; font-size: 18px;">✔</span> <b>Unduh Dokumen Lampiran Asli</b> (PDF/Word/Excel/Gambar)</li>
                            <li style="display: flex; align-items: center; gap: 12px;"><span style="color: #059669; font-size: 18px;">✔</span> <b>Manajemen Pengguna & Hak Akses</b> (Tambah/Edit/Hapus Akun)</li>
                            <li style="display: flex; align-items: center; gap: 12px;"><span style="color: #059669; font-size: 18px;">✔</span> <b>Pengaturan Sistem & Parameter Aplikasi</b></li>
                            <li style="display: flex; align-items: center; gap: 12px;"><span style="color: #059669; font-size: 18px;">✔</span> <b>Penambahan, Pembaruan & Penghapusan Arsip</b></li>
                        </ul>
                        <p style="margin-bottom: 20px;">Untuk mendapatkan <b>Full Source Code (100% Terbuka, Fitur Lengkap, Tanpa Enkripsi)</b> serta dukungan teknis dan panduan instalasi dari pihak pengembang, silakan hubungi kami melalui kontak resmi berikut:</p>
                        <div style="display: flex; flex-direction: column; gap: 12px; background: #eff6ff; padding: 18px 24px; border-radius: 16px; border: 1px solid #bfdbfe;">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <span style="font-size: 26px;">📞</span>
                                <div>
                                    <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">WhatsApp / Telepon Resmi</div>
                                    <div style="font-size: 18px; font-weight: 800; color: #1e3a8a;">${'{{ config('app.dev_whatsapp', '+6282388702178') }}'}</div>
                                </div>
                            </div>
                            <div style="height: 1px; background: #dbeafe;"></div>
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <span style="font-size: 26px;">✉️</span>
                                <div>
                                    <div style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Email Pengembang</div>
                                    <div style="font-size: 18px; font-weight: 800; color: #1e3a8a;">${'{{ config('app.dev_email', 'zulkiflioccez@gmail.com') }}'}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Tutup Penjelasan',
                confirmButtonColor: '#0f172a',
                customClass: { popup: 'swal-premium-popup' }
            });
        }

        @if(session('demo_restricted'))
            document.addEventListener('DOMContentLoaded', function() {
                showPremiumContactPopup('{{ session('demo_restricted') }}');
            });
        @endif
    </script>

    <!-- MODAL EDIT PROFIL SAYA (GLOBAL) -->
    <div id="my-profile-modal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Edit Profil Saya</h3>
                <button type="button" class="btn-close" onclick="closeMyProfileModal()" title="Tutup Modal">×</button>
            </div>

            <form action="{{ route('users.update', Auth::id() ?? 0) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ Auth::id() ?? 0 }}">
                <input type="hidden" name="is_profile" value="1">
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="my-profile-name" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Nama Lengkap</label>
                    <input type="text" id="my-profile-name" name="name" class="form-control" value="{{ Auth::user()->name ?? '' }}" placeholder="Masukkan nama lengkap..." required autofocus style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="my-profile-email" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Alamat Email</label>
                    <input type="email" id="my-profile-email" name="email" class="form-control" value="{{ Auth::user()->email ?? '' }}" placeholder="email@ptpn.co.id" required style="width:100%; padding:12px 16px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                </div>

                <div class="form-group" style="margin-bottom: 36px;">
                    <label for="my-profile-password" class="form-label" style="display:block; font-size:12px; font-weight:700; margin-bottom:8px; text-transform:uppercase;">Kata Sandi Baru (Opsional)</label>
                    <div class="password-wrapper" style="position: relative; display: flex; align-items: center;">
                        <input type="password" id="my-profile-password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah sandi..." style="width:100%; padding:12px 16px 12px 16px; padding-right: 42px; background:#f8fafc; border:2px solid #e2e8f0; border-radius:14px; font-size:14px; font-weight:600;">
                        <button type="button" class="password-toggle" onclick="toggleMyProfilePassword(this)" title="Tampilkan sandi" style="position: absolute; right: 12px; background: none; border: none; color: #64748b; cursor: pointer; padding: 4px; display: flex; align-items: center; justify-content: center;">
                            <svg class="eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                    <span style="font-size: 12px; color: var(--text-muted); margin-top: 6px; display: block;">* Isi hanya jika Anda ingin mengganti kata sandi login Anda.</span>
                </div>

                <div style="display: flex; gap: 16px; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary" onclick="closeMyProfileModal()" style="padding:12px 24px; border-radius:12px; font-weight:700; background:#f1f5f9; border:1px solid #cbd5e1; color:#64748b; cursor:pointer;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="padding:12px 24px; border-radius:12px; font-weight:700; background:linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border:none; color:white; cursor:pointer; display:flex; align-items:center; gap:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
