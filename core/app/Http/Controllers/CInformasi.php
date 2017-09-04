<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MInformasi;
use App\MPengajuanTopik;
use App\MTahunAktifTopik;
use App\MPembimbing;
use App\MTopikProdi;
use App\MTopikKuota;
use App\MSemesterTopik;
use DB;
use Session;
use App\MPengguna;
use Illuminate\Support\Facades\Redirect;

class CInformasi extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int $id
     * @return Response
     */
    public function index()
    {
        //ambil informasi berdasarkan status pengguna yang masuk ke sistem
        if(Session::get('status')==3){//dosen
            $ambil_informasi = DB::table('informasi')
                ->take(5)//limit
                ->select('*','pengguna.nama as nama_pengguna','informasi.created_at as pembuatan_informasi')
                ->join('pengajuan_topik','informasi.id_tipe_informasi','=','pengajuan_topik.id')
                ->join('universitas','pengajuan_topik.id_universitas_tujuan','=','universitas.id')//ambil nama universitas
                ->join('pengguna','universitas.id_pengguna','=','pengguna.id')//ambil nama universitas
                ->where('pengajuan_topik.id_dosen_pengusul','=',Session::get('id'))
                ->orderBy('informasi.created_at', 'desc')
                ->get();
        }else if(Session::get('status')==2){//universitas
            $ambil_informasi = DB::table('informasi')
                ->take(5)//limit
                ->select('*','pengguna.nama as nama_pengguna','informasi.created_at as pembuatan_informasi')
                ->join('pengajuan_topik','informasi.id_tipe_informasi','=','pengajuan_topik.id')
                ->join('universitas','pengajuan_topik.id_universitas_tujuan','=','universitas.id')//ambil nama universitas
                ->join('pengguna','universitas.id_pengguna','=','pengguna.id')//ambil nama universitas
                ->where('pengajuan_topik.id_universitas_tujuan','=',Session::get('id_pengguna_universitas'))
                ->orderBy('informasi.created_at', 'desc')
                ->get();
        }else if(Session::get('status')==4){//mahasiswa
            $ambil_url_blog = DB::table('blog')
                ->select('url_blog')
                ->where('id_mahasiswa','=',Session::get('id_pengguna_mahasiswa'))
                ->get();

            return view("layouts.dashboard")->with('url_blog', $ambil_url_blog);;

        }else{
            return view("layouts.dashboard");
        }
        /*$ambil nama_universitas = DB::table('pengguna')
                                  ->select('*')
                                  ->join('universitas','pengguna.id')*/
        return view("layouts.dashboard")
            ->with('informasi', $ambil_informasi);
    }

    public function masuk()
    {
        //ambil nama universitas
        $nama_universitas = DB::table('pengguna')
            ->select('pengguna.nama as nama')
            ->join('universitas','pengguna.id','=','universitas.id_pengguna')
            ->where('universitas.id','=',Session::get('id_universitas'))
            ->get();

        $fix_nama_universitas = null;
        foreach ($nama_universitas as $n) {
            $fix_nama_universitas = $n->nama;
        }

        //cek apakah topik sudah pernah diajukan, apabila sudah hanya menambahkan ditabel informasi saja
        $cek_pengajuan = DB::table('pengajuan_topik')
            ->where('id_topik','=',$_POST['id'])
            ->where('id_universitas_tujuan','=',$_POST['universitas'])
            ->count();

        if($cek_pengajuan == 0){//belum ada
            //masuk ke pengajuan topik
            $pengajuan_topik = new MPengajuanTopik();
            $pengajuan_topik->id_dosen_pengusul = Session::get('id');
            $pengajuan_topik->id_universitas_tujuan = $_POST['universitas'];
            $pengajuan_topik->id_topik = $_POST['id'];
            $pengajuan_topik->deskripsi = Session::get('nama')." dari ".$fix_nama_universitas." telah mengusulkan topik tugas akhir berjudul ".$_POST['judul'].".";;
            $pengajuan_topik->save();

            //masuk ke tabel informasi
            $informasi = new MInformasi();
            //mengambil id terakhir pengajuan topik
            $ambil_id_terakhir_pengajuan_topik = DB::table('pengajuan_topik')
                ->select('id')
                ->take(1)
                ->orderBy('id', 'desc')
                ->get();

            $final_ambil_id_terakhir = null;
            foreach($ambil_id_terakhir_pengajuan_topik as $aitpj){
                $final_ambil_id_terakhir = $aitpj->id;
            }
            $informasi->id_tipe_informasi = $final_ambil_id_terakhir;
            $informasi->tipe = 1;//tipe pengusulan topik oleh dosen
            $informasi->save();

            //masuk ke tabel tahun aktif topik
            $tahun_aktif_topik = new MTahunAktifTopik();
            $tahun_aktif_topik->id_universitas = $_POST['universitas'];
            $tahun_aktif_topik->id_topik = $_POST['id'];
            $tahun_aktif_topik->tahun_ajaran = 0;
            $tahun_aktif_topik->save();

			//masuk ke tabel topik semester
			$semester_topik = new MSemesterTopik();
			$semester_topik->id_universitas = $_POST['universitas'];
            $semester_topik->id_topik = $_POST['id'];
            $semester_topik->id_semester = 0;
			$semester_topik->save();

            //masuk ke tabel pembimbing
            $pembimbing = new MPembimbing();
            $pembimbing->id_universitas = $_POST['universitas'];
            $pembimbing->id_topik = $_POST['id'];
            if($_POST['universitas'] == Session::get('id_universitas')){//menjadi dosen utama apabila mengusulkan topik ke universitas asal
                $pembimbing->id_dosen = Session::get('id');
                $pembimbing->pembimbing_ke = 1;
            }
            $pembimbing->save();

            //masuk ke tabel topik prodi
            $topik_prodi = new MTopikProdi();
            $topik_prodi->id_universitas = $_POST['universitas'];
            $topik_prodi->id_topik = $_POST['id'];
            $topik_prodi->id_prodi = 0;
            $topik_prodi->save();

            //masuk ke tabel topik kuota
            $topik_kuota = new MTopikKuota();
            $topik_kuota->id_topik = $_POST['id'];
            $topik_kuota->id_universitas = $_POST['universitas'];
            $topik_kuota->jumlah = 0;
            $topik_kuota->save();

        }else{//sudah ada
            //ambil id yang id topiknya sama dengan yang sudah masuk
            $pengajuan_topik = DB::table('pengajuan_topik')
                ->select('id as id_pengajuan_topik')
                ->where('pengajuan_topik.id_topik','=',$_POST['id'])
                ->get();

            $final_id_pengajuan_topik = null;
            foreach($pengajuan_topik as $pt){
                $final_id_pengajuan_topik = $pt->id_pengajuan_topik;
            }

            //masuk ke tabel informasi
            $informasi = new MInformasi();
            $informasi->id_tipe_informasi = $final_id_pengajuan_topik;
            $informasi->tipe = 1;//tipe pengusulan topik oleh dosen
            $informasi->save();
        }

        return Redirect::to('dashboard');
    }

}
