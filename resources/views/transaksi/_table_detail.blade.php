<div class="table-responsive mt-3">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="30px">No</th>
            <th>Akun</th>
            <th class="text-right">Debit</th>
            <th class="text-right">Kredit</th>
            <th width="30px">Action</th>
        </tr>
        </thead>
        <tbody>
        @if(method_exists($transaksi_detail, 'links'))
            @php
                $transaksi_detail = $transaksi_detail ?? null;
                $no = (($transaksi_detail->currentPage()-1) * $transaksi_detail->perPage()) + 1
            @endphp
        @else
            @php($no = 1)
        @endif
        @foreach($transaksi_detail as $value)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-nowrap">{{ $value->akun->kode . ' ' . $value->akun->nama }}</td>
                <td class="text-right">{{ format_number($value->debit) }}</td>
                <td class="text-right">{{ format_number($value->kredit) }}</td>
                <td class="p-0 text-center vertical-middle" width="30px">
                    <button type="button" class="btn btn-danger btn-sm py-1" onclick="delete_detail({{ $value->id }})">
                        <i class="mdi mdi-close"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        <tr>
            <td>#</td>
            <td class="p-0 vertical-middle">
                <x-select name="akun_id" :options="$list_akun" class="select2" />
            </td>
            <td class="p-0 vertical-middle" width="200px">
                <x-input name="debit" class="autonumeric text-right" value="0" />
            </td>
            <td class="p-0 vertical-middle" width="200px">
                <x-input name="kredit" class="autonumeric text-right" value="0" />
            </td>
            <td class="p-0 text-center vertical-middle" width="30px">
                <button type="button" class="btn btn-primary btn-sm py-1" onclick="save_detail()">
                    <i class="mdi mdi-plus"></i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</div>
@if(method_exists($transaksi_detail, 'links'))
    {{ $transaksi_detail->links('vendor.pagination.custom', ['function' => 'search_transaksi_detail']) }}
@endif

<script>
    init_form_element();
</script>
