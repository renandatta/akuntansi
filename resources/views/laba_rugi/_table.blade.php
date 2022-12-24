<div class="table-responsive">
    <table class="table table-borderless">
        <tbody>
        {{--Pendapatan--}}
        <tr>
            <td class="text-nowrap pb-1" colspan="2"><b>{{ $akun_pendapatan->nama }}</b></td>
        </tr>
        @foreach($pendapatan as $value)
            <tr>
                <td class="text-nowrap py-1 pl-4">{{ $value->akun->kode . ' - ' . $value->akun->nama }}</td>
                <td class="text-right py-1" width="150px">{{ format_number($value->total_debit) }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="text-nowrap pt-1"><b>Total {{ $akun_pendapatan->nama }}</b></td>
            <td class="text-right pt-1"><b>{{ format_number($pendapatan->sum('total_debit')) }}</b></td>
        </tr>

        {{--Pengeluaran--}}
        <tr>
            <td class="text-nowrap pb-1"><b>{{ $akun_pengeluaran->nama }}</b></td>
        </tr>
        @foreach($pengeluaran as $value)
            <tr>
                <td class="text-nowrap py-1 pl-4">{{ $value->akun->kode . ' - ' . $value->akun->nama }}</td>
                <td class="text-right py-1" width="150px">{{ format_number($value->total_debit) }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="text-nowrap pt-1"><b>Total {{ $akun_pengeluaran->nama }}</b></td>
            <td class="text-right pt-1"><b>{{ format_number($pengeluaran->sum('total_debit')) }}</b></td>
        </tr>
        <tr>
            <td class="py-1" colspan="2"><hr class="my-1"></td>
        </tr>
        <tr>
            <td class="text-nowrap pt-1"><b>Total Laba Bersih</b></td>
            <td class="text-right pt-1"><b>{{ format_number($pendapatan->sum('total_debit') - $pengeluaran->sum('total_debit')) }}</b></td>
        </tr>
        </tbody>
    </table>
</div>
