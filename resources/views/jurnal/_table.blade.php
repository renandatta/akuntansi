<div class="table-responsive">
    <table class="table table-bordered">
        <tbody>
        @foreach($jurnal as $value)
            <tr style="background-color: #eaeaea;">
                <td class="text-nowrap py-1" width="150px"><b>{{ format_date($value->tanggal) }}</b></td>
                <td class="text-nowrap py-1" colspan="4"><b>{{ $value->keterangan }}</b></td>
            </tr>
            @foreach($value->detail as $item)
                <tr>
                    <td class="text-nowrap py-1" width="100px"></td>
                    <td class="text-nowrap py-1">{{ $item->akun->kode . ' - ' . $item->akun->nama }}</td>
                    <td class="text-nowrap py-1 text-right">{{ format_number($item->debit) }}</td>
                    <td class="text-nowrap py-1 text-right">{{ format_number($item->kredit) }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="py-1" colspan="5"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
