<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PengajuanPupukPetani;

class PageController extends Controller
{
    public function ajukanPupuk(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_poktan' => 'required|exists:users,id',
            'id_anggota' => 'required|exists:kelompok_tani,id',
            'id_jenis_pupuk' => 'required|exists:jenis_pupuk,id',
            'jumlah_pengajuan' => 'required|integer',
        ]);

        // Generate unique invoice
        $invoice = $this->generateInvoice();

        // Menyimpan data pengajuan
        $pengajuan = new PengajuanPupukPetani();
        $pengajuan->id_poktan = $request->id_poktan;
        $pengajuan->id_anggota = $request->id_anggota;
        $pengajuan->id_jenis_pupuk = $request->id_jenis_pupuk;
        $pengajuan->jumlah_pengajuan = $request->jumlah_pengajuan;
        $pengajuan->invoice = $invoice;
        $pengajuan->jumlah_diterima = 0; // Default
        $pengajuan->diterima = 0; // Default
        $pengajuan->diambil = 0; // Default
        $pengajuan->save();

        // Mengarahkan kembali ke halaman dengan pesan sukses
        return redirect('/pengajuan_pupuk')->with('success', 'Pengajuan berhasil dibuat dengan Invoice: ' . $invoice);
    }


    private function generateInvoice()
    {
        $prefix = 'PPK-';
        $date = Carbon::now()->format('Ymd'); // Format tanggal: 20241118
        $time = Carbon::now()->format('His'); // Format waktu: 123456
        $randomId = rand(1000, 9999); // ID acak untuk menghindari duplikasi

        // Format invoice: INV-YYYYMMDD-HHMMSS-ID
        return $prefix . $date . '-' . $time . '-' . $randomId;
    }
}
