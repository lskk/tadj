<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MKelompok;
use App\MProdiUniversitas;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;

class CProdi extends Controller
{
    public function index()
    {
        $prodi = DB::table('prodi')
            ->select('prodi.id','prodi.detail_prodi')
            ->where('prodi.id','!=',0)
            ->orderBy('prodi.detail_prodi','asc')
            ->get();

        $prodi_universitas = DB::table('prodi_universitas')
            ->join('prodi','prodi_universitas.id_prodi','=','prodi.id')
            ->where('id_universitas', '=', Session::get('id_pengguna_universitas'))
            ->get();

        return view('layouts.prodi.index')
            ->with('prodi',$prodi)
            ->with('prodi_universitas', $prodi_universitas);

        return $prodi;
    }

    public function tambah_prodi_universitas(){
        $prodi_universitas = new MProdiUniversitas();
        $prodi_universitas->id_universitas = Session::get('id_pengguna_universitas');
        $prodi_universitas->id_prodi = $_POST['prodi'];
        $prodi_universitas->save();

        return Redirect::to('prodi');
    }
}