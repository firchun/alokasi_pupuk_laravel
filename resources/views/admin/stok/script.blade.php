@push('js')
    <script>
        $(function() {
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: '{{ url('stok-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    @if (Auth::user()->role != 'Distributor')
                        {
                            data: 'distributor.name',
                            name: 'distributor.name'
                        },
                    @endif {
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
                            if (data === 1) {
                                return 'Diterima';
                            } else if (data === 0) {
                                return 'Pengajuan';
                            } else if (data === 2) {
                                return 'Ditolak';
                            } else {
                                return 'Tidak Diketahui';
                            }
                        }
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

            $('#createCustomerBtn').click(function() {
                var formData = $('#createUserForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/stok/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#id_jenis_pupuk').val('');
                        $('#jumlah_pengajuan').val('');
                        $('#datatable-customers').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            window.confirmCustomers = function(id) {
                $('#terima').modal('show');
                $.ajax({
                    type: 'GET',
                    url: '/stok/edit/' + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#terimaId').val(response.id);
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            $('#terimaBtn').click(function() {
                var formData = $('#terimaForm').serialize();
                $.ajax({
                    type: 'POST',
                    url: '/stok/terima',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#jumlahDiterima').val('');
                        $('#datatable-customers').DataTable().ajax.reload();
                        $('#terima').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            window.rejectCustomers = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/stok/tolak/' + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#datatable-customers').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            window.deleteCustomers = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/stok/delete/' + id,
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
