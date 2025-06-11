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
                            return data === 1 ?
                                `<span class="badge bg-label-primary">Sudah Diterima</span><br><small>${day}/${month}/${year}</small>` :
                                '<span class="badge bg-label-warning">Belum Diterima</span>';
                        }
                    },
                    @if (Auth::user()->role == 'Gapoktan')
                        {
                            data: null,
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                if (row.diterima == 0) {
                                    return `<button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">
                                                 Batalkan
                                            </button>`;
                                } else {
                                    return '<span class="badge bg-label-primary"> Diterima</span>';
                                }
                            }
                        }
                    @endif

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
    </script>
@endpush
