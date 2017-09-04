<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MKelompok;
use App\MKelompokTopikTugasAkhir;
use App\MTopikUniversitas;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;

class CKelompok extends Controller
{
    public function index()
    {
        //untuk select kuota
        $kuota = DB::table('kuota')
            ->where('id', '!=', 0)
            ->get();

        //untuk menampilkan kelompok berdasarkan universitas
        $kelompok = DB::table('kelompok')
        ->where('id_universitas','=',Session::get('id_pengguna_universitas'))
        ->get();
		
		$tahun_ajaran = DB::table('kelompok')
		->select('tahun_ajaran')
        ->where('id_universitas','=',Session::get('id_pengguna_universitas'))
		->orderBy('tahun_ajaran','asc')
		->distinct()
        ->get();
			
        //ambil prodi universitas
        $prodi_universitas = DB::table('prodi')
            ->join('prodi_universitas','prodi.id','=','prodi_universitas.id_prodi')
            ->where('prodi_universitas.id_universitas','=',Session::get('id_pengguna_universitas'))
            ->orderBy('prodi.detail_prodi','asc')
            ->get();

        //ambil tahun
        $tahun = DB::table('tahun')
                            ->where('id','!=','0')
                            ->orderBy('detail_tahun','asc')
                            ->get();

        //semester
        $semester = DB::table('semester')
			->take(2)
			->orderBy('detail_semester','asc')
            ->get();
		
				
        return view('layouts.kelompok.index')
            ->with('tahun_mulai', $tahun)
            ->with('semester', $semester)
            ->with('tahun_selesai', $tahun)
            ->with('prodi_universitas', $prodi_universitas)
			->with('prodi_universitas2', $prodi_universitas)
            ->with('kelompok', $kelompok)
			->with('tahun_ajaran', $tahun_ajaran)
            ->with('kuota', $kuota);
    }
	
	public function tampilkan_semua(){
		$prodi_universitas = DB::table('prodi')
            ->join('prodi_universitas', 'prodi.id', '=', 'prodi_universitas.id_prodi')
            ->get();

        $jenjang = DB::table('jenjang')
            ->get();

        $tahun_ajaran = DB::table('kelompok')
            ->select('tahun_ajaran')
            ->where('id_universitas', '=', Session::get('id_universitas'))
            ->distinct()
            ->orderBy('tahun_ajaran', 'asc')
            ->get();

        $mahasiswa = DB::table('mahasiswa')
            ->where('id', '=', Session::get('id_pengguna_mahasiswa'))
            ->get();

        $kelompok = DB::table('kelompok')
            ->where('id_universitas', '=', Session::get('id_universitas'))			
            ->get();
       
        return view('layouts.kelompok.tampilkan_semua')           
            ->with('kelompok', $kelompok)
            ->with('prodi', $prodi_universitas)
            ->with('jenjang', $jenjang)
            ->with('tahun_ajaran', $tahun_ajaran)
            ->with('mahasiswa2', $mahasiswa);
	}
	
    public function tambah_kelompok()
    {
        $kelompok = new MKelompok();
        //menentukan no kelompok
        $temp_no_kelompok = Session::get('nama');
        $explode_temp_no_kelompok = explode(' ', $temp_no_kelompok);

        //ambil perhuruf untuk no kelompok
        $no_kelompok = null;
        $num_explode = count($explode_temp_no_kelompok);
        for ($a = 0; $a < $num_explode; $a++) {
            $no_kelompok .= substr($explode_temp_no_kelompok[$a],0,1);
        }

        //penentu nama singkatan prodi
        $prodi = explode('.',$_POST['prodi']);
        $id_prodi = $prodi[0];
        $singkatan = $prodi[1];

        //penentu no kelompok untuk no ajaran
        $tahun_mulai = substr($_POST['tahun_mulai'],2);
        $tahun_selesai = substr($_POST['tahun_selesai'],2);

        //penentu no kelompok per universitas dan prodi
        $penentu_no_kelompok = DB::table('kelompok')
            ->where('id_universitas','=',Session::get('id_pengguna_universitas'))
            ->where('id_prodi','=',$id_prodi)
			->where('id_semester','=',$_POST['semester'])
			->where('tahun_ajaran','=',$_POST['tahun_mulai'].'/'.$_POST['tahun_selesai'])
            ->count();

        $temp_count_kelompok = $penentu_no_kelompok + 1;
        $count_kelompok = null;
        if($temp_count_kelompok < 10){
            $count_kelompok = '00'.$temp_count_kelompok;
        }else if($temp_count_kelompok < 100){
            $count_kelompok = '0'.$temp_count_kelompok;
        }else{
            $count_kelompok = $temp_count_kelompok;
        }

        $kelompok->no_kelompok = 'TA'.$tahun_mulai.$tahun_selesai.'0'.$_POST['semester'].$count_kelompok;
        $kelompok->id_universitas = Session::get('id_pengguna_universitas');
        $kelompok->id_prodi = $id_prodi;
        $kelompok->id_semester = $_POST['semester'];
        $kelompok->id_kuota = $_POST['kuota'];
        $kelompok->tahun_ajaran = $_POST['tahun_mulai'].'/'.$_POST['tahun_selesai'];
        $kelompok->save();
		
		Session::flash('berhasil', 'Kelompok berhasil ditambahkan');
        return Redirect::to('kelompok');
    }

    public function ambil_topik(){
        //kelompok topik tugas akhir
        /*$kelompok_topik_tugas_akhir = new MKelompokTopikTugasAkhir();
        $kelompok_topik_tugas_akhir->id_kelompok = $_POST['kelompok'];
        $kelompok_topik_tugas_akhir->id_topik = $_POST['topik'];
        $kelompok_topik_tugas_akhir->save();

        //ubah id_kelompok di topik_universitas
        DB::table('topik_universitas')
            ->where('id_topik', $_POST['topik'])
            ->where('id_universitas', Session::get('id_universitas'))
            ->update(['id_kelompok' => $_POST['kelompok']]);

        return Redirect::to('mahasiswa/konfirmasi');*/
		
		//Dicek dahulu apakah judul masih tersedia secara back end
        $cek_topik_sudah_diambil = DB::table('kelompok_topik_tugas_akhir')
            ->join('kelompok_topik', 'kelompok_topik_tugas_akhir.id_topik', '=', 'kelompok_topik.id_topik')
            ->where('kelompok_topik.id_universitas', '=', Session::get('id_universitas'))
            ->where('kelompok_topik_tugas_akhir.id_topik', '=', $_POST['topik'])
            ->count();
        
        if($cek_topik_sudah_diambil == 0){
            //kelompok topik tugas akhir
            $kelompok_topik_tugas_akhir = new MKelompokTopikTugasAkhir();
            $kelompok_topik_tugas_akhir->id_kelompok = $_POST['kelompok'];
            $kelompok_topik_tugas_akhir->id_topik = $_POST['topik'];
            $kelompok_topik_tugas_akhir->save();

            //ubah id_kelompok di topik_universitas
            DB::table('topik_universitas')
                ->where('id_topik', $_POST['topik'])
                ->where('id_universitas', Session::get('id_universitas'))
                ->update(['id_kelompok' => $_POST['kelompok']]);

            return Redirect::to('mahasiswa/konfirmasi');    
        }else{
            Session::flash('gagal', 'Maaf, baru saja judul yang anda pilih telah diambil kelompok lain. Silahkan pilih judul yang lain.');
            return Redirect::to('mahasiswa/konfirmasi');
        }
    }
}