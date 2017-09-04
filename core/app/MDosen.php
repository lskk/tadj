<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MDosen extends Model
{
    //
    protected $table = 'dosen';

    public function index()
    {
        $pengguna = Pengguna::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}