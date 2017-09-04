<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MTopikUniversitas extends Model
{
    //
    protected $table = 'topik_universitas';

    public function index()
    {
        $pengguna = Topik_Universitas::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}