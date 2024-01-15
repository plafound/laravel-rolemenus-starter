<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pertemuan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $today = Carbon::now();
        // if (auth()->user()->user_type != 'superadmin') {
        //     $pertemuanHariIni = Pertemuan::with('jadwal')->whereDate('tanggal_pertemuan', now()->format('Y-m-d'))->get();

        //     // Fetch Pertemuan records where tanggal_pertemuan is greater than or equal to today
        //     $nextPertemuan = Pertemuan::with('jadwal')->whereDate('tanggal_pertemuan', '>', now()->format('Y-m-d'))->get();
        //     return view('dashboard-mahasiswa', compact('nextPertemuan', 'pertemuanHariIni'));
        // }
        return view('dashboard');
    }
}
