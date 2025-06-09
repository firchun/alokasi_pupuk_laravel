@push('js')
    <script>
        $(function() {
            $('#datatable-users').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url('users-datatable', $role) }}',
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
                        data: 'avatar',
                        name: 'avatar'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },

                    {
                        data: 'role',
                        name: 'role'
                    },
                    @if ($role == 'Poktan')
                        {
                            data: 'anggota',
                            name: 'anggota'
                        },
                    @endif {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            window.editUser = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/users/edit/' + id,
                    success: function(response) {
                        $('#UsersModalLabel').text('Edit User');
                        $('#formUserId').val(response.id);
                        $('#formUserName').val(response.name);
                        $('#formUserEmail').val(response.email);
                        $('#UsersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            $('#saveUserBtn').click(function() {
                var formData = $('#userForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/users/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-users').DataTable().ajax.reload();
                        $('#UsersModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createUserBtn').click(function() {
                var formData = $('#createUserForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/users/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#userssModalLabel').text('Edit User');
                        $('#formUserName').val('');
                        $('#datatable-users').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });

            window.deleteUser = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/users/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.message);
                            // Refresh DataTable setelah menghapus pengguna
                            $('#datatable-users').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            };
            window.anggotaUser = function(id) {
                const baseUrl = "{{ url('/kelompok-tani/') }}";
                const redirectUrl = `${baseUrl}/${id}`;

                window.location.href = redirectUrl;
            };
        });
    </script>
@endpush
