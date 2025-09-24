<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\JenisPupuk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PengajuanPupukPetani;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Ambil semua jenis pupuk
        $jenisPupuk = JenisPupuk::all();

        $grafikPengajuan = [];

        foreach ($jenisPupuk as $jenis) {
            // Ambil semua kelompok tani yang ada pengajuan untuk jenis pupuk ini
            $poktans = PengajuanPupukPetani::where('id_jenis_pupuk', $jenis->id)
                ->with(['poktan']) // pastikan relasi poktan sudah didefinisikan di model
                // ->select('id_poktan')
                ->distinct()
                ->get();

            foreach ($poktans as $poktan) {
                // Ambil total jumlah_diterima per bulan untuk setiap poktan dan jenis pupuk
                $pengajuan = PengajuanPupukPetani::select(
                    DB::raw('MONTH(created_at) as bulan'),
                    DB::raw('SUM(jumlah_diterima) as total')
                )
                    ->where('id_jenis_pupuk', $jenis->id)
                    ->where('id_poktan', $poktan->id_poktan)
                    ->groupBy('bulan')
                    ->orderBy('bulan')
                    ->pluck('total', 'bulan')
                    ->toArray();

                // Pastikan semua bulan ada nilainya
                $grafik = array_fill(1, 12, 0);
                foreach ($pengajuan as $bulan => $total) {
                    $grafik[$bulan] = $total;
                }

                // Struktur data: [jenis_pupuk][nama_poktan] = array 12 bulan
                $grafikPengajuan[$jenis->jenis_pupuk][$poktan->poktan->name] = array_values($grafik);
            }
        }

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'users' => User::count(),
            'grafikPengajuan' => $grafikPengajuan,
        ]);
    }
}