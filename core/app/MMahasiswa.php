<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MMahasiswa extends Model
{
    //
    protected $table = 'mahasiswa';

    public function index()
    {
        $pengguna = Mahasiswa::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}