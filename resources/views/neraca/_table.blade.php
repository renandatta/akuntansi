<div class="table-responsive">
    <table class="table table-borderless">
        <tbody>
        {{--Kas--}}
        <tr>
            <td class="text-nowrap pb-1" colspan="2"><b>{{ $akun_kas->parent->nama }}</b></td>
        </tr>
        <tr>
            <td class="text-nowrap py-1 pl-4">{{ $akun_kas->kode . ' - ' . $akun_kas->nama }}</td>
            <td class="text-right py-1" width="150px">{{ format_number($kas) }}</td>
        </tr>
        <tr>
            <td class="text-nowrap pt-1"><b>Total {{ $akun_kas->nama }}</b></td>
            <td class="text-right pt-1"><b>{{ format_number($kas) }}</b></td>
        </tr>

        {{--Modal--}}
        <tr>
            <td class="text-nowrap pb-1" colspan="2"><b>Ekuitas</b></td>
        </tr>
        <tr>
            <td class="text-nowrap py-1 pl-4">{{ $akun_modal->kode . ' - ' . $akun_modal->nama }}</td>
            <td class="text-right py-1" width="150px">{{ format_number($modal) }}</td>
        </tr>
        <tr>
            <td class="text-nowrap py-1 pl-4">{{ $akun_labarugi->kode . ' - ' . $akun_labarugi->nama }}</td>
            <td class="text-right py-1" width="150px">{{ format_number($labarugi) }}</td>
        </tr>
        <tr>
            <td class="text-nowrap pt-1"><b>Total Ekuitas</b></td>
            <td class="text-right pt-1"><b>{{ format_number($modal+$labarugi) }}</b></td>
        </tr>

        </tbody>
    </table>
</div>
