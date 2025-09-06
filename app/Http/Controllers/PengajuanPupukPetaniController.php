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
    public function detail($id)
    {
        $data = PengajuanPupukPetani::with(['poktan', 'anggota', 'jenis_pupuk'])->find($id);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'jumlah_diterima' => 'required',
        ]);

        $customer = PengajuanPupukPetani::find($request->input('id'));

        // Cek apakah data ditemukan
        if (!$customer) {
            return response()->json([
                'message' => 'Data pengajuan tidak ditemukan.'
            ], 404);
        }

        $customerData = [
            'jumlah_diterima' => $request->input('jumlah_diterima'),
            'diterima' => 1,
            'diambil' => 1,
        ];

        // Cek apakah proses update berhasil
        if (!$customer->update($customerData)) {
            return response()->json([
                'message' => 'Gagal memperbarui data pengajuan.'
            ], 500);
        }

        return response()->json([
            'message' => 'Anggota berhasil diperbarui.'
        ]);
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
    public function destroy($id)
    {
        $data = PengajuanPupukPetani::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($data->diterima == 1) {
            return response()->json(['message' => 'Data sudah diterima dan tidak bisa dihapus'], 403);
        }

        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}