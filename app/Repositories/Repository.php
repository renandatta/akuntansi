<?php

namespace App\Repositories;

class Repository
{
    public function auto_kode($model, $parent_kode = '#')
    {
        $last_row = $model
            ->where('parent_kode', $parent_kode)
            ->orderBy('kode', 'desc')
            ->first();
        $kode = '01';
        if (!empty($last_row)) {
            $temp = explode(".", $last_row->kode);
            $kode = intval(end($temp))+1;
            if (strlen($kode) == 1) $kode = "0$kode" ;
        }
        return $parent_kode == '#' ? $kode : "$parent_kode.$kode";
    }
}
