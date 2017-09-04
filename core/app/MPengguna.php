<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 9:59 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MPengguna extends Model
{
    //
    protected $table = 'pengguna';

    public function index()
    {
        $pengguna = Pengguna::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}