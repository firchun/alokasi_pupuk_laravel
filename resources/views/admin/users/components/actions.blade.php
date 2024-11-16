<div class="btn-group d-flex">
    <button class="btn btn-sm btn-primary" onclick="editUser({{ $user->id }})">Edit</button>
    @if ($user->role == 'Poktan')
        <button class="btn btn-sm btn-warning" onclick="anggotaUser({{ $user->id }})">Anggota</button>
    @endif
    @if (Auth::user()->id != $user->id)
        <button class="btn btn-sm btn-danger delete-button" onclick="deleteUser({{ $user->id }})">Delete</button>
    @endif
</div>
