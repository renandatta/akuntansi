<div class="table-responsive">
    <table class="table table-borderless">
        <tbody>
        @php($pos_parent = '')
        @foreach($arus_kas as $value)
            @if($value->akun->parent_kode != $pos_parent)
                <tr>
                    <td class="text-nowrap py-1" colspan="2"><b>{{ $value->akun->parent->nama }}</b></td>
                </tr>
            @endif
            <tr>
                <td class="text-nowrap py-1 pl-4">{{ $value->akun->kode . ' - ' . $value->akun->nama }}</td>
                <td class="text-right py-1" width="150px">{{ format_number($value->saldo) }}</td>
            </tr>
            @php($pos_parent = $value->akun->parent_kode)
        @endforeach
        <tr>
            <td class="py-1" colspan="2"><hr class="my-1"></td>
        </tr>
        <tr>
            <td class="text-nowrap py-1"><b>Total Kas</b></td>
            <td class="text-right py-1" width="150px"><b>{{ format_number($arus_kas->sum('saldo')) }}</b></td>
        </tr>
        </tbody>
    </table>
</div>
