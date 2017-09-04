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

class CMahasiswa extends Controller
{
    public function index()
    {
        $mahasiswa = DB::table('pengguna')
            ->select('*', 'mahasiswa.id as id_mahasiswa')
            ->join('mahasiswa', 'pengguna.id', '=', 'mahasiswa.id_pengguna')
            ->where('status', '=', '4')
            ->where('id_universitas', '=', Session::get('id_pengguna_universitas'))
            ->orderBy('pengguna.email','asc')
            ->get();

        return view('layouts.pengguna.mahasiswa')
            ->with('mahasiswa', $mahasiswa);
    }

    public function profil()
    {

        $pengguna = DB::table('pengguna')
            ->select('*')
            ->where('id','=',Session::get('id_pengguna'))
            ->get();

        return view('layouts.profil.mahasiswa')
            ->with('penggunas', $pengguna);
    }

    public function gabung_kelompok()
    {
        //Dicek dahulu apakah kuota kelompok masih tersedia secara back end
        $sisa_kuota = null;

        $kuota_yang_terpakai = DB::table('kelompok_mahasiswa')
            ->where('id_kelompok', '=', $_POST['id_kelompok'])
            ->count();

        $sisa_kuota = $_POST['id_kuota'] - $kuota_yang_terpakai;
        if ($sisa_kuota <= 0) {
            Session::flash('gagal', 'Maaf, baru saja kuota kelompok yang anda pilih habis. Silahkan pilih kelompok yang lain.');
            return Redirect::to('mahasiswa/konfirmasi');
        } else {
            $kelompok_mahasiswa = new MKelompokMahasiswa();
            $kelompok_mahasiswa->id_kelompok = $_POST['id_kelompok'];
            $kelompok_mahasiswa->id_mahasiswa = $_POST['id_mahasiswa'];
            $kelompok_mahasiswa->save();

            DB::table('mahasiswa')
                ->where('id', Session::get('id_pengguna_mahasiswa'))
                ->update(['id_kelompok' => $_POST['id_kelompok']]);

            $id_kelompok = $_POST['id_kelompok'];
            Session::set('id_kelompok_ta',$id_kelompok);

            return Redirect::to('mahasiswa/konfirmasi');
        }
    }

    public function konfirmasi()
    {
        $prodi_universitas = DB::table('prodi')
            ->join('prodi_universitas', 'prodi.id', '=', 'prodi_universitas.id_prodi')
			->where('prodi_universitas.id_universitas','=',Session::get('id_universitas'))
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

        return view('layouts.konfirmasi.mahasiswa')
            ->with('kelompok', $kelompok)
            ->with('prodi', $prodi_universitas)
            ->with('jenjang', $jenjang)
            ->with('tahun_ajaran', $tahun_ajaran)
            ->with('mahasiswa2', $mahasiswa);
    }

    public function pencarian_kelompok()
    {

        $prodi_universitas = DB::table('prodi')
            ->join('prodi_universitas', 'prodi.id', '=', 'prodi_universitas.id_prodi')
			->where('prodi_universitas.id_universitas','=',Session::get('id_universitas'))
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
            ->where('no_kelompok', 'like', '%' . $_POST['kelompok'] . '%')
            ->where('tahun_ajaran', 'like', '%' . $_POST['tahun_ajaran'] . '%')
            ->where('id_universitas', '=', Session::get('id_universitas'))
			->where('id_prodi', 'like', '%' .$_POST['prodi']. '%')
			->where('id_semester', 'like', '%' .$_POST['semester']. '%')
            ->get();


        return view('layouts.konfirmasi.mahasiswa')
            ->with('kelompok', $kelompok)
            ->with('prodi', $prodi_universitas)
            ->with('jenjang', $jenjang)
            ->with('tahun_ajaran', $tahun_ajaran)
            ->with('mahasiswa2', $mahasiswa);

    }

    public function bimbingan()
    {
        //ambil id topik
        /*$id_topik_kelompok = DB::table('kelompok_topik_tugas_akhir')
            ->select('kelompok_topik_tugas_akhir.id_topik as id_topik','kelompok_topik_tugas_akhir.id_kelompok as id_kelompok')
            ->join('kelompok_mahasiswa', 'kelompok_topik_tugas_akhir.id_kelompok', '=', 'kelompok_mahasiswa.id_kelompok')
            ->where('kelompok_mahasiswa.id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
            ->get();*/

        $id_topik_kelompok = DB::table('kelompok_topik_tugas_akhir')
            ->select('*')
            ->where('id_kelompok', '=', Session::get('id_kelompok_ta'))
            ->get();    

        $id_topik = null;

        foreach ($id_topik_kelompok as $id_topik_kelompok) {
            $id_topik = $id_topik_kelompok->id_topik;
        }

        //ambil pembimbing
        $pembimbing = DB::table('pembimbing')
            ->select('pengguna.nama as nama', 'pembimbing.pembimbing_ke as pembimbing_ke','pembimbing.id_dosen as id_dosen','pengguna.nama_depan as nama_depan'
			,'pengguna.nama_belakang as nama_belakang','pengguna.email as email')
            ->join('dosen', 'pembimbing.id_dosen', '=', 'dosen.id')
            ->join('pengguna', 'dosen.id_pengguna', '=', 'pengguna.id')
            ->where('pembimbing.id_universitas', '=', Session::get('id_universitas'))
            ->where('pembimbing.id_topik', '=', $id_topik)
            ->orderBy('pembimbing.pembimbing_ke', 'asc')
            ->get();

        //ambil tahap bimbingan
        $tahap = DB::table('bimbingan_tahap')
            ->select('*','tahap as tahap')
            ->where('id_universitas','=',Session::get('id_universitas'))
            ->where('id_topik', '=', $id_topik)
            ->where('id_kelompok', '=', Session::get('id_kelompok_ta'))
            ->orderBy('tahap','asc')
            ->get();

        
        return view('layouts.bimbingan.index')
            ->with('id_topik_kelompok', $id_topik_kelompok)
            ->with('tahap', $tahap)
            ->with('tahap2', $tahap)
            ->with('pembimbing', $pembimbing)
            ->with('pembimbing2', $pembimbing);
            
    }

    public function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }


    public function unggah_ktm()
    {
        /*$nama_berkas_ktm = Input::file('ktm')->getClientOriginalName();

      

        $rename_berkas_ktm = $this->random_string(50). '.' . Input::file('ktm')->getClientOriginalExtension();

        $path = 'core/resources/assets/image/ktm/';
        Input::file('ktm')->move($path, $rename_berkas_ktm);

        DB::table('pengguna')
            ->where('id', Session::get('id_pengguna'))
            ->update(['photo_url' => 'core/resources/assets/image/ktm/' . $rename_berkas_ktm]);*/
			
		$rename_berkas = $this->random_string(50) . '.' . Input::file('ktm')->getClientOriginalExtension();

        $ftp_server = "167.205.7.228";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        
        $login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

        if (true === $login) {
           //ftp_put($ftp_conn,"/Assets/TADJ/poster/".$rename_berkas,Input::file('berkas')->getPathName(), FTP_ASCII);
           ftp_put($ftp_conn,"/Assets/TADJ/ktm/".$rename_berkas,Input::file('ktm')->getPathName(), FTP_BINARY);
           ftp_close($ftp_conn); 
           //return 'Success!';

        } else {
            ftp_close($ftp_conn);
            //return 'Failed login to FTP';

        }

        DB::table('pengguna')
            ->where('id', Session::get('id_pengguna'))
            ->update(['photo_url' => 'http://167.205.7.228:8089/tadj/ktm/'.$rename_berkas.'']);
			
        return Redirect::to('mahasiswa/konfirmasi');
    }

    public function proses_konfirmasi()
    {
        DB::table('mahasiswa')
            ->where('id', $_POST['id_mahasiswa'])
            ->update(['status_konfirmasi' => '1']);

        return Redirect::to('mahasiswa');
    }
}