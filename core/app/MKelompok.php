<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MKelompok extends Model
{
    //
    protected $table = 'kelompok';

    public function index()
    {
        $pengguna = Kelompok::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}