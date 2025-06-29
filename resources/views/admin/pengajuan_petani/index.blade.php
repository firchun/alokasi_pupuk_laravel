@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label ">
                        <h5 class="card-title mb-0">{{ $title ?? 'Title' }}</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class=" btn-group " role="group">
                            @if (Auth::user()->role == 'Gapoktan')
                                <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                    data-bs-target="#modalAjukanPupuk">
                                    <span>
                                        <i class="bx bx-plus me-sm-1"></i>
                                        <span class="d-none d-sm-inline-block">Ajukan Pupuk</span>
                                    </span>
                                </button>
                            @endif
                            <button class="btn btn-secondary refresh btn-default" type="button">
                                <span>
                                    <i class="bx bx-sync me-sm-1"> </i>
                                    <span class="d-none d-sm-inline-block"> Refresh Data</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="datatable-customers" class="table table-hover table-bordered display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Invoice</th>
                                <th>Kelompok</th>
                                <th>Petani</th>
                                <th>Jenis</th>
                                <th>Jumlah Diajukan</th>
                                <th>Jumlah Diterima</th>
                                <th>Status</th>
                                @if (Auth::user()->role == 'Gapoktan')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Invoice</th>
                                <th>Kelompok</th>
                                <th>Petani</th>
                                <th>Jenis</th>
                                <th>Jumlah Diajukan</th>
                                <th>Jumlah Diterima</th>
                                <th>Status</th>
                                @if (Auth::user()->role == 'Gapoktan')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.pengajuan_petani.components.modal')
@endsection
@include('admin.pengajuan_petani.script')
