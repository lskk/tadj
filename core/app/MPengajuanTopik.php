<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MPengajuanTopik extends Model
{
    //
    protected $table = 'pengajuan_topik';

    public function index()
    {
        $informasi = Pengajuan_Topik::all();

        return view('layouts.index', ['flights' => $informasi]);
    }
}