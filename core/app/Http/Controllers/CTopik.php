<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MDosen;
use App\MKelompokTopik;
use App\MPembimbing;
use App\MTahunAktifTopik;
use App\MTopik;
use App\MStatusTopik;
use App\MTopikUniversitas;
use DB;
use Session;
use Input;
use App\MPengguna;
use Illuminate\Support\Facades\Redirect;

class CTopik extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int $id
     * @return Response
     */
    public function index()
    {
        if (Session::get('status') == 2) {//pengguna sebagai universitas
            $topik = DB::table('topik')
                ->select('topik.id as id_topik','topik_kuota.jumlah as jumlah','tahun_aktif_topik.tahun_ajaran',
				'topik.no_topik','topik.judul','prodi.id as id_prodi','prodi.detail_prodi','status_topik.id_status','jenjang.id as id_jenjang','jenjang.detail_jenjang as jenjang','topik.deskripsi as deskripsi'
				,'jenjang.detail_jenjang as jenjang') //->select('*','topik.id as id_topik')
                ->join('tahun_aktif_topik', 'topik.id', '=', 'tahun_aktif_topik.id_topik')				
                ->join('pengajuan_topik', 'topik.id', '=', 'pengajuan_topik.id_topik')
                ->join('status_topik', 'topik.id', '=', 'status_topik.id_topik')				
                ->join('jenjang', 'topik.id_jenjang', '=', 'jenjang.id')
                ->join('status', 'status_topik.id_status', '=', 'status.id')
                ->join('topik_prodi', 'topik.id', '=', 'topik_prodi.id_topik')
                ->join('prodi', 'topik_prodi.id_prodi', '=', 'prodi.id')
                ->join('topik_kuota', 'topik.id', '=', 'topik_kuota.id_topik')				
                ->where('pengajuan_topik.id_universitas_tujuan', '=', Session::get('id_pengguna_universitas'))
                ->distinct()
                ->get();

            $topik_universitas = DB::table('topik')
                ->join('topik_universitas','topik.id','=','topik_universitas.id_topik')
                ->where('topik_universitas.id_universitas', '=', Session::get('id_pengguna_universitas'))
                ->get();

            $tahun = DB::table('tahun')
                ->get();

            $prodi = DB::table('prodi')
                ->join('prodi_universitas','prodi.id','=','prodi_universitas.id_prodi')
                ->orderBy('detail_prodi', 'asc')
                ->where('prodi_universitas.id_universitas','=', Session::get('id_pengguna_universitas'))
                ->get();

            $dosen = DB::table('dosen')
                ->select('dosen.id as id_dosen', 'pengguna.nama as nama_dosen','pengguna.nama_depan as nama_depan','pengguna.nama_belakang as nama_belakang')
                ->join('pengguna', 'dosen.id_pengguna', '=', 'pengguna.id')
                ->where('dosen.id_universitas', '=', Session::get('id_pengguna_universitas'))
                ->where('pengguna.status','=',3)
                ->where('dosen.status_konfirmasi','=',1)
                ->orderBy('pengguna.nama_depan', 'asc')
                ->get();

            $kuota = DB::table('kuota')
                ->select('*')
                ->get();

            return view('layouts.topik.index')
                ->with('tahun', $tahun)
                ->with('prodi', $prodi)
                ->with('dosen', $dosen)
                ->with('kuota', $kuota)
                ->with('topik', $topik)
                ->with('topik_universitas', $topik_universitas);

        } else if (Session::get('status') == 3) {//pengguna sebagai dosen

            $topik = DB::table('topik')
                ->select('*', 'topik.id', 'status.detail_status as status_topik','jenjang.detail_jenjang as jenjang')
                ->join('jenjang', 'topik.id_jenjang', '=', 'jenjang.id')
                ->join('status_topik', 'topik.id', '=', 'status_topik.id_topik')
                ->join('status', 'status_topik.id_status', '=', 'status.id')
                ->where('topik.id_dosen', '=', Session::get('id'))
                ->get();

            $tahun = DB::table('tahun')
                ->get();

            $jenjang = DB::table('jenjang')
                ->get();

            $status = DB::table('status')
                ->get();

            $universitas = DB::table('universitas')
                ->select('*', 'universitas.id as id_universitas')
                ->join('pengguna', 'universitas.id_pengguna', '=', 'pengguna.id')
                ->get();

            return view('layouts.topik.index')
                ->with('topik', $topik)
                ->with('tahun', $tahun)
                ->with('universitas', $universitas)
                ->with('status', $status)
                ->with('jenjang', $jenjang);
        }else if (Session::get('status') == 4){
            return view('layouts.topik.index');
        }
    }

    public function masuk()
    {
        $topik = new MTopik();
		
		
        //menentukan kode universitas
        $kode_universitas = NULL;
        $temp_kode_universitas = Session::get('id_universitas');
        if ($temp_kode_universitas < 10) {
            $kode_universitas = "0" . $temp_kode_universitas;
        } else {
            $kode_universitas = $temp_kode_universitas;
        }

        //menentukan kode topik
        $kode_topik = NULL;
        $hitung_topik_yang_sudah_ada = DB::table('topik')->count();
        $temp_kode_topik = $hitung_topik_yang_sudah_ada + 1;
        if ($temp_kode_topik < 10) {
            $kode_topik = "00" . $temp_kode_topik;
        } else if ($temp_kode_topik < 100) {
            $kode_topik = "0" . $temp_kode_topik;
        } else {
            $kode_topik = $temp_kode_topik;
        }


        //$topik->no_topik = 'T' . $kode_universitas . $kode_topik;
		
        $topik->judul = $_POST['judul'];
        $topik->id_jenjang = $_POST['jenjang'];
        $topik->id_dosen = Session::get('id');
        $topik->id_universitas = Session::get('id_universitas');
		
		if(Input::file('berkas') != null){//apabila ada berkas deskripsi								
				$rename_berkas = $this->random_string(50) . '.' . Input::file('berkas')->getClientOriginalExtension();
				$ftp_server = "167.205.7.228";
				$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				
				$login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

				if (true === $login) {
				   //ftp_put($ftp_conn,"/Assets/TADJ/poster/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_ASCII);
				   ftp_put($ftp_conn,"/Assets/TADJ/deskripsi_ta/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_BINARY);
				   ftp_close($ftp_conn); 
				   //return 'Success!';

				} else {
					ftp_close($ftp_conn);
					//return 'Failed login to FTP';

				}
				
				$topik->deskripsi = 'http://167.205.7.228:8089/tadj/deskripsi_ta/'.$rename_berkas;
		}
        

        $topik->save();

        //menentukan id topik
        $id_topik = NULL;
        $ambil_id_topik = DB::table('topik')
            ->select('id')
            ->take(1)
			->orderBy('id','desc')
            ->get();

        foreach ($ambil_id_topik as $a) {
            $id_topik = $a->id;
        }
        //masuk status topik
        $status_topik = new MStatusTopik();
        $status_topik->id_topik = $id_topik;
        $status_topik->id_status = 1;
        $status_topik->save();
		
		Session::flash("tambah","Berhasil menambahkan judul Tugas Akhir, dengan judul: ".$_POST['judul']."");
        return Redirect::to('topik');
    }

    public function ubah()
    {	
		if(Input::file('berkas') != null){//apabila ada berkas deskripsi								
				$rename_berkas = $this->random_string(50) . '.' . Input::file('berkas')->getClientOriginalExtension();
				$ftp_server = "167.205.7.228";
				$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				
				$login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

				if (true === $login) {
				   //ftp_put($ftp_conn,"/Assets/TADJ/poster/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_ASCII);
				   ftp_put($ftp_conn,"/Assets/TADJ/deskripsi_ta/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_BINARY);
				   ftp_close($ftp_conn); 
				   //return 'Success!';

				} else {
					ftp_close($ftp_conn);
					//return 'Failed login to FTP';

				}
				
			DB::table('topik')
            ->where('id', $_POST['id'])
            ->update(['judul' => $_POST['judul'], 'id_jenjang' => $_POST['jenjang'], 'deskripsi' => 'http://167.205.7.228:8089/tadj/deskripsi_ta/'.$rename_berkas]);	
		}else{
			DB::table('topik')
            ->where('id', $_POST['id'])
            ->update(['judul' => $_POST['judul'], 'id_jenjang' => $_POST['jenjang']]);
		}
		
		
		Session::flash("ubah","Berhasil ubah detail judul Tugas Akhir");
		
        return Redirect::to('topik');
    }

    public function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }
    
    public function perbaharui_alamat_blog(){
        
        DB::table('topik_universitas')
            ->where('id_universitas', Session::get('id_universitas'))
            ->where('id_kelompok', $_POST['kelompok'])
            ->update(['alamat_blog' => $_POST['url_blog']]);

        return Redirect::to('mahasiswa/konfirmasi');
    }
    
    public function unggah_poster_produk(){
        /*$nama_berkas_video = Input::file('poster')->getClientOriginalName();

        
        $rename_berkas_poster = $this->random_string(50) . '.' . Input::file('poster')->getClientOriginalExtension();

        $path = 'core/resources/assets/image/poster_produk/';
        Input::file('poster')->move($path, $rename_berkas_poster);*/
		
		$rename_berkas = $this->random_string(50) . '.' . Input::file('poster')->getClientOriginalExtension();

        $ftp_server = "167.205.7.228";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        
        $login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

        if (true === $login) {
           //ftp_put($ftp_conn,"/Assets/TADJ/poster/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_ASCII);
           ftp_put($ftp_conn,"/Assets/TADJ/poster/".$rename_berkas,Input::file('poster')->getPathName(), FTP_BINARY);
           ftp_close($ftp_conn); 
           //return 'Success!';

        } else {
            ftp_close($ftp_conn);
            //return 'Failed login to FTP';

        }

        DB::table('topik_universitas')
            ->where('id_universitas', Session::get('id_universitas'))
            ->where('id_kelompok', $_POST['kelompok'])
			->update(['lokasi_poster' => 'http://167.205.7.228:8089/tadj/poster/'.$rename_berkas.'']);
            //->update(['lokasi_poster' => $path.$rename_berkas_poster]);

        return Redirect::to('mahasiswa/konfirmasi');
    }

    public function unggah_video_produk(){
        $rename_berkas = $this->random_string(50) . '.' . Input::file('video')->getClientOriginalExtension();

        $ftp_server = "167.205.7.228";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        
        $login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

        if (true === $login) {
           //ftp_put($ftp_conn,"/Assets/TADJ/poster/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_ASCII);
           ftp_put($ftp_conn,"/Assets/TADJ/video/".$rename_berkas,Input::file('video')->getPathName(), FTP_BINARY);
           ftp_close($ftp_conn); 
           //return 'Success!';

        } else {
            ftp_close($ftp_conn);
            //return 'Failed login to FTP';

        }

        DB::table('topik_universitas')
            ->where('id_universitas', Session::get('id_universitas'))
            ->where('id_kelompok', $_POST['kelompok'])
			->update(['lokasi_video_produk' => 'http://167.205.7.228:8089/tadj/video/'.$rename_berkas.'']);
		
		/*$nama_berkas_video = Input::file('video')->getClientOriginalName();

        //ubah nama berkas
        $milliseconds = round(microtime(true) * 1000);
        $rename_berkas_video = $milliseconds . '.' . Input::file('video')->getClientOriginalExtension();

        $path = 'core/resources/assets/video/';
        Input::file('video')->move($path, $rename_berkas_video);

        DB::table('topik_universitas')
            ->where('id_universitas', Session::get('id_universitas'))
            ->where('id_kelompok', $_POST['kelompok'])
            ->update(['lokasi_video_produk' => $path.$rename_berkas_video]);*/

        return Redirect::to('mahasiswa/konfirmasi');
    }


    public function uploadtoftp(){
        $nama_berkas_video = Input::file('video')->getClientOriginalName();
        $conn_id = ftp_connect('tadj.lskk.ee.itb.ac.id');
        //ubah nama berkas
        $milliseconds = round(microtime(true) * 1000);
        $file=Input::file('video');
        $rename_berkas_video = $this->random_string(50) . '.' . Input::file('video')->getClientOriginalExtension();
        $remote_file = '/assetstadj/video/'.$rename_berkas_video;
        $login_result = ftp_login($conn_id, 'emilhamep', 'Fadillah!24');
        if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {

            DB::table('topik_universitas')
                ->where('id_universitas', Session::get('id_universitas'))
                ->where('id_kelompok', $_POST['kelompok'])
                ->update(['lokasi_video_produk' => $remote_file]);

            return Redirect::to('mahasiswa/konfirmasi');
        } else {
            echo "There was a problem while uploading $file\n";
        }

        $path = 'core/resources/assets/video/';
        Input::file('video')->move($path, $rename_berkas_video);
        DB::table('topik_universitas')
            ->where('id_universitas', Session::get('id_universitas'))
            ->where('id_kelompok', $_POST['kelompok'])
            ->update(['lokasi_video_produk' => $path.$rename_berkas_video]);

        return Redirect::to('mahasiswa/konfirmasi');

    }
    public function ubah_universitas()
    {
        $tahun_ajaran = $_POST['tahun_ajaran_awal'].'/'.$_POST['tahun_ajaran_akhir'];

        DB::table('topik_prodi')
			->where('id_universitas', $_POST['id_universitas'])
            ->where('id_topik', $_POST['id_topik'])
            ->update(['id_prodi' => $_POST['prodi']]);

        DB::table('tahun_aktif_topik')
			->where('id_universitas', $_POST['id_universitas'])
            ->where('id_topik', $_POST['id_topik'])
            ->update(['tahun_ajaran' => $tahun_ajaran]);
			
		DB::table('topik_semester')
			->where('id_universitas', $_POST['id_universitas'])
            ->where('id_topik', $_POST['id_topik'])
            ->update(['id_semester' => $_POST['semester']]);	

        DB::table('topik_kuota')
			->where('id_universitas', $_POST['id_universitas'])
            ->where('id_topik', $_POST['id_topik'])
            ->update(['jumlah' => $_POST['kuota']]);

        return Redirect::to('topik');
    }
	
	public function no_ta_ubah(){
		$a = DB::table('topik_universitas')
            ->where('id_topik', $_POST['id_topik'])
			->where('id_universitas', $_POST['id_universitas'])
            ->update(['no_ta' => $_POST['no_ta']]);
			
		return Redirect::to('topik');
	}
	
    public function pembimbing_tambah()
    {
        //ambil dosen pembimbing ke- terakhir yang ada di db
        $dosen_terakhir = DB::table('pembimbing')
            ->take(1)
            ->where('id_universitas','=',Session::get('id_pengguna_universitas'))
            ->where('id_topik','=',$_POST['id_topik'])
            ->orderBy('pembimbing_ke','desc')
            ->get();

        $urut_dosen_terakhir = null;
        foreach ($dosen_terakhir as $dosen_terakhir) {
            $urut_dosen_terakhir = $dosen_terakhir->pembimbing_ke;
        }

        $pembimbing = new MPembimbing();
        $pembimbing->id_universitas = Session::get('id_pengguna_universitas');
        $pembimbing->id_topik = $_POST['id_topik'];
        $pembimbing->id_dosen = $_POST['dosen_pembimbing'];
        $pembimbing->pembimbing_ke = $urut_dosen_terakhir+1;
        $pembimbing->save();

        return Redirect::to('topik');
    }

    public function bagikan(){

        //topik universitas
        $topik_universitas = new MTopikUniversitas();
        $topik_universitas->id_topik = $_POST['id_topik'];
        $topik_universitas->id_universitas = Session::get('id_pengguna_universitas');
        $topik_universitas->id_prodi = $_POST['prodi'];
        $topik_universitas->id_jenjang = $_POST['jenjang'];
		$topik_universitas->id_semester = $_POST['semester'];
        $topik_universitas->tahun_ajaran = $_POST['tahun_ajaran'];
        $topik_universitas->save();


        //kelompok
        $kelompok = new MKelompokTopik();
        $kelompok->id_universitas = Session::get('id_pengguna_universitas');
        $kelompok->id_topik = $_POST['id_topik'];
        $kelompok->save();


        return Redirect::to('topik');
    }
	
	public function tampilkan_semua(){
		$tampilkan_semua = DB::table('topik_universitas')
            ->select('*','topik.id as id_topik','topik_universitas.id_prodi as id_prodi','topik_universitas.id_jenjang as id_jenjang'
			,'topik_universitas.id_semester as semester',
			'topik_universitas.id_universitas as id_universitas')
            ->join('topik','topik_universitas.id_topik','=','topik.id')
            ->join('universitas','topik_universitas.id_universitas','=','universitas.id')
            ->join('pengguna','universitas.id_pengguna','=','pengguna.id')
            ->orderBy('topik.judul','asc')
            ->distinct()            
            ->get();

        return view('layouts.topik.tampilkan_semua')           
            ->with('tampilkan_semua',$tampilkan_semua);
	}
	
    public function lihat_selengkapnya(){
        //universitas
        $universitas = DB::table('pengguna')
            ->join('universitas','pengguna.id','=','universitas.id_pengguna')
            ->where('pengguna.status','=','2')
            ->orderBy('nama','asc')
            ->get();

        //prodi
        $prodi = DB::table('prodi')
            ->where('id','!=','0')
            ->orderBy('detail_prodi','asc')
            ->get();

        //jenjang
        $jenjang = DB::table('jenjang')
            ->orderBy('detail_jenjang','asc')
            ->get();

        //tahun ajaran
        $tahun_ajaran = DB::table('topik_universitas')
            ->select('tahun_ajaran')
            ->orderBy('tahun_ajaran','asc')
            ->distinct()
            ->get();

        //tampilkan_hasil_pencarian
//        $hasil_pencarian = DB::table('topik')
//            ->join('jenjang','topik.id_jenjang','=','jenjang.id')
//            ->join('universitas','topik.id_universitas','=','universitas.id')
//            ->join('pengguna','universitas.id_pengguna','=','pengguna.id')
//            ->join('topik_prodi','topik.id','=','topik_prodi.id_topik')
//            ->join('prodi','topik_prodi.id_prodi','=','prodi.id')
//            ->join('tahun_aktif_topik','topik.id','=','tahun_aktif_topik.id_topik')
//            ->join('topik_universitas','topik.id','=','topik_universitas.id_topik')
//            ->orderBy('topik.judul','asc')
//            ->distinct()
//            ->get();

//        $hasil_pencarian = DB::table('topik_universitas')
//            ->join('topik','topik_universitas.id_topik','=','topik.id')
//            ->join('universitas','topik_universitas.id_universitas','=','universitas.id')
//            ->join('pengguna','universitas.id_pengguna','=','pengguna.id')
//            ->orderBy('topik.judul','asc')
//            ->distinct()
//            ->get();

        $hasil_pencarian = DB::table('topik_universitas')
            ->select('*','topik.id as id_topik','topik_universitas.id_prodi as id_prodi',
			'topik_universitas.id_jenjang as id_jenjang','topik_universitas.id_semester as semester',
			'topik_universitas.id_universitas as id_universitas')
            ->join('topik','topik_universitas.id_topik','=','topik.id')
            ->join('universitas','topik_universitas.id_universitas','=','universitas.id')
            ->join('pengguna','universitas.id_pengguna','=','pengguna.id')            
            ->distinct()
            ->take(3)
			->orderByRaw('RAND()')
			->get();

        return view('layouts.topik.lihat_selengkapnya')
            ->with('prodi',$prodi)
            ->with('jenjang',$jenjang)
            ->with('tahun_ajaran',$tahun_ajaran)
            ->with('universitas',$universitas)
            ->with('hasil_pencarian',$hasil_pencarian);
    }

    public function cari()
    {
        //universitas
        $universitas = DB::table('pengguna')
            ->join('universitas','pengguna.id','=','universitas.id_pengguna')
            ->where('pengguna.status','=','2')
            ->orderBy('nama','asc')
            ->get();

        //prodi
        $prodi = DB::table('prodi')
            ->where('id','!=','0')
            ->orderBy('detail_prodi','asc')
            ->get();

        //jenjang
        $jenjang = DB::table('jenjang')
            ->orderBy('detail_jenjang','asc')
            ->get();

        //tahun ajaran
        $tahun_ajaran = DB::table('topik_universitas')
            ->select('tahun_ajaran')
            ->orderBy('tahun_ajaran','asc')
            ->distinct()
            ->get();
			
			

        //tampilkan_hasil_pencarian
//        $hasil_pencarian = DB::table('topik')
//            ->join('jenjang','topik.id_jenjang','=','jenjang.id')
//            ->join('universitas','topik.id_universitas','=','universitas.id')
//            ->join('pengguna','universitas.id_pengguna','=','pengguna.id')
//            ->join('topik_prodi','topik.id','=','topik_prodi.id_topik')
//            ->join('prodi','topik_prodi.id_prodi','=','prodi.id')
//            ->join('tahun_aktif_topik','topik.id','=','tahun_aktif_topik.id_topik')
//            ->join('topik_universitas','topik.id','=','topik_universitas.id_topik')
//            ->where('universitas.id','like',"%".$_POST['universitas']."%")
//            ->where('prodi.id','like',"%".$_POST['prodi']."%")
//            ->where('jenjang.id','like',"%".$_POST['jenjang']."%")
//            ->where('tahun_aktif_topik.tahun_ajaran','like',"%".$_POST['tahun_ajaran']."%")
//            ->where('topik.judul', 'like', "%".$_POST['judul']."%")
//            ->orderBy('topik.judul','asc')
//            ->get();
		
		if($_POST['dosen']!=NULL){
			$hasil_pencarian = DB::table('topik_universitas')
            ->select('*','topik.id as id_topik','topik_universitas.id_prodi as id_prodi','topik_universitas.id_jenjang as id_jenjang',
			'topik_universitas.id_semester as semester',
			'topik_universitas.id_universitas as id_universitas')
            ->join('topik','topik_universitas.id_topik','=','topik.id')
            ->join('universitas','topik_universitas.id_universitas','=','universitas.id')
            ->join('pengguna','universitas.id_pengguna','=','pengguna.id')			
			->join('pembimbing','pembimbing.id_topik','=','topik_universitas.id_topik')
            ->where('universitas.id','like',"%".$_POST['universitas']."%")
            ->where('topik_universitas.id_prodi','like',"%".$_POST['prodi']."%")
            ->where('topik_universitas.id_jenjang','like',"%".$_POST['jenjang']."%")
            ->where('topik_universitas.tahun_ajaran','like',"%".$_POST['tahun_ajaran']."%")
			->where('topik_universitas.id_semester','like',"%".$_POST['semester']."%")			
			->where('pembimbing.id_dosen','=',"".$_POST['dosen']."")			
			/*->where('topik_universitas.no_ta','like',"%".$_POST['no_ta']."%")*/
            ->where('topik.judul', 'like', "%".$_POST['judul']."%")
            ->orderBy('topik.judul','asc')            
            ->get();
			
			return view('layouts.topik.lihat_selengkapnya')
            ->with('prodi',$prodi)
            ->with('jenjang',$jenjang)
            ->with('tahun_ajaran',$tahun_ajaran)
            ->with('universitas',$universitas)			
            ->with('hasil_pencarian',$hasil_pencarian);
		}else{
			$hasil_pencarian = DB::table('topik_universitas')
            ->select('*','topik.id as id_topik','topik_universitas.id_prodi as id_prodi',
			'topik_universitas.id_jenjang as id_jenjang','topik_universitas.id_semester as semester',
			'topik_universitas.id_universitas as id_universitas')
            ->join('topik','topik_universitas.id_topik','=','topik.id')
            ->join('universitas','topik_universitas.id_universitas','=','universitas.id')
            ->join('pengguna','universitas.id_pengguna','=','pengguna.id')						
            ->where('universitas.id','like',"%".$_POST['universitas']."%")
            ->where('topik_universitas.id_prodi','like',"%".$_POST['prodi']."%")
            ->where('topik_universitas.id_jenjang','like',"%".$_POST['jenjang']."%")
            ->where('topik_universitas.tahun_ajaran','like',"%".$_POST['tahun_ajaran']."%")
			->where('topik_universitas.id_semester','like',"%".$_POST['semester']."%")						
			/*->where('topik_universitas.no_ta','like',"%".$_POST['no_ta']."%")*/
            ->where('topik.judul', 'like', "%".$_POST['judul']."%")
            ->orderBy('topik.judul','asc')            
            ->get();
			
			return view('layouts.topik.lihat_selengkapnya')
            ->with('prodi',$prodi)
            ->with('jenjang',$jenjang)
            ->with('tahun_ajaran',$tahun_ajaran)
            ->with('universitas',$universitas)			
            ->with('hasil_pencarian',$hasil_pencarian);
		}		               
    }
}