<?php header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');?>
@extends('layouts.koleksi_master.heater')
@section('additional_css')
    form{
    font-weight:lighter;
    font-family:'Lato'
    }
    #nav-dashboard{
    color:#be272d;
    }
    .container{
    font-size:16px;
    }
    .list-group{
    font-weight:lighter;
    font-family:'Lato'
    }
@endsection
@section('header')
    @if ( Session::has('pesan_berhasil_masuk_sistem') )
@section('additional_js')
    $(document).ready(function(){

    sweetAlert("Selamat Datang", "<?php echo Session::get('nama'); ?>","success");


    $.ajaxSetup({

	cache: false,
	crossDomain: true,
    xhrFields: {
       withCredentials: true
    },
	async: true

    });



    $.ajax({
        url: 'http://tadj.lskk.ee.itb.ac.id/moodle/login/index.php',
        type: 'POST',
        data: { username: "<?php echo strtolower(Session::get('nama')); ?>", password : "<?php echo strtolower(Session::get('nama')); ?>"} ,
        success: function (response) {
            console.log("Moodle berhasil kirim data");
        },
        error: function () {
            //alert("error");
        }
    });


    $.ajax({
            url: 'http://tadj.lskk.ee.itb.ac.id/forum/login_forum.php',
            type: 'POST',
            data: { username: "aguspratondo", password : "Martabakmanis!1",email:"aguspratondo@gmail",ip:"<?php echo $_SERVER['REMOTE_ADDR']; ?>"} ,
            success: function (response) {
                console.log("Forum berhasil kirim data");
                //alert("berhasil");
            },
            error: function () {
                    //alert("error");
            }
    });

	$.ajax({
            url: 'http://tadjblog.lskk.ee.itb.ac.id/wp-content/themes/twentysixteen',
            type: 'POST',
            data: { username: "aguspratondo", password : "Martabakmanis!1"} ,
            success: function (response) {
                console.log("Blog berhasil kirim data");
                //alert("berhasil");
            },
            error: function () {
				console.log("Blog gagal kirim data");
                    //alert("error");
            }
    });

	$.ajax({
            url: 'http://tadjblog.lskk.ee.itb.ac.id/wp-content/themes/twentyfifteen',
            type: 'POST',
            data: { username: "aguspratondo", password : "Martabakmanis!1"} ,
            success: function (response) {
                console.log("Blog berhasil kirim data");
                //alert("berhasil");
            },
            error: function () {
				console.log("Blog gagal kirim data");
                    //alert("error");
            }
    });

	$.ajax({
            url: 'http://tadjblog.lskk.ee.itb.ac.id/wp-content/themes/twentyfourteen',
            type: 'POST',
            data: { username: "aguspratondo", password : "Martabakmanis!1"} ,
            success: function (response) {
                console.log("Blog berhasil kirim data");
                //alert("berhasil");
            },
            error: function () {
				console.log("Blog gagal kirim data");
                    //alert("error");
            }
    });

	$.post( "http://tadjblog.lskk.ee.itb.ac.id/login_blog.php", { username: 'aguspratondo', password: 'Martabakmanis!1' })
	.done(function() {
		//alert("berhasil kirim");
	}).fail(function(data) {
		//alert("gagal kirim");
	});
    });
@endsection
@endif

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="block-right">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <div class="nav-logo">
                                <?php
                                if (Session::get('status') == NULL) {
                                ?>
                                <a href="/tadj"><img src="core/resources/assets/image/halaman_utama/logo.png"
                                                     alt="logo" style="width:2.1em;height:2em;"></a>
                                <?php
                                }else{
                                ?>
                                <a href="dashboard"><img src="core/resources/assets/image/halaman_utama/logo.png"
                                                         alt="logo" style="width:2.1em;height:2em;"></a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <?php
                                if (Session::get('status') == 3) {//pengguna sebagai dosen
                                ?>
                                <li><a href="topik" id="nav-topik-pake-login">Judul Tugas Akhir</a></li>
								<li><a href="{{url('/rekapitulasi/semua')}}">Rekapitulasi</a></li>
                                <li><a href="bimbingan">Bimbingan</a></li>
								<li><a href="http://tadjblog.lskk.ee.itb.ac.id/" target = "_blank">Blog</a></li>

                                <?php
                                }else if(Session::get('status') == 2){//pengguna sebagai universitas
                                ?>
                                <li><a href="topik" id="nav-topik-pake-login">Judul Tugas Akhir</a></li>
                                <li><a href="kelompok">Kelompok</a></li>
                                <li><a href="prodi" id="nav-prodi">Prodi</a></li>
                                <li><a href="mahasiswa" id="nav-mahasiswa">Mahasiswa</a></li>
                                <li><a href="dosen" id="nav-dosen">Dosen</a></li>

                                <?php
                                }else if(Session::get('status') == 1){//pengguna sebagai administrator
                                ?>
                                @yield('nav_link')
                                <li><a href="admin/tambah_pengguna" id="nav-keluar">Pengguna</a></li>

                                <?php
                                }else if(Session::get('status') == 4) {//mahasiswa
                                ?>
                                <li><a href="topik/lihat_selengkapnya" id="nav-topik-pake-login">Judul Tugas
                                        Akhir</a></li>
                                <li><a href="mahasiswa/konfirmasi">Kelompok</a></li>
                                <li><a href="bimbingan">Bimbingan</a></li>
                                <?php
                                    $final_url_blog = null;
                                    foreach ($url_blog as $url ) {
                                        $final_url_blog = $url->url_blog;
                                    }
                                ?>
                                <li><a href="http://tadjblog.lskk.ee.itb.ac.id/" target = "_blank">Blog</a></li>
                                <!--<li><a href="diskusi" target="_blank">Forum Diskusi</a></li>
                                <li><a href="moodle" target="_blank">Moodle</a></li>
                                <li><a href="yoopa" target="_blank">Yoopa</a></li>-->

                                <?php
                                }
                                ?>

								<li>

								  <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
									<?php echo Session::get('nama');?>
									<span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="{{url('mahasiswa/profil')}}">Profil</a></li>
									<li><a href="{{url('keluar')}}">Keluar</a></li>
								  </ul>

								</li>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->

                    </div>
                    <!-- /.container-fluid -->
                </nav>
            </div>
        </div>
        <!-- .col-md-6 -->
    </div>
    <!-- .row close -->
</div>

@endsection
@section('content')
    <div class="container">
        <!--<div class="row">
            <div class="col-md-12">
                Anda masuk sebagai <?php echo Session::get('nama'); ?>
                <br/>

            </div>
        </div>
		<br/>
		-->


        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">Informasi</span>
                </div>
                <div class="panel-body" style="font-size:14px;">
                    <ul class="list-group">
                        <?php
                        if(Session::get('status') == 2 || Session::get('status') == 3){//universitas atau dosen
                        //cek apakah sudah melakukan konfirmasi atau sebaliknya
                        $cek_konfirmasi = DB::table('dosen')
                                ->select('status_konfirmasi')
                                ->where('id', '=', Session::get('id'))
                                ->where('status_konfirmasi', '=', 1)
                                ->count();
                        if ($cek_konfirmasi == 0 && Session::get('status') == 3) {
                            echo "Anda belum melakukan konfirmasi bahwa anda dosen universitas/ institusi anda. Lakukan konfirmasi <a href='topik'>disini</a>.";
                        } else {
                        foreach ($informasi as $a) {
                        ?>
                        <li class="list-group-item">
                            <span class="badge"><?php echo $a->pembuatan_informasi?></span>
                            <?php
                            if (Session::get('status') == 3) {//dosen

                                $ganti_dengan_anda = explode('telah', $a->deskripsi);

                                //ambil nama universitas tujuan
                                $ambil_nama_universitas_tujuan = DB::table('pengguna')
                                        ->join('universitas', 'pengguna.id', '=', 'universitas.id_pengguna')
                                        ->join('pengajuan_topik', 'universitas.id', '=', 'pengajuan_topik.id_universitas_tujuan')
                                        ->where('pengajuan_topik.id_universitas_tujuan', '=', $a->id_universitas_tujuan)
                                        ->get();

                                $final_ambil_nama_universitas_tujuan = null;
                                foreach ($ambil_nama_universitas_tujuan as $a) {
                                    $final_ambil_nama_universitas_tujuan = $a->nama;
                                }

                                //menghilangkan titik
                                if (substr($ganti_dengan_anda[1], -1) == '.') {
                                    echo 'Anda telah ' . substr($ganti_dengan_anda[1], 0, -1) . ' ke ' . $final_ambil_nama_universitas_tujuan . '.';
                                } else {
                                    echo 'Anda telah ' . $ganti_dengan_anda[1] . ' ke ' . $final_ambil_nama_universitas_tujuan . '.';
                                }

                            } else {
                                echo $a->deskripsi;
                            }
                            ?>
                        </li>
                        <?php
                        }
                        }


                        }else if (Session::get('status') == 4) {//mahasiswa
                        //cek apakah sudah melakukan konfirmasi atau sebaliknya
                        ?>
                        <li class="list-group-item">
                            <?php
							//cek konfirmasi
                            $cek_konfirmasi = DB::table('mahasiswa')
                                    ->select('status_konfirmasi')
                                    ->where('id', '=', Session::get('id_pengguna_mahasiswa'))
                                    ->where('status_konfirmasi', '=', 1)
                                    ->count();

							//ambil url photo
									$photo_url = null;
									$cek_photo_url = DB::table('pengguna')
											->select('photo_url')
											->where('id', '=', Session::get('id_pengguna'))
											->get();

									foreach ($cek_photo_url as $cek_photo_url) {
										$photo_url = $cek_photo_url->photo_url;
									}

							//ambil nama universitas
							$ambil_nama_universitas = DB::table('universitas')
									->select('pengguna.nama as nama')
									->join('pengguna', 'universitas.id_pengguna', '=', 'pengguna.id')
									->where('universitas.id', '=', Session::get('id_universitas'))
									->get();
							$nama_universitas = null;
							foreach ($ambil_nama_universitas as $ambil_nama_universitas) {
								$nama_universitas = $ambil_nama_universitas;
							}

                            if ($cek_konfirmasi == 0 && $photo_url == null) {
                                $status = "<div class='alert alert-danger' role='alert'>Anda belum dianggap mahasiswa " . $nama_universitas->nama . ". Segeralah lakukan konfirmasi dengan menggungah foto berupa hasil scan kartu mahasiswa anda <a href = '#' data-toggle='modal'
                                                   data-target='#unggah_ktm'>disini</a>.</div>";
												   ?>
												   <div class="modal fade" id="unggah_ktm" tabindex="-1"
                                 role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title"
                                                id="myModalLabel">Unggah Kartu Tanda Mahasiswa</h4>
                                        </div>
                                        {!! Form::open(array('url'=>'mahasiswa/unggah_ktm','method'=>'POST', 'files'=>true)) !!}

                                                <!--<form method="post" action="../mahasiswa/unggah_ktm" enctype="multipart/form-data">-->
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                        <input type="hidden" name="id"
                                               value="<?php echo Session::get('id_pengguna');?>"/>

                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="row">
                                                    {!! Form::file('ktm') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal
                                            </button>
                                            <button type="submit" class="btn btn-danger">Submit
                                            </button>
                                        </div>
                                        {!! Form::close() !!}

                                                <!--</form>-->
                                    </div>
                                </div>
                            </div>
												   <?php
												   echo $status;
                            } else if ($cek_konfirmasi == 0) {
                                $status = "<div style = 'font-weight: lighter;' class='alert alert-warning' role='alert'>Sedang dalam pemeriksaan bahwa anda mahasiswa " . $nama_universitas->nama . "</div>";
								echo $status;
                            }

                            ?>
                        </li>
                        <?php
                        } else {//administrator
                            echo "informasi untuk administrator disini sedang dalam proses pengembangan";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
