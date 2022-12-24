<?php

namespace App\Repositories;

use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiDetailRepository
{
    protected $transaksiDetail;
    public function __construct(TransaksiDetail $transaksiDetail)
    {
        $this->transaksiDetail = $transaksiDetail;
    }

    public function search(Request $request)
    {
        $transaksiDetail = $this->transaksiDetail;

        $with = $request->input('with') ?? '';
        if ($with != '')
            $transaksiDetail = $transaksiDetail->with($with);

        $select = $request->input('select') ?? '';
        if ($select != '')
            $transaksiDetail = $transaksiDetail->select($select);

        $transaksi_id = $request->input('transaksi_id');
        if ($transaksi_id != '')
            $transaksiDetail = $transaksiDetail->where('transaksi_id', $transaksi_id);

        $transaksi_id_in = $request->input('transaksi_id_in');
        if ($transaksi_id_in != '')
            $transaksiDetail = $transaksiDetail->whereIn('transaksi_id', $transaksi_id_in);

        $akun_id = $request->input('akun_id');
        if ($akun_id != '')
            $transaksiDetail = $transaksiDetail->where('akun_id', $akun_id);

        $akun_id_not = $request->input('akun_id_not');
        if ($akun_id_not != '')
            $transaksiDetail = $transaksiDetail->where('akun_id', '<>', $akun_id_not);

        $tanggal = $request->input('tanggal');
        if ($tanggal != '')
            $transaksiDetail = $transaksiDetail->whereHas('detail', function ($q) use ($tanggal) {
                $q->where('tanggal', $tanggal);
            });

        $tanggal_mulai = $request->input('tanggal_mulai') ?? '';
        $tanggal_sampai = $request->input('tanggal_sampai') ?? '';
        $order_tanggal = $request->input('order_tanggal') ?? '';
        if ($tanggal_mulai != '' || $tanggal_sampai != '' || $order_tanggal != '')
            $transaksiDetail = $transaksiDetail
                ->whereHas('transaksi', function ($q) use ($tanggal_mulai, $tanggal_sampai, $order_tanggal) {
                    if ($tanggal_mulai != '') $q->where('tanggal', '>=', unformat_date($tanggal_mulai));
                    if ($tanggal_sampai != '') $q->where('tanggal', '<=', unformat_date($tanggal_sampai));
                    if ($order_tanggal != '') $q->orderBy('tanggal', $order_tanggal);
            });

        $kode_like = $request->input('kode_like');
        if ($kode_like != '')
            $transaksiDetail = $transaksiDetail->whereHas('akun', function ($q) use ($kode_like) {
                $q->where('kode', 'like', "$kode_like%");
            });

        $group_by = $request->input('group_by');
        if ($group_by != '')
            foreach ($group_by as $item)
                $transaksiDetail = $transaksiDetail->groupBy($item);

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $transaksiDetail->paginate($paginate);
        return $transaksiDetail->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->transaksiDetail->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request->merge(['debit' => unformat_number($request->input('debit'))]);
        $request->merge(['kredit' => unformat_number($request->input('kredit'))]);
        $id = $request->input('id') ?? '';
        if ($id == '') {
            $transaksiDetail = $this->transaksiDetail->create($request->all());
        } else {
            $transaksiDetail = $this->transaksiDetail->find($id);
            $transaksiDetail->update($request->all());
        }
        return $transaksiDetail;
    }

    public function delete($id)
    {
        $transaksiDetail = $this->transaksiDetail->find($id);
        if (!empty($transaksiDetail)) $transaksiDetail->delete();
        return $transaksiDetail;
    }
}
