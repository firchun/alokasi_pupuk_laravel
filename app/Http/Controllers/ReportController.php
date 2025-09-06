<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Laporan Pengajuan Pupuk',
        ];
        return view('admin.laporan.pengajuan', $data);
    }
}