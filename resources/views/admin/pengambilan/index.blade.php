@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <form id="searchForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" id="invoice_number" name="invoice_number" class="form-control form-control-lg"
                            placeholder="Masukkan nomor invoice" required>
                        <button type="submit" class="btn btn-success btn-lg">Lihat Data</button>
                    </div>
                </form>
                <div id="result" class="mt-3"></div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const invoiceNumber = document.getElementById('invoice_number').value.trim();
            const csrfToken = document.querySelector('input[name="_token"]').value;

            if (!invoiceNumber) {
                alert('Nomor invoice tidak boleh kosong.');
                return;
            }

            function formatTanggal(dateStr) {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    // hour: '2-digit',
                    // minute: '2-digit'
                };
                return new Date(dateStr).toLocaleDateString('id-ID', options);
            }

            fetch('/search-invoice', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        invoice_number: invoiceNumber
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('result');
                    resultDiv.innerHTML = '';

                    if (data.status === 'success') {
                        const diterimaStatus = data.data.diterima == 1 ?
                            '<span class="text-success">Diterima</span>' :
                            '<span class="text-danger">Belum Diterima</span>';

                        const formUpdate = data.data.diterima == 1 ?
                            `<p><strong>Total diterima :</strong> ${data.data.jumlah_diterima}</p>` :
                            `<hr>
                        <form id="updateForm">
                            <p><strong>Konfirmasi Jumlah diambil:</strong></p>
                            <input type="hidden" name="id" value="${data.data.id}">
                            <div class="form-group">
                                <input type="number" id="jumlah_diterima" name="jumlah_diterima" class="form-control" placeholder="Masukkan jumlah diterima" required>
                            </div>
                            <button type="button" class="btn btn-success mt-2" id="updateBtn" data-max="${data.data.jumlah_pengajuan}">Update Pengambilan</button>
                        </form>`;

                        resultDiv.innerHTML = `
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-success">Invoice Ditemukan</h5><hr>
                                <p><strong>Invoice:</strong> ${data.data.invoice}</p>
                                <p><strong>Nama Petani:</strong> ${data.data.anggota.nama}</p>
                                <p><strong>Total diajukan:</strong> ${data.data.jumlah_pengajuan} Kg</p>
                                <p><strong>Tanggal Pengajuan:</strong> ${formatTanggal(data.data.created_at)}</p>
                                <p><strong>Status Pengajuan:</strong> ${diterimaStatus}</p>
                                ${formUpdate}
                            </div>
                        </div>`;
                    } else {
                        resultDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <p>${data.message}</p>
                        </div>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('result').innerHTML = `
                    <div class="alert alert-danger">
                        <p>Terjadi kesalahan. Silakan coba lagi.</p>
                    </div>`;
                });
        });

        // Event delegation for dynamically created #updateBtn
        $(document).on('click', '#updateBtn', function() {
            const jumlahDiterimaInput = $('#jumlah_diterima');
            const jumlahDiterima = parseInt(jumlahDiterimaInput.val(), 10);
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
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });
    </script>
@endpush
