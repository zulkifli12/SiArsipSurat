@forelse($notifications as $notif)
    <a href="{{ route('notifications.read', $notif->id) }}" class="dropdown-item {{ is_null($notif->read_at) ? 'unread' : '' }}">
        <div class="item-icon {{ $notif->type }}">
            @if($notif->type === 'surat_masuk')
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 11-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            @elseif($notif->type === 'surat_keluar')
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            @endif
        </div>
        <div class="item-content">
            <div class="item-title">{{ $notif->data['title'] ?? 'Informasi Sistem' }}</div>
            <div class="item-message">{{ $notif->data['message'] ?? '' }}</div>
            <div class="item-time">{{ $notif->created_at->locale('id')->diffForHumans() }}</div>
        </div>
        @if(is_null($notif->read_at))
            <div class="unread-dot"></div>
        @endif
    </a>
@empty
    <div class="empty-notif">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#cbd5e1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        <p>Belum ada notifikasi baru saat ini.</p>
    </div>
@endforelse
