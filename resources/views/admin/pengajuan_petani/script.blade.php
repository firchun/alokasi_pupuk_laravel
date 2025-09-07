@push('js')
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
    <script>
        window.userRole = "{{ Auth::user()->role }}";
        $(function() {
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: '{{ url('pengajuan-pupuk-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'invoice',
                        name: 'invoice'
                    },
                    {
                        data: 'poktan.name',
                        name: 'poktan.name'
                    },
                    {
                        data: 'anggota.nama',
                        name: 'anggota.nama',
                        render: function(data, type, row, meta) {
                            return `${data}<br><small class="badge bg-label-primary">NIK: ${row.anggota.nik}</small>`;
                        }
                    },
                    {
                        data: 'jenis_pupuk.jenis_pupuk',
                        name: 'jenis_pupuk.jenis_pupuk'
                    },

                    {
                        data: 'jumlah_pengajuan',
                        name: 'jumlah_pengajuan',
                        render: function(data, type, row, meta) {
                            return data + ' Kg';
                        }
                    },
                    {
                        data: 'jumlah_diterima',
                        name: 'jumlah_diterima',
                        render: function(data, type, row, meta) {
                            return data + ' Kg';
                        }
                    },
                    {
                        data: 'diterima',
                        name: 'diterima',
                        render: function(data, type, row) {
                            const date = new Date(row.updated_at);
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2,
                                '0');
                            const year = date.getFullYear();
                            return data == 1 ?
                                `<span class="badge bg-label-primary">Sudah Diterima</span><br><small>${day}/${month}/${year}</small>` :
                                '<span class="badge bg-label-warning">Belum Diterima</span>';
                        }
                    },
                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            if (window.userRole === 'Distributor') {
                                if (row.diterima == 0) {
                                    return `
                                            <button class="btn btn-success btn-sm m-1 btn-terima" data-id="${row.id}">
                                                Terima
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-btn m-1" data-id="${row.id}">
                                                Batalkan
                                            </button>
                                        `;
                                } else {
                                    return '<span class="badge bg-label-primary">Diterima</span>';
                                }
                            }

                            if (window.userRole === 'Gapoktan') {
                                if (row.diterima == 0) {
                                    return `
                                            <button class="btn btn-danger btn-sm delete-btn m-1" data-id="${row.id}">
                                                Batalkan
                                            </button>
                                        `;
                                } else {
                                    return '<span class="badge bg-label-primary">Diterima</span>';
                                }
                            }

                            return '-'; // default kalau bukan Distributor/Gapoktan
                        }
                    }

                ]
            });

            $('.refresh').click(function() {
                $('#datatable-customers').DataTable().ajax.reload();
            });
        });
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');

            if (confirm('Yakin ingin menghapus pengajuan ini?')) {
                $.ajax({
                    url: `/pengajuan/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message); // bisa ganti dengan SweetAlert
                        $('#datatable-customers').DataTable().ajax.reload(); // reload table
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat menghapus.');
                    }
                });
            }
        });
        // Event delegation untuk tombol Terima di tabel
        $(document).on('click', '.btn-terima', function() {
            const id = $(this).data('id');

            // Ambil data detail dari server (misal route /stok/detail/{id})
            $.ajax({
                url: '/pengajuan-pupuk/detail/' + id,
                type: 'GET',
                success: function(data) {
                    if (data.status === 'success') {
                        const resultDiv = $('#result');
                        resultDiv.html('');

                        const diterimaStatus = data.data.diterima == 1 ?
                            '<span class="text-success">Diterima</span>' :
                            '<span class="text-danger">Belum Diterima</span>';

                        const formUpdate = data.data.diterima == 1 ?
                            `<p><strong>Total diterima :</strong> ${data.data.jumlah_diterima} Kg</p>` :
                            `<hr>
                    <form id="updateForm">
                        <input type="hidden" name="id" value="${data.data.id}">
                        <div class="form-group">
                            <label>Jumlah Diterima</label>
                            <input type="number" id="jumlah_diterima" name="jumlah_diterima" 
                                class="form-control" 
                                placeholder="Masukkan jumlah diterima"
                                required>
                        </div>
                        <button type="button" class="btn btn-success mt-2" 
                            id="updateBtn" 
                            data-max="${data.data.jumlah_pengajuan}">
                            Update Pengambilan
                        </button>
                    </form>`;

                        resultDiv.html(`
                
                        <h5 class="text-success">Detail Pengajuan</h5><hr>
                        <p><strong>Invoice:</strong> ${data.data.invoice}</p>
                        <p><strong>Poktan:</strong> ${data.data.poktan.name}</p>
                        <p><strong>Nama Petani:</strong> ${data.data.anggota.nama}</p>
                        <p><strong>Jenis Pupuk:</strong> ${data.data.jenis_pupuk.jenis_pupuk}</p>
                        <p><strong>Total diajukan:</strong> ${data.data.jumlah_pengajuan} Kg</p>
                        <p><strong>Tanggal Pengajuan:</strong> ${new Date(data.data.created_at).toLocaleDateString('id-ID')}</p>
                        <p><strong>Status:</strong> ${diterimaStatus}</p>
                        ${formUpdate}
                   
            `);

                        // Munculkan modal detail
                        $('#detailModal').modal('show');
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr) {
                    alert('Gagal ambil data detail: ' + xhr.responseText);
                }
            });
        });

        // Event delegation untuk updateBtn
        $(document).on('click', '#updateBtn', function() {
            const jumlahDiterima = parseInt($('#jumlah_diterima').val(), 10);
            const maxJumlah = parseInt($(this).data('max'), 10);

            if (isNaN(jumlahDiterima) || jumlahDiterima < 0 || jumlahDiterima > maxJumlah) {
                alert(`Jumlah diterima harus antara 0 dan ${maxJumlah}.`);
                return;
            }

            const formData = $('#updateForm').serialize();

            $.ajax({
                type: 'POST',
                url: '/pengajuan-pupuk/store',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#result').html(
                        '<div class="alert alert-success">Update berhasil dilakukan.</div>');
                    $('#datatable-customers').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });
    </script>
@endpush
