@extends('layouts.frontend.app')
@section('main')
    <section class="section">
        <div class="container">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @elseif (Session::has('danger'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ Session::get('danger') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    @foreach ($errors->all() as $item)
                        <ul>
                            <li>{{ $item }}</li>
                        </ul>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-lg-6 col-8">
                    <form action="{{ url('/ajukan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <b>Formulir Pengajuan Pupuk</b>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="">Pilih Kelompok Tani</label>
                                    <select name="id_poktan" id="id_poktan" class="form-control">
                                        <option value=""> Pilih Kelompok</option>
                                        @foreach (App\Models\User::where('role', 'Poktan')->get() as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="">Cari Nama Anda</label>
                                    <select name="id_anggota" id="id_anggota" class="form-control">
                                        <option value="">Pilih Nama Anggota</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col">

                                        <div class="mb-3">
                                            <label for="">Pilih Jenis Pupuk</label>
                                            <select name="id_jenis_pupuk" class="form-control">
                                                @foreach (App\Models\JenisPupuk::all() as $item)
                                                    <option value="{{ $item->id }}">{{ $item->jenis_pupuk }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="">Jumlah Pupuk</label>
                                            <div class="input-group">
                                                <input type="number" name="jumlah_pengajuan" min="1" value="1"
                                                    class="form-control">
                                                <span class="input-group-text">Kg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-success btn-lg" id="ajukanBtn">
                                    Ajukan Pupuk
                                </button>
                                <button type="reset" class="btn btn-secondary btn-lg" id="resetBtn">
                                    Reset Formulir
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection
@push('js')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{ asset('backend_theme/') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script>
        $(document).ready(function() {
            $('#ajukanBtn').prop('disabled', true);
            $('#id_anggota').prop('disabled', true);
            $('#id_poktan').on('change', function() {
                var poktanId = $(this).val();
                if (poktanId) {
                    $.ajax({
                        url: '/get-kelompok/' + poktanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#id_anggota').prop('disabled', false);
                            $('#ajukanBtn').prop('disabled', false);
                            $('#id_anggota').empty();
                            $('#id_anggota').append(
                                '<option value="">Pilih Nama Anggota</option>');
                            $.each(data, function(key, value) {
                                $('#id_anggota').append('<option value="' + value.id +
                                    '">' + value.nama + ' - ' + value.nik +
                                    '</option>');
                            });
                        },
                        error: function() {
                            $('#id_anggota').prop('disabled', false);
                            $('#id_anggota').empty();
                            $('#id_anggota').append(
                                '<option value="">Data tidak ditemukan</option>');
                        }
                    });
                } else {
                    $('#ajukanBtn').prop('disabled', true);
                    $('#id_anggota').prop('disabled', true);
                    $('#id_anggota').empty();
                    $('#id_anggota').append(
                        '<option value="">Pilih Nama Anggota</option>');
                }
            });
            $('#resetBtn').click(function() {
                $('#ajukanBtn').prop('disabled', true);
                $('#id_anggota').prop('disabled', true);
                $('#id_anggota').empty();
                $('#id_anggota').append(
                    '<option value="">Pilih Nama Anggota</option>');
            });
        });
    </script>
@endpush
