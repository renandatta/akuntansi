<?php

namespace App\Http\Controllers;

use App\Repositories\AkunRepository;
use App\Repositories\AkuntansiRepository;
use App\Repositories\TransaksiDetailRepository;
use Illuminate\Http\Request;

class BukuBesarController extends Controller
{
    protected $akun, $akuntansi, $transaksiDetail;
    public function __construct(AkunRepository $akun,
                                TransaksiDetailRepository $transaksiDetail,
                                AkuntansiRepository $akuntansi)
    {
        $this->middleware(['fitur_program']);
        view()->share(['title' => 'Buku Besar']);
        $this->akun = $akun;
        $this->akuntansi = $akuntansi;
        $this->transaksiDetail = $transaksiDetail;
    }

    public function index()
    {
        return view('buku_besar.index');
    }

    public function search(Request $request)
    {
        $request->merge(['order_tanggal' => 'asc']);
        $akun_id = $this->transaksiDetail->search($request)->pluck('akun_id')->toArray();
        $akun = $this->akun->search(new Request(['id_in' => $akun_id]));
        foreach ($akun as $value) {
            $request->merge(['akun_id' => $value->id]);
            $value->transaksi = $this->transaksiDetail->search($request);;
        }
        if ($request->has('ajax')) return $akun;
        return view('buku_besar._table', compact('akun'));
    }

    public function cetak(Request $request)
    {
        $request->merge(['ajax' => 1]);
        $akun = $this->search($request);
        $tanggal_mulai = $request->input('tanggal_mulai') ?? '';
        $tanggal_sampai = $request->input('tanggal_sampai') ?? '';
        return view('buku_besar.cetak', compact('akun', 'tanggal_mulai', 'tanggal_sampai'));
    }
}
