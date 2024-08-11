<ul class="nk-tb-actions p-0">
    <li class="">
        <form onsubmit="return confirm('Anda yakin akan mengembalikan data ini ?')" class="d-inline"
            action="{{ $restore }}" method="POST">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn btn-warning btn-sm btn-restore">
                <em class="icon ni ni-exchange"></em>
            </button>
        </form>
    </li>
    <li class="" style="margin: 0px 10px 0px 10px">
        <form onsubmit="return confirm('Anda yakin akan menghapus permanen untuk data ini ?')" class="d-inline"
            action="{{ $delete }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn btn-danger btn-sm btn-force-delete">
                <em class="icon ni ni-trash-empty"></em>
            </button>
        </form>
    </li>
</ul>
