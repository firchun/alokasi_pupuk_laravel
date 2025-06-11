<div class="btn-group d-flex">
    <button class="btn btn-sm btn-primary" onclick="editCustomer({{ $customer->id }})">Edit</button>
    <button class="btn btn-sm btn-warning" onclick="riwayatCustomer({{ $customer->id }})">Riwayat</button>
    <button class="btn btn-sm btn-danger " onclick="deleteCustomers({{ $customer->id }})">Delete</button>
</div>
