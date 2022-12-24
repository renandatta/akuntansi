<?php

namespace App\Http\Controllers;

use App\Repositories\AkunRepository;
use App\Repositories\TransaksiDetailRepository;
use App\Repositories\TransaksiRepository;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    protected $transaksi, $transaksiDetail, $akun;
    public function __construct(TransaksiRepository $transaksi,
                                TransaksiDetailRepository $transaksiDetail,
                                AkunRepository $akun)
    {
        $this->middleware(['fitur_program']);
        view()->share(['title' => 'Transaksi']);
        $this->transaksi = $transaksi;
        $this->transaksiDetail = $transaksiDetail;
        $this->akun = $akun;
    }

    public function index()
    {
        return view('transaksi.index');
    }

    public function search(Request $request)
    {
        $transaksi = $this->transaksi->search($request);
        if ($request->has('ajax')) return $transaksi;
        return view('transaksi._table', compact('transaksi'));
    }

    public function search_detail(Request $request)
    {
        $transaksi_id = $request->input('transaksi_id');
        $transaksi_detail = $this->transaksiDetail->search($request);
        if ($request->has('ajax')) return $transaksi_detail;
        $list_akun = $this->akun->search(new Request([]));
        foreach ($list_akun as $value) {
            $value->nama = $value->kode . ' - ' . $value->nama;
        }
        $list_akun = $list_akun->pluck('nama', 'id')->toArray();
        return view('transaksi._table_detail', compact('transaksi_detail', 'list_akun', 'transaksi_id'));
    }

    public function info(Request $request)
    {
        $transaksi = $this->transaksi->find($request->input('id'));
        $no_transaksi = !empty($transaksi) ? $transaksi->no_transaksi : $this->transaksi->auto_nomor();
        if ($request->has('ajax')) return $transaksi;
        return view('transaksi._info', compact('transaksi', 'no_transaksi'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'no_transaksi' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required'
        ]);
        return $this->transaksi->save($request);
    }

    public function save_detail(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required',
            'akun_id' => 'required',
        ]);
        return $this->transaksiDetail->save($request);
    }

    public function delete(Request $request)
    {
        return $this->transaksi->delete($request->input('id'));
    }

    public function delete_detail(Request $request)
    {
        return $this->transaksiDetail->delete($request->input('id'));
    }
}
