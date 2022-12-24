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
            <td class="bg-light" id="neraca_search">
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
                <div id="neraca_table"></div>
            </td>
        </tr>
    </table>
@endsection

@push('scripts')
    <script>
        init_form_element();

        // search
        $search_form = $('#search_form');
        $neraca_table = $('#neraca_table');
        search_neraca = () => {

            let data = getFormData($search_form);
            $.post("{{ route('neraca.search') }}", data, (result) => {
                $neraca_table.html(result);
            }).fail((xhr) => {
                $neraca_table.html(xhr.responseText);
            });
        }
        search_neraca();
        $search_form.submit((e) => {
            e.preventDefault();
            search_neraca();
        })

        cetak = () => {
            let tanggal_mulai = $('#search_tanggal_mulai').val(),
                tanggal_sampai = $('#search_tanggal_sampai').val();
            let params = [
                'tanggal_mulai=' + tanggal_mulai,
                'tanggal_sampai=' + tanggal_sampai,
            ];
            window.open("{{ route('neraca.cetak') }}?" + params.join('&'), '_blank');
        }
    </script>
@endpush
