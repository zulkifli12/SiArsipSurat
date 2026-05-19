<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    /**
     * Tampilkan halaman riwayat seluruh log aktivitas sistem.
     */
    public function index()
    {
        $logs = LogAktivitas::with('user')->latest()->get();

        return view('logs.index', compact('logs'));
    }
}
