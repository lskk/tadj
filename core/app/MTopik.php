<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 9:59 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MTopik extends Model
{
    //
    protected $table = 'topik';

    public function index()
    {
        $pengguna = Topik::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }


}