<?php

namespace App\Http\Controllers;

use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    protected $akun, $transaksi;
    public function __construct(AkunRepository $akun, TransaksiRepository $transaksi)
    {
        $this->middleware(['fitur_program']);
        view()->share(['title' => 'Jurnal']);
        $this->akun = $akun;
        $this->transaksi = $transaksi;
    }

    public function index()
    {
        return view('jurnal.index');
    }

    public function search(Request $request)
    {
        $request->merge(['order' => 'tanggal']);
        $jurnal = $this->transaksi->search($request);
        if ($request->has('ajax')) return $jurnal;
        return view('jurnal._table', compact('jurnal'));
    }

    public function cetak(Request $request)
    {
        $request->merge(['ajax' => 1]);
        $jurnal = $this->search($request);
        $tanggal_mulai = $request->input('tanggal_mulai') ?? '';
        $tanggal_sampai = $request->input('tanggal_sampai') ?? '';
        return view('jurnal.cetak', compact('jurnal', 'tanggal_mulai', 'tanggal_sampai'));
    }
}
