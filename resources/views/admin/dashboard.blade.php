@extends('layouts.backend.admin')

@section('content')
    @if (Auth::user()->role == 'Distributor')
        <div class="row">
            @foreach (App\Models\JenisPupuk::all() as $jns)
                @php
                    $stok = App\Models\StokPupuk::where('id_jenis_pupuk', $jns->id)
                        ->where('diterima', 1)
                        ->sum('jumlah_diterima');
                @endphp
                {{-- Alert jika stok di bawah 5 --}}
                @if ($stok < 5)
                    <div class="col-12">
                        <div class="alert alert-danger">
                            ⚠️ Stok pupuk <strong>{{ $jns->jenis_pupuk }}</strong> tersisa
                            <strong>{{ $stok }}</strong>
                            (di
                            bawah batas minimum)
                            .
                        </div>
                    </div>
                @endif
            @endforeach
            @foreach (App\Models\JenisPupuk::all() as $jenis)
                @include('admin.dashboard_component.card1', [
                    'count' => App\Models\StokPupuk::where('id_jenis_pupuk', $jenis->id)->where('diterima', 1)->sum('jumlah_diterima'),
                    'title' => 'Stok ' . $jenis->jenis_pupuk,
                    'subtitle' => 'Total Stok',
                    'color' => 'primary',
                    'icon' => 'box',
                ])
            @endforeach
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
        const ctx = document.getElementById('grafikPengajuan').getContext('2d');
        const grafikPengajuan = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ],
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: @json(array_values($grafikPengajuan)),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
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
