<div class="btn-group d-flex">
    @if (Auth::user()->role == 'PPL' && $customer->diterima == 0)
        <button class="btn btn-sm btn-success " onclick="confirmCustomers({{ $customer->id }})">Terima</button>
        <button class="btn btn-sm btn-danger " onclick="rejectCustomers({{ $customer->id }})">Tolak</button>
    @else
        <button class="btn btn-sm btn-danger " onclick="deleteCustomers({{ $customer->id }})">Delete</button>
    @endif
</div>
