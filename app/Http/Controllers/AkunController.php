<?php

namespace App\Http\Controllers;

use App\Repositories\AkunRepository;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    protected $akun;
    public function __construct(AkunRepository $akun)
    {
        $this->middleware(['fitur_program']);
        view()->share(['title' => 'Akun']);
        $this->akun = $akun;
    }

    public function index()
    {
        return view('akun.index');
    }

    public function search(Request $request)
    {
        $parent_kode = $request->input('parent_kode') ?? '#';
        $akun = $this->akun->search($request);
        foreach ($akun as $key => $value) {
            $akun[$key]->text = $value->kode . ' - ' . $value->nama;
        }
        $akun = $this->akun->nested_data($akun, $parent_kode);
        if ($request->has('ajax')) return $akun;
        return view('akun._treeview', compact('akun'));
    }

    public function info(Request $request)
    {
        $id = $request->input('id') ?? null;
        $parent_kode = $request->input('parent_kode') ?? '#';
        $is_child = $request->has('parent_kode');

        $akun = $this->akun->find($id);
        $parent_kode = !empty($akun) ? $akun->parent_kode : $parent_kode;
        $kode = !empty($akun) ? $akun->kode : $this->akun->kode($parent_kode);

        $parent = $this->akun->find($parent_kode, 'kode');

        if ($request->has('ajax')) return $akun;
        return view('akun._info', compact(
            'akun', 'kode', 'parent_kode', 'is_child', 'parent'
        ));
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required',
            'parent_kode' => 'required',
        ]);

        return $this->akun->save($request);
    }

    public function delete(Request $request)
    {
        $request->validate(['id' => 'required']);
        $id = $request->input('id') ?? null;
        return $this->akun->delete($id);
    }

    public function reposisi(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'arah' => 'required'
        ]);

        return $this->akun->reposisi($request);
    }
}
