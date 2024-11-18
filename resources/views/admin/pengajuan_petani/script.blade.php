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
                        name: 'id'
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
                        name: 'anggota.nama'
                    },
                    {
                        data: 'jenis_pupuk.jenis_pupuk',
                        name: 'jenis_pupuk.jenis_pupuk'
                    },

                    {
                        data: 'jumlah_pengajuan',
                        name: 'jumlah_pengajuan'
                    },
                    {
                        data: 'jumlah_diterima',
                        name: 'jumlah_diterima'
                    },
                    {
                        data: 'diterima',
                        name: 'diterima',
                        render: function(data, type, row) {
                            return data === 1 ? 'Sudah' : 'Belum';
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
