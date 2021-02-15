@extends('layouts.blank')

@section('title')
    Buku Besar
@endsection

@section('content')
    <h4 class="text-center mb-0">Nama Perusahaan</h4>
    <h4 class="text-center mb-0">Buku Besar</h4>
    @if($tanggal_mulai != '' && $tanggal_sampai != '')
        <h5 class="text-center mb-0">{{ fulldate($tanggal_mulai) }} &nbsp; s/d &nbsp; {{ fulldate($tanggal_sampai) }}</h5>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <hr>
                @include('buku_besar._table', ['akun' => $akun])
            </div>
        </div>
    </div>
@endsection
