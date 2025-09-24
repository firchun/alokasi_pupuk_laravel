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
    public function index(Request $request)
    {
        $selectedPoktan = $request->input('id_poktan'); // ambil dari dropdown

        $jenisPupuk = JenisPupuk::all();

        $grafikPengajuan = [];

        foreach ($jenisPupuk as $jenis) {
            $query = PengajuanPupukPetani::where('id_jenis_pupuk', $jenis->id)
                ->with('poktan');

            if ($selectedPoktan) {
                $query->where('id_poktan', $selectedPoktan);
            }

            $poktans = $query->distinct()->get();

            foreach ($poktans as $poktan) {
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

                $grafik = array_fill(1, 12, 0);
                foreach ($pengajuan as $bulan => $total) {
                    $grafik[$bulan] = $total;
                }

                $grafikPengajuan[$jenis->jenis_pupuk][$poktan->poktan->name] = array_values($grafik);
            }
        }

        // Ambil semua poktan untuk dropdown
        $allPoktan = User::where('role', 'Poktan')->get();

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'users' => User::count(),
            'grafikPengajuan' => $grafikPengajuan,
            'allPoktan' => $allPoktan,
            'selectedPoktan' => $selectedPoktan
        ]);
    }
}