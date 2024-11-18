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
                            <button class="btn btn-secondary refresh btn-default" type="button">
                                <span>
                                    <i class="bx bx-sync me-sm-1"> </i>
                                    <span class="d-none d-sm-inline-block">
                                        @if (Auth::user()->role != 'Distributor')
                                            Refresh Data
                                        @endif
                                    </span>
                                </span>
                            </button>
                            @if (Auth::user()->role == 'Distributor')
                                <button class="btn btn-secondary create-new btn-success" type="button"
                                    data-bs-toggle="modal" data-bs-target="#create">
                                    <span>
                                        <i class="bx bx-plus me-sm-1"> </i>
                                        <span class="d-none d-sm-inline-block">Pengajuan baru</span>
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="datatable-customers" class="table table-hover table-bordered display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                @if (Auth::user()->role != 'Distributor')
                                    <th>Distributor</th>
                                @endif
                                <th>Jenis Pupuk</th>
                                <th>Jumlah Pengajuan</th>
                                <th>Jumlah Disetujui</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                @if (Auth::user()->role != 'Distributor')
                                    <th>Distributor</th>
                                @endif
                                <th>Jenis Pupuk</th>
                                <th>Jumlah Pengajuan</th>
                                <th>Jumlah Disetujui</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.stok.components.modal')
@endsection
@include('admin.stok.script')
