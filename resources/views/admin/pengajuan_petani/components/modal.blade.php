@if (Auth::user()->role == 'Gapoktan')
    <!-- Modal Formulir Pengajuan Pupuk -->
    <div class="modal fade" id="modalAjukanPupuk" tabindex="-1" aria-labelledby="modalAjukanPupukLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success">
                <form action="{{ url('/ajukan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAjukanPupukLabel"><b>Formulir Pengajuan Pupuk</b></h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_poktan">Pilih Kelompok Tani</label>
                            <select name="id_poktan" id="id_poktan" class="form-select">
                                <option value=""> Pilih Kelompok</option>
                                @foreach (App\Models\User::where('role', 'Poktan')->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_anggota">Cari Nama Anda</label>
                            <select name="id_anggota" id="id_anggota" class="form-select">
                                <option value="">Pilih Nama Anggota</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="id_jenis_pupuk">Pilih Jenis Pupuk</label>
                                    <select name="id_jenis_pupuk" class="form-control">
                                        @foreach (App\Models\JenisPupuk::all() as $item)
                                            <option value="{{ $item->id }}">{{ $item->jenis_pupuk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="jumlah_pengajuan">Jumlah Pupuk</label>
                                    <div class="input-group">
                                        <input type="number" name="jumlah_pengajuan" min="1" value="1"
                                            class="form-control">
                                        <span class="input-group-text">Kg</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-success btn-lg" id="ajukanBtn">Ajukan Pupuk</button>
                        <button type="reset" class="btn btn-secondary btn-lg" id="resetBtn">Reset Formulir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Modal for Create and Edit -->
<div class="modal fade" id="customersModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">User Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="userForm">
                    <input type="hidden" id="formCustomerId" name="id">
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="formCustomerName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerPhone" class="form-label">Phone</label>
                        <input type="number" class="form-control" id="formCustomerPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="formCustomerAddress" name="address" required>
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
                <h5 class="modal-title" id="userModalLabel">User Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createUserForm">
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="formCustomerName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerPhone" class="form-label">Phone</label>
                        <input type="number" class="form-control" id="formCustomerPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="formCustomerAddress" name="address" required>
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
<!-- Modal Detail Pengajuan -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Pengajuan Pupuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="result">
                <!-- Detail dari AJAX akan masuk di sini -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
