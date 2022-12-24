<?php

namespace App\Repositories;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AkuntansiRepository extends Repository
{
    protected $akun, $transaksiDetail;
    public function __construct(AkunRepository $akun, TransaksiDetailRepository $transaksiDetail)
    {
        $this->akun = $akun;
        $this->transaksiDetail = $transaksiDetail;
    }

    public function modal(Request $request)
    {
        $akun_modal = $this->akun->find('03.01', 'kode');
        $request->merge(['kode_like' => $akun_modal->kode]);
        $request->merge(['group_by' => array('akun_id')]);
        $request->merge(['select' => array('akun_id', DB::raw('sum(kredit) as total_kredit'), DB::raw('sum(kredit) as total_kredit'))]);
        $modal = $this->transaksiDetail->search($request);

        return $modal->sum('total_kredit');
    }

    public function arus_kas(Request $request)
    {
        $akun_kas = $this->akun->find('01.01', 'kode');
        $request->merge(['kode_like' => $akun_kas->kode]);
        $request->merge(['select' => array('transaksi_id')]);
        $list_transaksi_kas = $this->transaksiDetail
            ->search($request)->pluck('transaksi_id')->toArray();

        $list = $this->transaksiDetail->search(new Request([
            'transaksi_id_in' => $list_transaksi_kas,
            'akun_id_not' => $akun_kas->id,
            'group_by' => array('akun_id'),
            'select' => array('akun_id', DB::raw('sum(debit) as total_debit'), DB::raw('sum(kredit) as total_kredit'))
        ]));

        return [
            'list' => $list,
            'kas' => $list->sum('total_kredit') - $list->sum('total_debit')
        ];
    }

    public function transaksi_akun(Request $request, $kode_akun)
    {
        $akun_kas = $this->akun->find($kode_akun, 'kode');
        $request->merge(['kode_like' => $akun_kas->kode]);
        $request->merge(['select' => array('transaksi_id')]);
        $list_transaksi_kas = $this->transaksiDetail->search($request)
            ->pluck('transaksi_id')->toArray();

        return $this->transaksiDetail->search(new Request([
            'transaksi_id_in' => $list_transaksi_kas,
            'akun_id_not' => $akun_kas->id,
            'group_by' => array('akun_id'),
            'select' => array(
                'akun_id',
                DB::raw('sum(debit) as total_debit'),
                DB::raw('sum(kredit) as total_kredit')
            )
        ]));
    }

    public function laba_rugi(Request $request)
    {
        $pendapatan = $this->transaksi_akun($request, '04');
        $pengeluaran = $this->transaksi_akun($request, '05');

        return $pendapatan->sum('total_debit') - $pengeluaran->sum('total_debit');
    }
}
