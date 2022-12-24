<?php

namespace App\Repositories;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AkunRepository extends Repository
{
    protected $akun;
    public function __construct(Akun $akun)
    {
        $this->akun = $akun;
    }

    public function search(Request $request)
    {
        $akun = $this->akun->orderBy('kode');

        $id_in = $request->input('id_in');
        if ($id_in != '')
            $akun = $akun->whereIn('id', $id_in);

        $nama = $request->input('nama');
        if ($nama != '')
            $akun = $akun->where('nama', 'like', "%$nama%");

        $parent_kode = $request->input('parent_kode');
        if ($parent_kode != '')
            $akun = $akun->where('parent_kode', 'like', "$parent_kode%");

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $akun->paginate($paginate);
        return $akun->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->akun->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $id = $request->input('id') ?? '';
        if ($id == '') {
            $akun = $this->akun->create($request->all());
        } else {
            $akun = $this->akun->find($id);
            $akun->update($request->all());
        }
        return $akun;
    }

    public function delete($id)
    {
        $akun = $this->akun->find($id);
        if (!empty($akun)) $akun->delete();
        return $akun;
    }

    protected $skip = array();
    public function nested_data($data, $parent_kode = '#')
    {
        $result = array();
        foreach ($data as $item) {
            if (!in_array($item->id, $this->skip) && $item->parent_kode == $parent_kode) {
                array_push($this->skip, $item->id);
                $item->children = $this->nested_data($data, $item->kode);
                array_push($result, $item);
            }
        }
        return $result;
    }

    public function kode($parent_kode)
    {
        return $this->auto_kode($this->akun, $parent_kode);
    }

    public function reposisi(Request $request)
    {
        $fitur = $this->akun->find($request->input('id'));
        $kode_asal = $fitur->kode;
        $kode_array = explode(".", $fitur->kode);
        $kode = $kode_array[count($kode_array)-1];
        $kode_tujuan = $request->input('arah') == 'up' ? intval($kode) - 1 : intval($kode) + 1;
        if (strlen($kode_tujuan) == 1) $kode_tujuan = '0' . $kode_tujuan;
        if ($fitur->parent_kode != '#') $kode_tujuan = $fitur->parent_kode. '.' .$kode_tujuan;
        $fitur_tujuan = $this->akun->where('kode', '=', $kode_tujuan)->first();

        if (!empty($fitur_tujuan)) {
            $temp_kode = mt_rand(111,999);

            //=====tujuan pindah ke temp
            $this->swap_kode($kode_tujuan, $temp_kode);

            //=====asal pindah ke tujuan
            $this->swap_kode($kode_asal, $kode_tujuan);

            //=====temp pindah ke asal
            $this->swap_kode($temp_kode, $kode_asal);
        }
        return $fitur;
    }

    public function swap_kode($kode_asal, $kode_tujuan)
    {
        $this->akun->where('kode', "$kode_asal")->update(['kode' => "$kode_tujuan"]);
        if ($this->akun->where('parent_kode', "$kode_asal")->count() > 0)
            $this->akun->where('parent_kode', "$kode_asal")
                ->update([
                    'kode' => DB::raw("replace(kode, parent_kode, '". (string) $kode_tujuan ."')"),
                    'parent_kode' => "$kode_tujuan"
                ]);
    }
}
