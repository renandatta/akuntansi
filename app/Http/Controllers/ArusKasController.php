<?php

namespace App\Http\Controllers;

use App\Repositories\AkunRepository;
use App\Repositories\AkuntansiRepository;
use Illuminate\Http\Request;

class ArusKasController extends Controller
{
    protected $akun, $akuntansi;
    public function __construct(AkunRepository $akun, AkuntansiRepository $akuntansi)
    {
        $this->middleware(['fitur_program']);
        view()->share(['title' => 'Arus Kas']);
        $this->akun = $akun;
        $this->akuntansi = $akuntansi;
    }

    public function index()
    {
        return view('arus_kas.index');
    }

    public function search(Request $request)
    {
        $arus_kas = $this->akuntansi->transaksi_akun($request, '01.01');
        foreach ($arus_kas as $value) {
            $value->saldo = $value->total_kredit - $value->total_debit;
        }
        if ($request->has('ajax')) return $arus_kas;
        return view('arus_kas._table', compact('arus_kas'));
    }

    public function cetak(Request $request)
    {
        $request->merge(['ajax' => 1]);
        $data = $this->search($request);
        $tanggal_mulai = $request->input('tanggal_mulai') ?? '';
        $tanggal_sampai = $request->input('tanggal_sampai') ?? '';
        return view('arus_kas.cetak', compact('data', 'tanggal_mulai', 'tanggal_sampai'));
    }
}
