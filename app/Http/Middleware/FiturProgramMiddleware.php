<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FiturProgramMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $fitur_program = array(
            ['url' => '/', 'nama' => 'Home', 'children' => []],
            ['url' => 'akun', 'nama' => 'Akun', 'children' => []],
            ['url' => 'transaksi', 'nama' => 'Transaksi', 'children' => []],
            ['url' => 'jurnal', 'nama' => 'Jurnal', 'children' => []],
            ['url' => 'buku_besar', 'nama' => 'Buku Besar', 'children' => []],
            ['url' => 'arus_kas', 'nama' => 'Arus Kas', 'children' => []],
            ['url' => 'laba_rugi', 'nama' => 'Laba-Rugi', 'children' => []],
            ['url' => 'neraca', 'nama' => 'Neraca', 'children' => []],
        );
        view()->share(['fitur_program' => $fitur_program]);
        return $next($request);
    }
}
