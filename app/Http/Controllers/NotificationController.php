<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Tampilkan halaman daftar seluruh notifikasi.
     */
    public function index()
    {
        $notifications = Notification::latest()->get();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Ambil data notifikasi terbaru untuk polling AJAX (maksimal 5).
     */
    public function fetch()
    {
        $unreadCount = Notification::unread()->count();
        $notifications = Notification::latest()->take(5)->get();
        $latestUnread = Notification::unread()->latest()->first();

        $html = view('notifications.dropdown_list', compact('notifications'))->render();

        return response()->json([
            'unread_count' => $unreadCount,
            'html' => $html,
            'latest_unread' => $latestUnread ? [
                'id' => $latestUnread->id,
                'title' => $latestUnread->data['title'] ?? 'Informasi Sistem',
                'message' => $latestUnread->data['message'] ?? '',
                'url' => route('notifications.read', $latestUnread->id),
            ] : null,
        ]);
    }

    /**
     * Tandai satu notifikasi sebagai dibaca dan arahkan ke URL terkait.
     */
    public function read(Notification $notification)
    {
        $notification->markAsRead();

        $url = $notification->data['url'] ?? '#';

        if ($url !== '#' && filter_var($url, FILTER_VALIDATE_URL)) {
            return redirect($url);
        }

        return redirect()->back()->with('success', 'Notifikasi telah ditandai dibaca.');
    }

    /**
     * Tandai seluruh notifikasi sebagai dibaca (via AJAX).
     */
    public function readAll()
    {
        Notification::unread()->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
