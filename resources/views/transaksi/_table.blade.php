<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="30px">No</th>
            <th>No.Transaksi</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th class="text-right">Nominal</th>
            <th width="30px">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(method_exists($transaksi, 'links'))
            @php
                $transaksi = $transaksi ?? null;
                $no = (($transaksi->currentPage()-1) * $transaksi->perPage()) + 1
            @endphp
        @else
            @php($no = 1)
        @endif
        @foreach($transaksi as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->no_transaksi }}</td>
                <td class="text-nowrap">{{ format_date($value->tanggal) }}</td>
                <td class="text-nowrap">{{ $value->keterangan }}</td>
                <td class="text-right">{{ format_number($value->nominal) }}</td>
                <td class="p-0 text-center vertical-middle" width="30px">
                    <div class="btn-group dropleft">
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle py-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-menu-left"></i>
                        </button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="javascript:void(0)" onclick="edit_transaksi({{ $value->id }})">Ubah</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if(method_exists($transaksi, 'links'))
    {{ $transaksi->links('vendor.pagination.custom', ['function' => 'search_transaksi']) }}
@endif
