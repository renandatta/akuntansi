<?php

namespace App\Http\Controllers;

use App\Repositories\AkunRepository;
use App\Repositories\AkuntansiRepository;
use Illuminate\Http\Request;

class LabaRugiController extends Controller
{
    protected $akuntansi, $akun;
    public function __construct(AkuntansiRepository $akuntansi, AkunRepository $akun)
    {
        $this->middleware(['fitur_program']);
        view()->share(['title' => 'Laba Rugi']);
        $this->akuntansi = $akuntansi;
        $this->akun = $akun;
    }

    public function index()
    {
        return view('laba_rugi.index');
    }

    public function search(Request $request)
    {
        $akun_pendapatan = $this->akun->find('04', 'kode');
        $akun_pengeluaran = $this->akun->find('05', 'kode');
        $pendapatan = $this->akuntansi->transaksi_akun($request, $akun_pendapatan->kode);
        $pengeluaran = $this->akuntansi->transaksi_akun($request, $akun_pengeluaran->kode);

        $result = [
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran,
            'akun_pendapatan' => $akun_pendapatan,
            'akun_pengeluaran' => $akun_pengeluaran
        ];
        if ($request->has('ajax')) return $result;
        return view('laba_rugi._table', $result);
    }

    public function cetak(Request $request)
    {
        $request->merge(['ajax' => 1]);
        $labarugi = $this->search($request);
        $tanggal_mulai = $request->input('tanggal_mulai') ?? '';
        $tanggal_sampai = $request->input('tanggal_sampai') ?? '';
        return view('laba_rugi.cetak', compact(
            'labarugi', 'tanggal_mulai', 'tanggal_sampai'
        ));
    }
}
