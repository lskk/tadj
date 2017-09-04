<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MTopikProdi extends Model
{
    //
    protected $table = 'topik_prodi';

    public function index()
    {
        $pengguna = Topik_Prodi::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}