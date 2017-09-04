<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 9:59 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MTopikKuota extends Model
{
    //
    protected $table = 'topik_kuota';

    public function index()
    {
        $pengguna = Topik_Kuota::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }


}