<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MKelompokTopikTugasAkhir extends Model
{
    //
    protected $table = 'kelompok_topik_tugas_akhir';

    public function index()
    {
        $pengguna = Kelompok_Topik_Tugas_Akhir::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}