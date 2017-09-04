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

class CRekapitulasi extends Controller
{
    public function index()
    {        
		$prodi = DB::table('prodi_universitas')
				->select('prodi.detail_prodi as detail_prodi','prodi.id as id_prodi')
				->join('prodi','prodi.id','=','prodi_universitas.id_prodi')	
				->where('prodi_universitas.id_universitas','=',Session::get('id_universitas'))
				->orderBy('prodi.detail_prodi','asc')
				->get();
				
		$tahun_ajaran = DB::table('topik_universitas')
				->select('tahun_ajaran')
				->where('id_universitas','=',Session::get('id_universitas'))
				->orderBy('tahun_ajaran','asc')
				->distinct()
				->get();
		
		$judul_universitas = DB::table('topik_universitas')
				->select('kelompok.no_kelompok as no_kelompok','topik.judul as judul')
				->join('kelompok','kelompok.id','=','topik_universitas.id_kelompok')	
				->join('topik','topik.id','=','topik_universitas.id_topik')	
				->where('topik_universitas.id_universitas','=',Session::get('id_universitas'))
				->orderBy('kelompok.no_kelompok','asc')
				->get();		
		
        return view('layouts.rekapitulasi.index')
					->with('prodi',$prodi)
					->with('tahun_ajaran',$tahun_ajaran)
					->with('judul_universitas',$judul_universitas);
    }
	
	 public function filter()
    {        
		$prodi = DB::table('prodi_universitas')
				->select('prodi.detail_prodi as detail_prodi','prodi.id as id_prodi')
				->join('prodi','prodi.id','=','prodi_universitas.id_prodi')	
				->where('prodi_universitas.id_universitas','=',Session::get('id_universitas'))
				->orderBy('prodi.detail_prodi','asc')
				->get();
				
		$tahun_ajaran = DB::table('topik_universitas')
				->select('tahun_ajaran')
				->where('id_universitas','=',Session::get('id_universitas'))
				->orderBy('tahun_ajaran','asc')
				->distinct()
				->get();
		
		$judul_universitas = DB::table('topik_universitas')
				->select('kelompok.no_kelompok as no_kelompok','topik.judul as judul')
				->join('kelompok','kelompok.id','=','topik_universitas.id_kelompok')	
				->join('topik','topik.id','=','topik_universitas.id_topik')	
				->where('topik_universitas.id_universitas','=',Session::get('id_universitas'))
				->where('topik_universitas.id_prodi','LIKE','%'.$_POST['prodi'].'%')
				->where('topik_universitas.tahun_ajaran','LIKE','%'.$_POST['tahun_ajaran'].'%')
				->where('topik_universitas.id_semester','LIKE','%'.$_POST['semester'].'%')
				->orderBy('kelompok.no_kelompok','asc')
				->get();		
		
        return view('layouts.rekapitulasi.index')
					->with('prodi',$prodi)
					->with('tahun_ajaran',$tahun_ajaran)
					->with('judul_universitas',$judul_universitas);
    }
	
	public function universitas()
    {        
		$prodi = DB::table('prodi_universitas')
				->select('prodi.detail_prodi as detail_prodi','prodi.id as id_prodi')
				->join('prodi','prodi.id','=','prodi_universitas.id_prodi')	
				->where('prodi_universitas.id_universitas','=',Session::get('id_pengguna_universitas'))
				->orderBy('prodi.detail_prodi','asc')
				->get();
				
		$tahun_ajaran = DB::table('topik_universitas')
				->select('tahun_ajaran')
				->where('id_universitas','=',Session::get('id_pengguna_universitas'))
				->orderBy('tahun_ajaran','asc')
				->distinct()
				->get();
		
		$judul_universitas = DB::table('topik_universitas')
				->select('kelompok.no_kelompok as no_kelompok','topik.judul as judul')
				->join('kelompok','kelompok.id','=','topik_universitas.id_kelompok')	
				->join('topik','topik.id','=','topik_universitas.id_topik')	
				->where('topik_universitas.id_universitas','=',Session::get('id_pengguna_universitas'))
				->orderBy('kelompok.no_kelompok','asc')
				->get();		
		
        return view('layouts.rekapitulasi.index')
					->with('prodi',$prodi)
					->with('tahun_ajaran',$tahun_ajaran)
					->with('judul_universitas',$judul_universitas);
    }
	
}