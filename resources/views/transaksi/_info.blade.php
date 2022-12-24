@if(!empty($transaksi))
    <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-pencil mr-2"></i> Ubah</h5>
@else
    <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-plus mr-2"></i> Tambah</h5>
@endif
<form id="transaksi_form" method="post">
    @csrf
    <x-alert type="error" id="alert_transaksi" />
    <input type="hidden" name="id" value="{{ $transaksi->id ?? '' }}">
    <div class="row">
        <div class="col-md-2">
            <x-form-group id="no_transaksi" caption="No.Transaksi">
                <x-input name="no_transaksi" value="{{ $no_transaksi }}" />
            </x-form-group>
        </div>
        <div class="col-md-2">
            <x-form-group id="tanggal" caption="Tanggal">
                <x-input name="tanggal" value="{{ format_date($transaksi->tanggal ?? date('Y-m-d')) }}" class="datepicker" />
            </x-form-group>
        </div>
        <div class="col-md-8">
            <x-form-group id="keterangan" caption="Keterangan">
                <x-input name="keterangan" value="{{ $transaksi->keterangan ?? '' }}" />
            </x-form-group>
        </div>
    </div>
    <div class="text-right">
        @if(!empty($transaksi))
            <button type="button" class="btn btn-danger px-3 float-left" onclick="confirm_delete({{ $transaksi->id }})">Hapus</button>
        @endif
        <button type="button" class="btn btn-default px-3" onclick="clear_form()">Batal</button>
        <button type="submit" class="btn btn-primary px-3">{{ !empty($transaksi) ? 'Simpan' : 'Lanjutkan' }}</button>
    </div>
</form>
<div id="transaksi_detail_table"></div>

<script>
    init_form_element();
    $transaksi_form = $('#transaksi_form');
    $transaksi_form.submit((e) => {
        e.preventDefault();
        let data = new FormData($transaksi_form.get(0));
        $.ajax({
            url: "{{ route('transaksi.save') }}",
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(result) {
                @empty($transaksi)
                    edit_transaksi(result.id);
                @endempty
                search_transaksi(selected_page);
                clear_form();
            },
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                displayErrors('alert_transaksi', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    });
    confirm_delete = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            console.log(result);
            if (result.value === true) {
                delete_transaksi(id);
            }
        })
    }
    delete_transaksi = (id) => {
        let data = {_token: '{{ csrf_token() }}', id};
        $.post("{{ route('transaksi.delete') }}", data, () => {
            search_transaksi(selected_page);
            clear_form();
        }).fail((xhr) => {
            console.log(xhr.responseText);
        });
    }
    @if(!empty($transaksi))
        $transaksi_detail_table = $('#transaksi_detail_table');
        search_detail = (transaksi_id) => {
            $.post("{{ route('transaksi.search_detail') }}", {
                _token: '{{ csrf_token() }}', transaksi_id
            }, (result) => {
                $transaksi_detail_table.html(result);
            }).fail((xhr) => {
                $transaksi_detail_table.html(xhr.responseText);
            });
        }
        search_detail('{{ $transaksi->id ?? '' }}');

    save_detail = () => {
        $akun_id = $('#akun_id');
        $debit = $('#debit');
        $kredit = $('#kredit');
        $.post("{{ route('transaksi.save_detail') }}", {
            _token : '{{ csrf_token() }}',
            transaksi_id: '{{ $transaksi->id }}',
            akun_id: $akun_id.find('option:selected').val(),
            debit: $debit.val(),
            kredit: $kredit.val(),
        }, () => {
            search_detail('{{ $transaksi->id }}');
        }).fail((xhr) => {
            let error = JSON.parse(xhr.responseText);
            if (error.errors) {
                displayErrors('alert_transaksi', error.errors);
            } else {
                console.log(xhr.responseText);
            }
        });
    }
    delete_detail = (id) => {
        $.post("{{ route('transaksi.delete_detail') }}", {
            _token : '{{ csrf_token() }}', id
        }, () => {
            search_detail('{{ $transaksi->id }}');
        }).fail((xhr) => {
            console.log(xhr.responseText);
        });
    }
    @endif
</script>
