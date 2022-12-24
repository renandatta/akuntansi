<?php

namespace App\Http\Controllers;

use App\Repositories\AkunRepository;
use App\Repositories\AkuntansiRepository;
use Illuminate\Http\Request;

class NeracaController extends Controller
{
    protected $akun, $akuntansi;
    public function __construct(AkunRepository $akun, AkuntansiRepository $akuntansi)
    {
        $this->middleware(['fitur_program']);
        view()->share(['title' => 'Neraca']);
        $this->akun = $akun;
        $this->akuntansi = $akuntansi;
    }

    public function index()
    {
        return view('neraca.index');
    }

    public function search(Request $request)
    {
        $akun_kas = $this->akun->find('01.01', 'kode');
        $akun_modal = $this->akun->find('03.01', 'kode');
        $akun_labarugi = $this->akun->find('03.02', 'kode');

        $arus_kas = $this->akuntansi->transaksi_akun($request, '01.01');
        $kas = $arus_kas->sum('total_kredit') - $arus_kas->sum('total_debit');
        $modal = $this->akuntansi->transaksi_akun($request, '03.01')
            ->sum('total_debit');
        $labarugi = $this->akuntansi->laba_rugi($request);

        $result = [
            'akun_kas' => $akun_kas,
            'akun_modal' => $akun_modal,
            'akun_labarugi' => $akun_labarugi,
            'kas' => $kas,
            'modal' => $modal,
            'labarugi' => $labarugi
        ];
        if ($request->has('ajax')) return $result;
        return view('neraca._table', $result);
    }

    public function cetak(Request $request)
    {
        $request->merge(['ajax' => 1]);
        $neraca = $this->search($request);
        $tanggal_mulai = $request->input('tanggal_mulai') ?? '';
        $tanggal_sampai = $request->input('tanggal_sampai') ?? '';
        return view('neraca.cetak', compact('neraca', 'tanggal_mulai', 'tanggal_sampai'));
    }
}
