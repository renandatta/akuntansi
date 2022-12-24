<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'no_transaksi',
        'tanggal',
        'keterangan',
    ];

    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id', 'id');
    }

    public function getNominalAttribute()
    {
        $debit = $this->detail()->sum('debit');
        $kredit = $this->detail()->sum('kredit');
        return ($debit > $kredit) ? $debit : $kredit;
    }
}
