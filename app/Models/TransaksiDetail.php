<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';
    protected $fillable = [
        'transaksi_id',
        'akun_id',
        'debit',
        'kredit'
    ];
    protected $with = ['akun'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id', 'id');
    }
}
