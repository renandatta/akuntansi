@extends('layouts.blank')

@section('title')
    Laba Rugi - Nama Perusahaan -
    @if($tanggal_mulai != '' && $tanggal_sampai != '')
        {{ fulldate($tanggal_mulai) }} s/d {{ fulldate($tanggal_sampai) }}
    @endif
@endsection

@section('content')
    <h4 class="text-center mb-0">Nama Perusahaan</h4>
    <p class="text-center">Alamat perusahaan<br>Kontak perusahaan</p>
    <h4 class="text-center mb-0">Laba Rugi</h4>
    @if($tanggal_mulai != '' && $tanggal_sampai != '')
        <h5 class="text-center mb-0">{{ fulldate($tanggal_mulai) }} &nbsp; s/d &nbsp; {{ fulldate($tanggal_sampai) }}</h5>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <hr>
                @include('laba_rugi._table', $labarugi)
            </div>
        </div>
    </div>
@endsection
