<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MKelompokTopik extends Model
{
    //
    protected $table = 'kelompok_topik';

    public function index()
    {
        $pengguna = Kelompok_Topik::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}