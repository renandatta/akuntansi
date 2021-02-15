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
            <td class="bg-light" id="buku_besar_search">
                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-database-search mr-2"></i> Search</h5>
                <form id="search_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <x-form-group id="search_tanggal_mulai" caption="Tanggal Mulai">
                                <x-input prefix="search_" name="tanggal_mulai" class="datepicker" />
                            </x-form-group>
                        </div>
                        <div class="col-md-4">
                            <x-form-group id="search_tanggal_sampai" caption="Tanggal Mulai">
                                <x-input prefix="search_" name="tanggal_sampai" class="datepicker" />
                            </x-form-group>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <button type="submit" class="btn btn-primary btn-block mt-2">Search</button>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <button type="button" class="btn btn-success btn-block mt-2" onclick="cetak()">Cetak</button>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <h5 class="mt-0 mb-4 text-white"><i class="mdi mdi-database mr-2"></i> Data {{ $title }}</h5>
                <div id="buku_besar_table"></div>
            </td>
        </tr>
    </table>
@endsection

@push('scripts')
    <script>
        init_form_element();

        // search
        $search_form = $('#search_form');
        $buku_besar_table = $('#buku_besar_table');
        search_buku_besar = () => {

            let data = getFormData($search_form);
            $.post("{{ route('buku_besar.search') }}", data, (result) => {
                $buku_besar_table.html(result);
            }).fail((xhr) => {
                $buku_besar_table.html(xhr.responseText);
            });
        }
        search_buku_besar();
        $search_form.submit((e) => {
            e.preventDefault();
            search_buku_besar();
        })

        cetak = () => {
            let tanggal_mulai = $('#search_tanggal_mulai').val(),
                tanggal_sampai = $('#search_tanggal_sampai').val();
            let params = [
                'tanggal_mulai=' + tanggal_mulai,
                'tanggal_sampai=' + tanggal_sampai,
            ];
            window.open("{{ route('buku_besar.cetak') }}?" + params.join('&'), '_blank');
        }
    </script>
@endpush
