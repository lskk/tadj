<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MKelompok;
use App\MKelompokMahasiswa;
use App\MPengguna;
use DB;
use Illuminate\Support\Facades\Redirect;
use Input;
use Session;

class CDosen extends Controller
{
    public function index()
    {
        $dosen = DB::table('pengguna')
            ->select('*', 'dosen.id as id_dosen')
            ->join('dosen', 'pengguna.id', '=', 'dosen.id_pengguna')
            ->where('status', '=', '3')
            ->where('pengguna.id_universitas', '=', Session::get('id_pengguna_universitas'))
            ->get();

        return view('layouts.pengguna.dosen')
            ->with('dosen', $dosen);
    }

    public function proses_konfirmasi()
    {
        DB::table('dosen')
            ->where('id', $_POST['id_dosen'])
            ->update(['status_konfirmasi' => '1']);

        return Redirect::to('dosen');
    }

    public function unggah_ktp()
    {
        //ubah nama berkas
        $milliseconds = round(microtime(true) * 1000);
        $rename_berkas_ktm = $milliseconds . '.' . Input::file('ktm')->getClientOriginalExtension();

        $path = 'core/resources/assets/image/ktp/';
        Input::file('ktm')->move($path, $rename_berkas_ktm);

        DB::table('pengguna')
            ->where('id', Session::get('id_pengguna'))
            ->update(['photo_url' => 'core/resources/assets/image/ktp/' . $rename_berkas_ktm]);

        return Redirect::to('topik');
    }
}