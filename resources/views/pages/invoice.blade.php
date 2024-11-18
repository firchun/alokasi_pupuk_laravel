@extends('layouts.frontend.app')
@section('main')
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-8">
                    <form id="searchForm">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" id="invoice_number" name="invoice_number" class="form-control form-control-lg"
                                placeholder="Masukkan nomor invoice" required>
                            <button type="submit" class="btn btn-success btn-lg">Cari Invoice</button>
                        </div>
                    </form>
                    <div id="result" class="mt-3"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form submit secara langsung

            const invoiceNumber = document.getElementById('invoice_number').value;
            const csrfToken = document.querySelector('input[name="_token"]').value;
            if (!invoiceNumber.trim()) {
                alert('Nomor invoice tidak boleh kosong.');
                return;
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
                        const diterimaStatus = data.data.diterima === 1 ?
                            '<span class="text-success">Diterima</span>' :
                            '<span class="text-danger">Belum Diterima</span>';
                        resultDiv.innerHTML = `
                    <div class="alert alert-success">
                        <h5>Invoice Ditemukan</h5><hr>
                        <p><strong>Invoice:</strong> ${data.data.invoice}</p>
                        <p><strong>Nama Petani:</strong> ${data.data.anggota.nama}</p>
                        <p><strong>Total diajukan :</strong> ${data.data.jumlah_pengajuan}</p>
                        <p><strong>Status Pengajuan :</strong> ${diterimaStatus}</p>
                    </div>
                    `;
                    } else {
                        resultDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <p>${data.message}</p>
                        </div>
                    `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('result').innerHTML = `
                    <div class="alert alert-danger">
                        <p>Terjadi kesalahan. Silakan coba lagi.</p>
                    </div>
                `;
                });
        });
    </script>
@endpush
