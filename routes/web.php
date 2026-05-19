<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\DokumenArsipController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\SuratKeluarController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'demo'])->group(function () {
    Route::get('/dashboard', function () {
        $totalKategori = \App\Models\KategoriSurat::count();
        $totalSuratMasuk = \App\Models\SuratMasuk::count();
        $totalSuratKeluar = \App\Models\SuratKeluar::count();
        $totalDokumen = \App\Models\DokumenArsip::count();
        $totalArsip = $totalSuratMasuk + $totalSuratKeluar + $totalDokumen;
        $kategoriTerbaru = \App\Models\KategoriSurat::latest()->first();
        $suratMasukTerbaru = \App\Models\SuratMasuk::latest()->first();
        $suratKeluarTerbaru = \App\Models\SuratKeluar::latest()->first();
        $dokumenTerbaru = \App\Models\DokumenArsip::latest()->first();

        $suratMasukList = \App\Models\SuratMasuk::with('kategori')->latest('updated_at')->take(10)->get()->map(function ($item) {
            return (object) [
                'no_surat' => $item->no_surat,
                'perihal' => $item->perihal,
                'asal_tujuan' => $item->pengirim,
                'tgl' => $item->tgl_surat,
                'jenis' => 'Surat Masuk',
                'badge' => 'status-success',
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });
        $suratKeluarList = \App\Models\SuratKeluar::with('kategori')->latest('updated_at')->take(10)->get()->map(function ($item) {
            return (object) [
                'no_surat' => $item->no_surat,
                'perihal' => $item->perihal,
                'asal_tujuan' => $item->penerima,
                'tgl' => $item->tgl_surat,
                'jenis' => 'Surat Keluar',
                'badge' => 'status-info',
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });
        $dokumenList = \App\Models\DokumenArsip::with('kategori')->latest('updated_at')->take(10)->get()->map(function ($item) {
            return (object) [
                'no_surat' => $item->no_dokumen,
                'perihal' => $item->nama_dokumen,
                'asal_tujuan' => $item->penerbit ?: 'Internal',
                'tgl' => $item->tgl_dokumen,
                'jenis' => 'Dokumen Arsip',
                'badge' => 'status-warning',
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });
        $arsipTerbaru = $suratMasukList->concat($suratKeluarList)->concat($dokumenList)->sortByDesc('updated_at')->take(10);
        $logAktivitas = \App\Models\LogAktivitas::with('user')->latest()->take(5)->get();

        $totalUsers = \App\Models\User::count();
        $totalNotif = \App\Models\Notification::count();
        $notifUnread = \App\Models\Notification::whereNull('read_at')->count();
        $totalLogs = \App\Models\LogAktivitas::count();
        $userTerbaru = \App\Models\User::latest()->first();
        $logTerbaru = \App\Models\LogAktivitas::with('user')->latest()->first();

        return view('dashboard', compact('totalKategori', 'totalSuratMasuk', 'totalSuratKeluar', 'totalDokumen', 'totalArsip', 'kategoriTerbaru', 'suratMasukTerbaru', 'suratKeluarTerbaru', 'dokumenTerbaru', 'arsipTerbaru', 'logAktivitas', 'totalUsers', 'totalNotif', 'notifUnread', 'totalLogs', 'userTerbaru', 'logTerbaru'));
    })->name('dashboard');

    Route::resource('users', UserController::class)->except(['create', 'edit']);
    Route::resource('kategori', KategoriSuratController::class)->except(['create', 'edit']);
    Route::resource('surat-masuk', SuratMasukController::class)->except(['create', 'edit']);
    Route::get('/surat-masuk/{surat_masuk}/download', [SuratMasukController::class, 'download'])->name('surat-masuk.download');

    Route::resource('surat-keluar', SuratKeluarController::class)->except(['create', 'edit']);
    Route::get('/surat-keluar/{surat_keluar}/download', [SuratKeluarController::class, 'download'])->name('surat-keluar.download');

    Route::resource('dokumen-arsip', DokumenArsipController::class)->except(['create', 'edit']);
    Route::get('/dokumen-arsip/{dokumen_arsip}/download', [DokumenArsipController::class, 'download'])->name('dokumen-arsip.download');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::get('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');

    Route::get('/logs', [LogAktivitasController::class, 'index'])->name('logs.index');
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
});



