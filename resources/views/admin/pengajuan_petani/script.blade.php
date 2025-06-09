@push('js')
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
                            return `${data}<br><small class="text-mutted">${row.anggota.nik}</small>`;
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
                            return data === 1 ? 'Sudah Diterima' : 'Belum Diterima';
                        }
                    }
                ]
            });

            $('.refresh').click(function() {
                $('#datatable-customers').DataTable().ajax.reload();
            });
        });
    </script>
@endpush
