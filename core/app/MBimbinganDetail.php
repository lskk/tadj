<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MBimbinganDetail extends Model
{
    //
    protected $table = 'bimbingan_detail';

    public function index()
    {
        $pengguna = Bimbingan_Detail::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}