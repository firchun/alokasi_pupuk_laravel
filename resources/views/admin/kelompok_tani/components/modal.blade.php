<!-- Modal for Create and Edit -->
<div class="modal fade" id="customersModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Update Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="userForm">
                    <input type="hidden" id="formCustomerId" name="id">
                    <input type="hidden" name="id_poktan" value="{{ $id_poktan }}">
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="Nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Nomor NIK</label>
                        <input type="text" class="form-control" id="NIK" name="nik" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="NoHp" name="no_hp" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="Alamat" name="alamat">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCustomerBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createUserForm">
                    <input type="hidden" name="id_poktan" value="{{ $id_poktan }}">
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="createNama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Nomor NIK</label>
                        <input type="text" class="form-control" id="createNIK" name="nik" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="createNoHp" name="no_hp" value="+62"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="createAlamat" name="alamat" value="-">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createCustomerBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for History -->
<div class="modal fade" id="riwayatModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">Riwayat Pengambilan Pupuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="datatable-pengajuan-petani" class="table table-hover table-bordered display table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Invoice</th>
                                <th>Kelompok</th>
                                <th>Petani</th>
                                <th>Jenis</th>
                                <th>Jumlah Diajukan</th>
                                <th>Jumlah Diterima</th>
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
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@push('css')
    <style>
        .modal-body {
            overflow-x: auto;
            max-width: 100%;
        }
    </style>
@endpush
