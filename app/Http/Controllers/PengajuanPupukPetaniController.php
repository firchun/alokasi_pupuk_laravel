<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPupukPetani;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PengajuanPupukPetaniController extends Controller
{
    public function pengambilan()
    {
        $data = [
            'title' => 'Update Pengambilan Pupuk'
        ];
        return view('admin.pengambilan.index', $data);
    }
    public function index()
    {
        $data = [
            'title' => 'Data Pengajuan Pupuk',
        ];
        return view('admin.pengajuan_petani.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'jumlah_diterima' => 'required',
        ]);

        $customer = PengajuanPupukPetani::find($request->input('id'));
        $customerData = [
            'jumlah_diterima' => $request->input('jumlah_diterima'),
            'diterima' => 1,

        ];
        $customer->update($customerData);
        $message = 'anggota updated successfully';

        return response()->json(['message' => $message]);
    }
    public function getPengajunPupukDataTable()
    {
        $customers = PengajuanPupukPetani::with(['poktan', 'anggota', 'jenis_pupuk'])->orderByDesc('id');

        return DataTables::of($customers)

            ->make(true);
    }
    public function getPengajunPupukPetaniDataTable($id_anggota)
    {
        $customers = PengajuanPupukPetani::with(['poktan', 'anggota', 'jenis_pupuk'])->where('id_anggota', $id_anggota)->orderByDesc('id');

        return DataTables::of($customers)

            ->make(true);
    }
}
