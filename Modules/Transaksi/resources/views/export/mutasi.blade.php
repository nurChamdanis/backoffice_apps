<div class="card-inner">
    <table id="tbl_trx" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>TANGGAL</th>
                <th>REF NO</th>
                <th>USERNAME</th>
                <th>TUJUAN</th>
                <th>KETERANGAN</th>
                <th>NOMINAL</th>
                <th>JENIS TRANSAKSI</th>
                <th>TIPE</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>
                        {{$item->updated_at}}
                    </td>
                    <td>
                        {{Str::upper($item->ref_id)}}
                    </td>
                    <td>
                        {{$item->username}}
                    </td>
                    <td>
                        {{strval("'".$item->tujuan)}}
                    </td>
                    <td>
                        {{strval($item->desc)}}
                    </td>
                    <td>
                        {{$item->nominal}}
                    </td>
                    <td>
                        {{$item->jenis}}
                    </td>
                    <td>
                        {{$item->type}}
                    </td>
                    <td>
                        {{Str::upper($item->status)}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>