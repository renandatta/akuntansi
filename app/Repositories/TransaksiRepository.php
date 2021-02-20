<?php

namespace App\Repositories;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiRepository
{
    protected $transaksi;
    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function search(Request $request)
    {
        $transaksi = $this->transaksi;

        $order = $request->input('order');
        if ($order != '')
            $transaksi = $transaksi->orderBy('tanggal');
        else
            $transaksi = $transaksi->orderBy('id', 'desc');

        $no_transaksi = $request->input('no_transaksi');
        if ($no_transaksi != '')
            $transaksi = $transaksi->where('no_transaksi', 'like', "%$no_transaksi%");

        $tanggal = $request->input('tanggal');
        if ($tanggal != '')
            $transaksi = $transaksi->where('tanggal', unformat_date($tanggal));

        $tanggal_mulai = $request->input('tanggal_mulai') ?? '';
        if ($tanggal_mulai != '')
            $transaksi = $transaksi->where('tanggal', '>=', unformat_date($tanggal_mulai));

        $tanggal_sampai = $request->input('tanggal_sampai') ?? '';
        if ($tanggal_sampai != '')
            $transaksi = $transaksi->where('tanggal', '<=', unformat_date($tanggal_sampai));

        $keterangan = $request->input('keterangan');
        if ($keterangan != '')
            $transaksi = $transaksi->where('keterangan', 'like', "%$keterangan%");

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $transaksi->paginate($paginate);
        return $transaksi->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->transaksi->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request->merge(['tanggal' => unformat_date($request->input('tanggal'))]);
        $id = $request->input('id') ?? '';
        if ($id == '') {
            $transaksi = $this->transaksi->create($request->all());
        } else {
            $transaksi = $this->transaksi->find($id);
            $transaksi->update($request->all());
        }
        return $transaksi;
    }

    public function delete($id)
    {
        $transaksi = $this->transaksi->find($id);
        if (!empty($transaksi)) $transaksi->delete();
        return $transaksi;
    }

    public function auto_nomor()
    {
        $last_record = $this->transaksi->count()+1;
        for ($i = 1; (6-strlen($last_record)); $i++) $last_record = '0' . $last_record;
        return "SWI-" . $last_record;
    }
}
