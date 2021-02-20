@extends('layouts.blank')

@section('title')
    Buku Besar - Nama Perusahaan -
    @if($tanggal_mulai != '' && $tanggal_sampai != '')
        {{ fulldate($tanggal_mulai) }} s/d {{ fulldate($tanggal_sampai) }}
    @endif
@endsection

@section('content')
    <h4 class="text-center mb-0">Nama Perusahaan</h4>
    <p class="text-center">Alamat perusahaan<br>Kontak perusahaan</p>
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
