<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MInformasi extends Model
{
    //
    protected $table = 'informasi';

    public function index()
    {
        $informasi = Informasi::all();

        return view('layouts.index', ['flights' => $informasi]);
    }
}