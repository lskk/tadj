<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MUniversitas extends Model
{
    //
    protected $table = 'universitas';

    public function index()
    {
        $pengguna = Universitas::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}