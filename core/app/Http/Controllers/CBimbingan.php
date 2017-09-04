<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MBimbinganDetail;
use App\MKelompok;
use App\MKelompokMahasiswa;
use App\MPengguna;
use App\MTahapBimbingan;
use DB;
use Illuminate\Support\Facades\Redirect;
use Input;
use Session;

class CBimbingan extends Controller
{
    public function index()
    {

    }
    public function tambah_tahap()
    {
        //menghitung tahap terakhir di db
        $tahap = DB::table('bimbingan_tahap')
            ->take(1)
            ->where('id_universitas','=',Session::get('id_universitas'))
            ->where('id_topik','=',$_POST['topik'])
            ->where('id_kelompok','=',Session::get('id_kelompok_ta'))
            ->orderBy('tahap','desc')
            ->get();

        $final_tahap = null;
        foreach ($tahap as $tahap) {
            $final_tahap = $tahap->tahap;
        }

        $bimbingan_tahap = new MTahapBimbingan();
        $bimbingan_tahap->id_universitas = Session::get('id_universitas');
        $bimbingan_tahap->id_topik= $_POST['topik'];
        $bimbingan_tahap->id_kelompok= Session::get('id_kelompok_ta');
        $bimbingan_tahap->tahap= $final_tahap+1;
        $bimbingan_tahap->save();

        return Redirect::to('bimbingan');
    }

    public function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    public function tambah_bimbingan(){
        //ambil id kelompok
        $kelompok = DB::table('kelompok')
            ->select('kelompok.no_kelompok as no_kelompok', 'kelompok.id as id')
            ->join('kelompok_mahasiswa', 'kelompok.id', '=', 'kelompok_mahasiswa.id_kelompok')
            ->where('kelompok_mahasiswa.id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
            ->get();

        $bimbingan_detail = new MBimbinganDetail();
        $bimbingan_detail->id_universitas = Session::get('id_universitas');
        $bimbingan_detail->id_topik = $_POST['topik'];
        $bimbingan_detail->id_kelompok = $_POST['kelompok'];
        $bimbingan_detail->id_dosen_pembimbing = $_POST['pembimbing'];
        $bimbingan_detail->tahap = $_POST['tahap'];
        $bimbingan_detail->judul = $_POST['judul'];
        $bimbingan_detail->tanggal = $_POST['tanggal'];
        $bimbingan_detail->permasalahan = $_POST['permasalahan'];
        $bimbingan_detail->penyelesaian = $_POST['penyelesaian'];

        
        if(Input::file('berkas') != null){
        						
			$rename_berkas = $this->random_string(50) . '.' . Input::file('berkas')->getClientOriginalExtension();

			$ftp_server = "167.205.7.228";
			$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
			
			$login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

			if (true === $login) {
			   //ftp_put($ftp_conn,"/Assets/TADJ/poster/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_ASCII);
			   ftp_put($ftp_conn,"/Assets/TADJ/tahapan/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_BINARY);
			   ftp_close($ftp_conn); 
			   //return 'Success!';

			} else {
				ftp_close($ftp_conn);
				//return 'Failed login to FTP';

			}

			$bimbingan_detail->lokasi_berkas_bimbingan = 'http://167.205.7.228:8089/tadj/tahapan/'.$rename_berkas;			
        }
        

        $bimbingan_detail->save();

        Session::flash('bimbingan', 'Bimbingan kelompok telah ditambahkan pada tahap '.$_POST['tahap'].'');
        return Redirect::to('bimbingan');
    }

    public function tambah_revisi(){
        if(Input::file('berkas') != null){
        
        /*$rename_berkas_revisi = $this->random_string(50) . '.' . Input::file('berkas')->getClientOriginalExtension();

        $path = 'core/resources/assets/berkas/revisi/';
        Input::file('berkas')->move($path, $rename_berkas_revisi);

        DB::table('bimbingan_detail')
            ->where('id','=',$_POST['id'])
            ->update(array('revisi' => $_POST['revisi'],'lokasi_berkas_revisi' => 'core/resources/assets/berkas/revisi/'.$rename_berkas_revisi));*/
			
			$rename_berkas = $this->random_string(50) . '.' . Input::file('berkas')->getClientOriginalExtension();

			$ftp_server = "167.205.7.228";
			$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
			
			$login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

			if (true === $login) {
			   //ftp_put($ftp_conn,"/Assets/TADJ/poster/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_ASCII);
			   ftp_put($ftp_conn,"/Assets/TADJ/tahapan/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_BINARY);
			   ftp_close($ftp_conn); 
			   //return 'Success!';

			} else {
				ftp_close($ftp_conn);
				//return 'Failed login to FTP';

			}
						
			DB::table('bimbingan_detail')
            ->where('id','=',$_POST['id'])
            ->update(array('revisi' => $_POST['revisi'],'lokasi_berkas_revisi' => 'http://167.205.7.228:8089/tadj/tahapan/'.$rename_berkas));
			
        }else if(Input::file('berkas') == null){

            DB::table('bimbingan_detail')
                ->where('id','=',$_POST['id'])
                ->update(array('revisi' => $_POST['revisi']));

        }
        Session::flash('direvisi', 'Revisi berhasil diberikan');
        return Redirect::to('bimbingan');
    }

    public function tandai_sudah_diperiksa(){

        DB::table('bimbingan_detail')
            ->where('id','=',$_POST['id'])
            ->update(array('status_bimbingan' => 1));

        Session::flash('diperiksa', 'Bimbingan sudah ditandai diperiksa');
        return Redirect::to('bimbingan');
    }
}