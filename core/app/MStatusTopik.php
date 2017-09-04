<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 9:59 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MStatusTopik extends Model
{
    //
    protected $table = 'status_topik';

    public function index()
    {
        $pengguna = Status_Topik::all();

        return view('layouts.index', ['flights' => $pengguna]);
    }
}
/**
 * Created by PhpStorm.
 * User: imachine_bdg
 * Date: 1/11/16
 * Time: 12:52 PM
 */