@extends('layouts.blank')

@section('title')
    Jurnal
@endsection

@section('content')
    <h4 class="text-center mb-0">Nama Perusahaan</h4>
    <h4 class="text-center mb-0">Laporan Jurnal</h4>
    @if($tanggal_mulai != '' && $tanggal_sampai != '')
        <h5 class="text-center mb-0">{{ fulldate($tanggal_mulai) }} &nbsp; s/d &nbsp; {{ fulldate($tanggal_sampai) }}</h5>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <hr>
                @include('jurnal._table', ['jurnal' => $jurnal])
            </div>
        </div>
    </div>
@endsection
