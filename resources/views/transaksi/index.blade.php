@extends('layouts.index')

@section('title')
    {{ $title }} -
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $title }}</h4>
            </div>
        </div>
    </div>
    <table class="table bg-main" >
        <tr>
            <td class="bg-light" id="transaksi_info">
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn btn-sm btn-success float-right px-3" onclick="add_new()">Tambah</button>
                <button class="btn btn-sm btn-info float-right px-3 mr-3" onclick="toggle_search()">search</button>
                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-database mr-2"></i> Data {{ $title }}</h5>
                <div id="transaksi_table"></div>
            </td>
            <td class="bg-light" id="transaksi_search" width="350px">
                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-database-search mr-2"></i> Search</h5>
                <form id="search_form">
                    @csrf
                    <x-form-group id="search_keterangan" caption="Keterangan">
                        <x-input prefix="search_" name="keterangan" caption="Pencarian keterangan" />
                    </x-form-group>
                    <x-form-group id="search_no_transaksi" caption="No.Transaksi">
                        <x-input prefix="search_" name="no_transaksi" caption="Pencarian no_transaksi" />
                    </x-form-group>
                    <x-form-group id="search_tanggal" caption="Tanggal">
                        <x-input prefix="search_" name="tanggal" caption="Pencarian tanggal" class="datepicker" />
                    </x-form-group>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </td>
        </tr>
    </table>
@endsection

@push('scripts')
    <script>
        init_form_element();

        // manage ui
        $transaksi_data = $('#transaksi_data');
        $transaksi_search = $('#transaksi_search');
        $transaksi_search.hide();
        toggle_search = () => {
            $transaksi_search.toggle();
        }

        // search
        let selected_page = 1;
        $search_form = $('#search_form');
        $transaksi_table = $('#transaksi_table');
        search_transaksi = (page = 1) => {
            if (page.toString() === '+1') selected_page++;
            else if (page.toString() === '-1') selected_page--;
            else selected_page = page;

            let data = getFormData($search_form);
            data.paginate = 10;
            $.post("{{ route('transaksi.search') }}?page=" + selected_page, data, (result) => {
                $transaksi_table.html(result);
            }).fail((xhr) => {
                $transaksi_table.html(xhr.responseText);
            });
        }
        search_transaksi();
        $search_form.submit((e) => {
            e.preventDefault();
            search_transaksi();
        })

        // crud
        $transaksi_info = $('#transaksi_info');
        $transaksi_info.hide();
        add_new = () => {
            let data = {_token: '{{ csrf_token() }}'};
            $.post("{{ route('transaksi.info') }}", data, (result) => {
                $transaksi_info.html(result);
                $transaksi_info.show();
            }).fail((xhr) => {
                $transaksi_info.html(xhr.responseText);
                $transaksi_info.show();
            });
        }
        edit_transaksi = (id) => {
            let data = {_token: '{{ csrf_token() }}', id};
            $.post("{{ route('transaksi.info') }}", data, (result) => {
                $transaksi_info.html(result);
                $transaksi_info.show();
            }).fail((xhr) => {
                $transaksi_info.html(xhr.responseText);
                $transaksi_info.show();
            });
        }
        clear_form = () => {
            $transaksi_info.html('');
            $transaksi_info.hide();
        }

        let _token = '{{ csrf_token() }}';
    </script>
@endpush
