<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 9:59 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MTahunAktifTopik extends Model
{
    //
    protected $table = 'tahun_aktif_topik';

    public function index()
    {
        $tahun_aktif_topik = TahunAktifTopik::all();

        return view('layouts.index', ['flights' => $tahun_aktif_topik]);
    }


}