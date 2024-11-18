<!-- Modal for Create and Edit -->
<div class="modal fade" id="terima" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Update Penerimaan Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="terimaForm">
                    <input type="hidden" id="terimaId" name="id">
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Jumlah diterima</label>
                        <input type="text" class="form-control" id="jumlahDiterima" name="jumlah_diterima" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="terimaBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Buat Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createUserForm">
                    <input type="hidden" name="id_distributor" value="{{ Auth::id() }}">
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Jenis Pupuk</label>
                        <select class="form-control" name="id_jenis_pupuk" id="id_jenis_pupuk">
                            @foreach (App\Models\JenisPupuk::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->jenis_pupuk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Stok yang diajukan</label>
                        <input type="number" class="form-control" name="jumlah_pengajuan" id="jumlah_pengajuan"
                            required min="1">
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
