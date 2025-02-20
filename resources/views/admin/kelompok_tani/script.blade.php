@push('js')
    <script>
        $(function() {
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url('kelompok-tani-datatable', $id_poktan) }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },

                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            $('.refresh').click(function() {
                $('#datatable-customers').DataTable().ajax.reload();
            });
            window.editCustomer = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/kelompok-tani/edit/' + id,
                    success: function(response) {
                        $('#formCustomerId').val(response.id);
                        $('#Nama').val(response.nama);
                        $('#NIK').val(response.nik);
                        $('#NoHp').val(response.no_hp);
                        $('#Alamat').val(response.alamat);
                        $('#customersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            window.riwayatCustomer = function(id) {
                $('#riwayatModal').modal('show');
                $('#datatable-pengajuan-petani').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    ajax: '{{ url('pengajuan-pupuk-petani-datatable') }}',
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

                    ]
                });
            };
            $('#saveCustomerBtn').click(function() {
                var formData = $('#userForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/kelompok-tani/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-customers').DataTable().ajax.reload();
                        $('#customersModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createCustomerBtn').click(function() {
                var formData = $('#createUserForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/kelompok-tani/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#createNama').val('');
                        $('#createNoHp').val('');
                        $('#createNIK').val('');
                        $('#createAlamat').val('');
                        $('#datatable-customers').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            window.deleteCustomers = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus anggota ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/kelompok-tani/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-customers').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            };
        });
    </script>
@endpush
