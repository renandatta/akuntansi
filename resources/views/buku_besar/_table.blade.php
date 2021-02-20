@foreach($akun as $value)
<div class="table-responsive">
    <table class="table table-borderless">
        <tbody>
        <tr>
            <td class="py-1" colspan="6" style="background-color: #eaeaea;"><b>{{ $value->kode . ' - ' . $value->nama }}</b></td>
        </tr>
        @php($saldo = 0)
        @foreach($value->transaksi as $item)
            @php($saldo = $saldo + ($item->debit - $item->kredit))
            <tr>
                <td class="text-nowrap py-1" width="120px">{{ format_date($item->transaksi->tanggal) }}</td>
                <td class="text-nowrap py-1" width="120px">{{ $item->transaksi->no_transaksi }}</td>
                <td class="text-nowrap py-1">{{ $item->transaksi->keterangan }}</td>
                <td class="text-nowrap py-1 text-right" width="170px">{{ format_number($item->debit) }}</td>
                <td class="text-nowrap py-1 text-right" width="170px">{{ format_number($item->kredit) }}</td>
                <td class="text-nowrap py-1 text-right" width="170px">{{ format_number($saldo) }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="py-1 border-top" colspan="3"></td>
            <td class="py-1 border-top text-right">{{ format_number($value->transaksi->sum('debit')) }}</td>
            <td class="py-1 border-top text-right">{{ format_number($value->transaksi->sum('kredit')) }}</td>
            <td class="py-1 border-top"></td>
        </tr>
        </tbody>
    </table>
</div>
@endforeach
