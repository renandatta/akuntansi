<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = 'akun';
    protected $fillable = [
        'nama',
        'kode',
        'parent_kode'
    ];

    public function parent()
    {
        return $this->belongsTo(Akun::class, 'parent_kode', 'kode');
    }
}
