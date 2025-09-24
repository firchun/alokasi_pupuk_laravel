@extends('layouts.backend.admin')

@section('content')
    @if (Auth::user()->role == 'Distributor')
        <div class="row">
            @php
                $stokData = [];
                foreach (App\Models\JenisPupuk::all() as $jns) {
                    $stok = App\Models\StokPupuk::where('id_jenis_pupuk', $jns->id)
                        ->where('diterima', 1)
                        ->sum('jumlah_diterima');

                    $pengajuan = App\Models\PengajuanPupukPetani::where('id_jenis_pupuk', $jns->id)
                        ->where('diterima', 1)
                        ->sum('jumlah_diterima');
                    $stok_akhir = $stok - $pengajuan;
                    $stok_akhir = $stok_akhir < 0 ? 0 : $stok_akhir;

                    $stokData[] = [
                        'jenis' => $jns->jenis_pupuk,
                        'stok' => $stok_akhir,
                    ];
                }
            @endphp
            @foreach ($stokData as $data)
                @if ($data['stok'] < 5)
                    <div class="col-12">
                        <div class="alert alert-danger">
                            ⚠️ Stok pupuk <strong>{{ $data['jenis'] }}</strong>
                            <strong>{{ $data['stok'] == 0 ? 'Telah Habis' : 'tersisa ' . $data['stok'] }}</strong>
                            . Segera lakukan pengisian stok!
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach ($stokData as $data)
                @include('admin.dashboard_component.card1', [
                    'count' => $data['stok'],
                    'title' => 'Stok ' . $data['jenis'],
                    'subtitle' => 'Total Stok',
                    'color' => 'primary',
                    'icon' => 'box',
                ])
            @endforeach

            {{-- GRAFIK --}}
            <div class="col-12">
                <h3 class="my-3 text-primary">GRAFIK PENGAJUAN PUPUK</h3>
                <div class="card">
                    <div class="card-body">
                        <canvas id="grafikPengajuan" height="90"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @if (Auth::user()->role == 'PPL')
                @include('admin.dashboard_component.card1', [
                    'count' => $users,
                    'title' => 'Users',
                    'subtitle' => 'Total users',
                    'color' => 'primary',
                    'icon' => 'user',
                ])
            @elseif (Auth::user()->role == 'Gapoktan')
                @php
                    $poktans = App\Models\User::where('role', 'Poktan')->get();
                @endphp

                @foreach ($poktans as $poktan)
                    @php
                        $petaniCount = App\Models\KelompokTani::where('id_poktan', $poktan->id)->count();
                    @endphp
                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="card card-border-shadow-primary h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2 pb-1">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                class="bx bxs-user"></i></span>
                                    </div>
                                    <h4 class="ms-1 mb-0">{{ $petaniCount }} Anggota</h4>
                                </div>
                                <p class="mb-1">Kelompok Tani: {{ $poktan->name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="col-12">
                <h3 class="my-3 text-primary">GRAFIK PENGAJUAN PUPUK</h3>
                <div class="card">
                    <div class="card-body">
                        <canvas id="grafikPengajuan" height="90"></canvas>
                    </div>
                </div>
            </div>

        </div>
    @endif

@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dataGrafik = @json($grafikPengajuan, JSON_NUMERIC_CHECK);
        console.log(dataGrafik);
    </script>
    <script>
        const ctx = document.getElementById('grafikPengajuan').getContext('2d');

        // Ambil data dari controller (struktur: jenis_pupuk -> poktan -> array 12 bulan)
        // const dataGrafik = @json($grafikPengajuan);

        const datasets = [];
        const colors = [
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)'
        ];

        let colorIndex = 0;

        Object.keys(dataGrafik).forEach(jenis => {
            const poktans = dataGrafik[jenis];
            Object.keys(poktans).forEach(poktan => {
                datasets.push({
                    label: `${jenis} - ${poktan}`,
                    data: poktans[poktan],
                    backgroundColor: colors[colorIndex % colors.length],
                    borderColor: colors[colorIndex % colors.length].replace('0.7', '1'),
                    borderWidth: 1,
                    borderRadius: 5
                });
                colorIndex++;
            });
        });

        const grafikPengajuan = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ],
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
