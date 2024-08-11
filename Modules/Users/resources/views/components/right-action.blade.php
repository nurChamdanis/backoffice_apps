<ul class="nk-tb-actions p-0">
    <li class="">
        <a class="btn btn-sm" href={{ $editAdj }} data-toggle="tooltip" data-placement="top"
            title="Adjust Saldo">
            <em class="icon ni ni-coin"></em>
        </a>
    </li>
    {{-- <li class="">
        <a class="btn btn-sm" href={{ $resetLink }} data-toggle="tooltip" data-placement="top"
            title="Reset Password">
            <em class="icon ni ni-cc-secure-fill"></em>
        </a>
    </li> --}}

    @role('superadmin')
    <li class="">
        <form onsubmit="return confirm('Anda yakin akan menghapus data ini ?')" class="d-inline"
            action="{{ $delete }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm">
                <em class="icon ni ni-trash-empty"></em>
            </button>
        </form>
    </li>
    @endrole
</ul>
