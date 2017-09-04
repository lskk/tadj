<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MMahasiswaKonfirmasi extends Model
{
    //
    protected $table = 'mahasiswa_konfirmasi';

    public function index()
    {
        $pengguna = Mahasiswa_Konfirmasi::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}