<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 9:59 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MProdiUniversitas extends Model
{
    //
    protected $table = 'prodi_universitas';

    public function index()
    {
        $pengguna = Prodi_Universitas::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}