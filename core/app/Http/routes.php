<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
//Route::get('/', function () {
//    return view('layouts/index');
//});

Route::get('/', 'CPengguna@index');

//Rekapitulasi TA
Route::get('ta/{no_ta}', function ($nama_topik)    {
        //Ambil id topik berdasarkan judul dari url

        $topik_universitas = DB::table('topik_universitas')
            ->join('topik','topik.id','=','topik_universitas.id_topik')
            ->join('kelompok','kelompok.id','=','topik_universitas.id_kelompok')
            ->where('kelompok.no_kelompok','=',$nama_topik)
            ->get();

        if(count($topik_universitas) != 0){//kelompok ditemukan
            return view('layouts.topik.ta')
                        ->with('topik_universitas',$topik_universitas);
        }else{//no kelompok tidak ditemukan
            return view('errors.404');
        }

    });

//Pengguna
Route::get('masuk', 'CPengguna@login');
Route::get('daftar', 'CPengguna@daftar');
Route::post('masuk', 'CPengguna@masuk');
Route::post('ganti_sandi', 'CPengguna@ganti_sandi');
Route::post('ganti_profil', 'CPengguna@ganti_profil');
Route::get('keluar', 'CPengguna@keluar');
Route::post('validasi_email', 'CPengguna@validasi_email');
Route::get('lupa_kata_sandi', 'CPengguna@lupa_kata_sandi');

Route::get('dashboard', [
    'middleware' => 'auth',
    'uses' => 'CInformasi@index'
]);


Route::group(['prefix' => 'rekapitulasi','middleware' => 'auth'],function(){
    Route:get('semua','CRekapitulasi@index');
    Route::post('filter','CRekapitulasi@filter');
	//Route:get('semua_universitas','CRekapitulasi@index');
});

Route::group(['prefix' => 'mahasiswa','middleware' => 'auth'],function(){
    Route:get('profil','CMahasiswa@profil');
    Route::post('filter','CRekapitulasi@filter');
});

Route::post('proses_daftar', 'CPengguna@proses_daftar');


//Topik
//Route::get('topik', 'CTopik@index');
Route::get('topik', [
    'middleware' => 'auth',
    'uses' => 'CTopik@index'
]);

Route::get('topik/lihat_selengkapnya', 'CTopik@lihat_selengkapnya');

Route::post('proses_topik_masuk', 'CTopik@masuk');
Route::get('topik/tampilkan_semua', 'CTopik@tampilkan_semua');
Route::get('kelompok/tampilkan_semua', 'CKelompok@tampilkan_semua');

Route::post('topik/bagikan', [
    'middleware' => 'auth',
    'uses' => 'CInformasi@masuk'
]);

Route::post('topik/bagikan/universitas', [
    'middleware' => 'auth',
    'uses' => 'CTopik@bagikan'
]);

Route::post('topik/update_topik', [
    'middleware' => 'auth',
    'uses' => 'CTopik@ubah'
]);

Route::post('topik/update_universitas', [
    'middleware' => 'auth',
    'uses' => 'CTopik@ubah_universitas'
]);

Route::post('topik/pembimbing/tambah', [
    'middleware' => 'auth',
    'uses' => 'CTopik@pembimbing_tambah'
]);

Route::post('topik/no_ta/ubah', [
    'middleware' => 'auth',
    'uses' => 'CTopik@no_ta_ubah'
]);

Route::post('topik/cari','CTopik@cari');
//Route::post('topik/cari', [
//    'middleware' => 'auth',
//    'uses' => 'CTopik@cari'
//]);

Route::post('topik/perbaharui_alamat_blog', [
    'middleware' => 'auth',
    'uses' => 'CTopik@perbaharui_alamat_blog'
]);

Route::post('topik/unggah_poster_produk', [
    'middleware' => 'auth',
    'uses' => 'CTopik@unggah_poster_produk'
]);

Route::post('topik/unggah_video_produk', [
    'middleware' => 'auth',
    'uses' => 'CTopik@unggah_video_produk'
]);


//Administrator
//pengguna
Route::get('admin/tambah_pengguna', [
    'middleware' => 'auth',
    'uses' => 'CPengguna@tambah_oleh_administrator'
]);

Route::post('admin/proses_daftar_pengguna', [
    'middleware' => 'auth',
    'uses' => 'CPengguna@proses_tambah_oleh_administrator'
]);

//kelompok
Route::get('kelompok', [
    'middleware' => 'auth',
    'uses' => 'CKelompok@index'
]);

Route::post('proses_tambah_kelompok', [
    'middleware' => 'auth',
    'uses' => 'CKelompok@tambah_kelompok'
]);

//Akhir administrator

//Universitas
Route::get('mahasiswa', [
    'middleware' => 'auth',
    'uses' => 'CMahasiswa@index'
]);

Route::get('dosen', [
    'middleware' => 'auth',
    'uses' => 'CDosen@index'
]);

Route::post('mahasiswa/proses_konfirmasi', [
    'middleware' => 'auth',
    'uses' => 'CMahasiswa@proses_konfirmasi'
]);
Route::post('dosen/proses_konfirmasi', [
    'middleware' => 'auth',
    'uses' => 'CDosen@proses_konfirmasi'
]);

Route::get('prodi', [
    'middleware' => 'auth',
    'uses' => 'CProdi@index'
]);

Route::post('prodi/tambah_prodi_universitas', [
    'middleware' => 'auth',
    'uses' => 'CProdi@tambah_prodi_universitas'
]);
//Akhir universitas

//Mahasiswa
Route::get('mahasiswa/konfirmasi', [
    'middleware' => 'auth',
    'uses' => 'CMahasiswa@konfirmasi'
]);

Route::post('mahasiswa/unggah_ktm', [
    'middleware' => 'auth',
    'uses' => 'CMahasiswa@unggah_ktm'
]);

Route::post('mahasiswa/gabung_kelompok', [
    'middleware' => 'auth',
    'uses' => 'CMahasiswa@gabung_kelompok'
]);

Route::post('kelompok/ambil_topik', [
    'middleware' => 'auth',
    'uses' => 'CKelompok@ambil_topik'
]);

//Route::post('mahasiswa/pencarian_kelompok', 'CMahasiswa@pencarian_kelompok');
Route::post('mahasiswa/pencarian_kelompok', [
    'middleware' => 'auth',
    'uses' => 'CMahasiswa@pencarian_kelompok'
]);
//Akhir mahasiswa

//Dosen

Route::post('dosen/unggah_ktp', [
    'middleware' => 'auth',
    'uses' => 'CDosen@unggah_ktp'
]);

//Bimbingan
Route::get('bimbingan', [
    'middleware' => 'auth',
    'uses' => 'CMahasiswa@bimbingan'
]);

Route::post('bimbingan/tambah_tahap', [
    'middleware' => 'auth',
    'uses' => 'CBimbingan@tambah_tahap'
]);

Route::post('bimbingan/tambah_bimbingan', [
    'middleware' => 'auth',
    'uses' => 'CBimbingan@tambah_bimbingan'
]);

Route::post('bimbingan/tandai_sudah_diperiksa', [
    'middleware' => 'auth',
    'uses' => 'CBimbingan@tandai_sudah_diperiksa'
]);

Route::post('bimbingan/tambah_revisi', [
    'middleware' => 'auth',
    'uses' => 'CBimbingan@tambah_revisi'
]);
