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
    font-size:13px;
    }
    .list-group{
    font-weight:lighter;
    font-family:'Lato'
    }
@endsection
@section('header')
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
                                    <a href="../dashboard"><img
                                                src="../core/resources/assets/image/halaman_utama/logo.png"
                                                alt="logo" style="width:2.1em;height:2em;"></a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li><a href="../topik/lihat_selengkapnya" id="nav-topik-pake-login">Judul Tugas
                                            Akhir</a></li>
                                    <li><a href="konfirmasi" id="nav-dashboard">Kelompok</a></li>
                                    <li><a href="../bimbingan">Bimbingan</a></li>
									<li><a href="http://tadjblog.lskk.ee.itb.ac.id/" target = "_blank">Blog</a></li>
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
        <?php
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

        //ambil status konfirmasi
        $status = null;
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
        //if ($cek_konfirmasi == 0 || $photo_url == null) {
        if ($cek_konfirmasi == 0) {
        ?>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">Konfirmasi</span>
                </div>
                <div class="panel-body">
                    <div class="container">
                        <div class="row">
                            <?php
                            if ($cek_konfirmasi == 0 && $photo_url == null) {
                                $status = "<div class='alert alert-danger' role='alert' style='margin-right:2em;'>Anda belum dianggap mahasiswa " . $nama_universitas->nama . ". Segeralah lakukan konfirmasi dengan menggungah foto berupa hasil scan kartu mahasiswa anda <a href = '#' data-toggle='modal'
                                                   data-target='#unggah_ktm'>disini</a>.</div><br/><br/>";
                            } else if ($cek_konfirmasi == 0) {
                                $status = "<div style = 'font-weight: lighter;' class='alert alert-warning' role='alert'>Sedang dalam pemeriksaan bahwa anda mahasiswa " . $nama_universitas->nama . "</div>";
                            }
                            echo $status;
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }else{
        ?>
        <div class="row">
			@if ( Session::has('gagal') )
				<div class="alert alert-danger" role="alert">
					{{ Session::get('gagal') }}
				</div>
			@endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">Kelompok Anda</span>
                </div>
                <div class="panel-body">
                    <div class="container">
                        <div class="row" style="padding-right:2em;">
                            <?php
                            foreach ($mahasiswa2 as $mahasiswa2) {
                            if($mahasiswa2->id_kelompok == null){//apabila belum memiliki kelompok
                            ?>
                            <span class="label label-danger">Anda belum tergabung dalam kelompok, silahkan bergabung terlebih dahulu.</span>
                            <br/>
                            <br/>
                            <div class="row" style="padding-right:2em;">

                                <form method="post" action="pencarian_kelompok">
								<div class="row container">
                                    <div class="col-md-3">
                                        <input type="hidden" name="_token"
                                               value="{{ csrf_token() }}"/>
                                        <input type="text" class="form-control small"
                                               placeholder="Cari berdasarkan nomor kelompok"
                                               name="kelompok" id="pencarian_kelompok">
                                        <br/>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="prodi">
                                            <option value="">prodi</option>
                                            <?php
                                            foreach ($prodi as $p) {
                                            ?>
                                            <option value="<?php echo $p->id;?>"><?php echo $p->detail_prodi;?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="tahun_ajaran">
                                            <option value="">tahun ajaran</option>
                                            <?php
                                            foreach ($tahun_ajaran as $ta) {
                                            ?>
                                            <option value="<?php echo $ta->tahun_ajaran;?>"><?php echo $ta->tahun_ajaran;?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
									<div class="col-md-3">
                                        <select class="form-control" name="semester">
                                            <option value="">semester</option>
                                            <option value="1">Ganjil</option>
											<option value="2">Genap</option>
                                        </select>
                                    </div>
									</div>
									<div class="row container">

                                    <button type="submit" class="btn btn-danger" style="margin-left:1em;">Cari</button>
									</div>
                                </form>

							</div>
                            <br/>
                            <div class="row" style="padding-right:2em;">
                                <div class="col-md-12">
                                    <div class="table-responsive" id="load-kelompok" style="font-size:13px;">
                                        <?php
                                        if($kelompok != null){
                                        ?>
                                        <table class="table" id="table_id">
											<thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor kelompok <span class="text-danger">(klik nomor kelompok untuk melihat anggota yang sudah terdaftar sebelumnya)</span>
                                                </th>
                                                <th>Kuota tersedia</th>
                                                <th>Aksi</th>
                                            </tr>
											</thead>
											<span>
											<tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($kelompok as $kelompok) {
                                            ?>
                                            <tr>
                                                <td><?php echo $no;?></td>
                                                <td><a href="#" data-toggle="modal"
                                                       data-target="#nama_kelompok<?php echo $kelompok->no_kelompok;?>"><?php echo $kelompok->no_kelompok;?></a>
                                                </td>
                                                <td>
                                                    <?php
                                                    $sisa_kuota = null;

                                                    $kuota_yang_terpakai = DB::table('kelompok_mahasiswa')
                                                            ->where('id_kelompok', '=', $kelompok->id)
                                                            ->count();

                                                    $sisa_kuota = $kelompok->id_kuota - $kuota_yang_terpakai;
                                                    if ($sisa_kuota <= 0) {
                                                        echo '-';
                                                    } else {
                                                        echo $sisa_kuota;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if($sisa_kuota > 0){
                                                    ?>
                                                    <form method="post" action="../mahasiswa/gabung_kelompok">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                        <input type="hidden" name="id_kelompok"
                                                               value="<?php echo $kelompok->id;?>"/>
														<input type="hidden" name="id_kuota"
                                                               value="<?php echo $kelompok->id_kuota;?>"/>	   
                                                        <input type="hidden" name="id_mahasiswa"
                                                               value="<?php echo Session::get('id_pengguna_mahasiswa');?>"/>
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin bergabung kelompok ini?(Setelah bergabung tidak bisa reset/keluar kelompok)')">Gabung</button>
                                                    </form>
                                                    <?php }else {
                                                        echo "-";
                                                    } ?>
                                                </td>
                                            </tr>
                                            <!--modal-->
                                            <!--ubah topik-->
                                            <div class="modal fade"
                                                 id="nama_kelompok<?php echo $kelompok->no_kelompok;?>" tabindex="-1"
                                                 role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title"
                                                                id="myModalLabel"><?php echo $kelompok->no_kelompok;?></h4>
                                                        </div>
                                                        <form method="post" action="topik/update_topik">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>
                                                            <div class="modal-body">

                                                                <div class="row">
                                                                    <div class="col-md-2">Anggota:</div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="container">
                                                                        <div class="col-md-6">
                                                                            <?php
                                                                            $anggota = DB::table('kelompok_mahasiswa')
                                                                                    ->join('mahasiswa', 'kelompok_mahasiswa.id_mahasiswa', '=', 'mahasiswa.id')
                                                                                    ->join('pengguna', 'mahasiswa.id_pengguna', '=', 'pengguna.id')
                                                                                    ->where('kelompok_mahasiswa.id_kelompok', '=', $kelompok->id)
                                                                                    ->get();

                                                                            if($anggota != null){
                                                                            ?>
                                                                            <ul class="list-group">
                                                                                <?php
                                                                                $no_detail_kelompok = 1;
                                                                                foreach ($anggota as $anggota) {
                                                                                ?>
                                                                                <li class="list-group-item" style='font-size:13px;'>
                                                                                    <?php echo $no_detail_kelompok . '. ' . $anggota->nama_depan.' '.$anggota->nama_belakang.' ('.$anggota->email.')';?>
                                                                                </li>
                                                                                <?php
                                                                                $no_detail_kelompok++;
                                                                                }
                                                                                ?>
                                                                            </ul>
                                                                            <?php
                                                                            }else {
                                                                                echo "-";
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br/>
                                                                <div class="row">
                                                                    <div class="col-md-12">Topik Tugas Akhir:<br/>
                                                                    <?php
                                                                    $topik_kelompok = DB::table('kelompok_topik_tugas_akhir')
                                                                            ->select('topik.judul as judul')
                                                                            ->join('topik', 'kelompok_topik_tugas_akhir.id_topik', '=', 'topik.id')
                                                                            ->where('kelompok_topik_tugas_akhir.id_kelompok', '=', $kelompok->id)
                                                                            ->get();

                                                                        $topik_kelompok_final = null;
                                                                    foreach ($topik_kelompok as $topik_kelompok) {
                                                                        $topik_kelompok_final = $topik_kelompok->judul;
                                                                    }

                                                                    if($topik_kelompok != null){
                                                                    ?>
                                                                    <?php echo '<span style="font-weight: lighter;">'.$topik_kelompok_final.'</span></div>';?>
                                                                    <?php
                                                                    }else{
                                                                        ?>
                                                                        <span style="font-weight: lighter;">-</span></div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">Tutup
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $no++;
                                            }
                                            ?>
											</tbody>
											</span>

                                        </table>
										<!--<hr/>
										<a onClick="tampilkanSemua();" class="btn btn-danger col-md-12" id="btn-tampilkan-semua">Tampilkan semua</a>-->
                                        <?php
                                        }else {
                                            echo 'Hasil tidak ditemukan';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }else {//memiliki kelompok
                            $kelompok = DB::table('kelompok')
                                    ->select('kelompok.no_kelompok as no_kelompok', 'kelompok.id as id')
                                    ->join('kelompok_mahasiswa', 'kelompok.id', '=', 'kelompok_mahasiswa.id_kelompok')
                                    ->where('kelompok_mahasiswa.id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
                                    ->get();

                            foreach ($kelompok as $kelompok) {
                                $kelompok = $kelompok;
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group">
                                        <li class="list-group-item"><span class="text-danger"> No: </span><?php echo $kelompok->no_kelompok;?></li>
                                        <li class="list-group-item">
                                            <div class="panel-group" id="accordion" role="tablist"
                                                 aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse"
                                                               data-parent="#accordion" href="#collapseOne"
                                                               aria-expanded="true" aria-controls="collapseOne">
                                                                Anggota
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse collapse in"
                                                         role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">
                                                            <ul class="list-group">
                                                                <?php

                                                                $anggota_kelompok = DB::table('kelompok_mahasiswa')
                                                                        ->join('mahasiswa', 'kelompok_mahasiswa.id_mahasiswa', '=', 'mahasiswa.id')
                                                                        ->join('pengguna', 'mahasiswa.id_pengguna', '=', 'pengguna.id')
                                                                        ->where('kelompok_mahasiswa.id_kelompok', '=', $kelompok->id)
                                                                        ->orderBy('pengguna.nama', 'asc')
                                                                        ->get();
                                                                $no = 1;

                                                                foreach ($anggota_kelompok as $anggota_kelompok) {
                                                                ?>
                                                                <li class="list-group-item"><?php echo $no . '. ' . $anggota_kelompok->nama.' ('.$anggota_kelompok->email.')';?></li>
                                                                <?php
                                                                $no++;
                                                                }
                                                                ?>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span
                                                    class="text-danger">Judul Tugas Akhir: </span>
                                            <?php
                                            $kelompok_topik_tugas_akhir = DB::table('kelompok_topik_tugas_akhir')
                                                    ->select('topik.judul as judul','topik.deskripsi as deskripsi')
                                                    ->join('topik', 'kelompok_topik_tugas_akhir.id_topik', '=', 'topik.id')
                                                    ->where('id_kelompok', '=', $kelompok->id)
                                                    ->get();

                                            $kelompok_topik_tugas_akhir_final = null;
											$deskripsi_val = null;
                                            foreach ($kelompok_topik_tugas_akhir as $kelompok_topik_tugas_akhir) {
                                                $kelompok_topik_tugas_akhir_final = $kelompok_topik_tugas_akhir->judul;
												$deskripsi_val = $kelompok_topik_tugas_akhir->deskripsi;
                                            }
                                            if ($kelompok_topik_tugas_akhir_final == null) {
                                            ?>
                                            Kelompok anda belum memiliki topik tugas akhir, silahkan memilih topik tugas
                                            akhir <a href='../topik/lihat_selengkapnya'>disini</a>.
                                            <?php
                                            }else {
                                                echo $kelompok_topik_tugas_akhir_final;
                                            }
                                            ?>
                                        </li>
										<?php
										if ($kelompok_topik_tugas_akhir_final != null) {
										?>
										<li class="list-group-item">
                                            <span
                                                    class="text-danger">Deskripsi:
													<?php
													if($deskripsi_val!=NULL){
													?>
													<a class="btn btn-danger" href="<?php echo $deskripsi_val;?>" target="_blank" role=button">
															<span
															class="glyphicon glyphicon-download-alt"
															aria-hidden="true"></span> Unduh</a>
															<?php
															}
													?>
													</span>

                                        </li>
										<?php

										}
										?>
                                        <?php
                                        if ($kelompok_topik_tugas_akhir_final != null) {
                                        //ambil poster dan video produk
                                        $ambil_media = DB::table('topik_universitas')
                                                ->where('id_universitas', '=', Session::get('id_universitas'))
                                                ->where('id_kelompok', '=', $kelompok->id)
                                                ->get();

                                        $final_ambil_media = null;

                                        foreach ($ambil_media as $ambil_media) {
                                            $final_ambil_media = $ambil_media;
                                        }
                                        ?>
                                        <li class="list-group-item">
                                            <span
                                                    class="text-danger">Blog:</span>
                                            <?php
                                                    if($final_ambil_media->alamat_blog != null){
                                                    echo " <a href='".$final_ambil_media->alamat_blog."' target='_blank'>".$final_ambil_media->alamat_blog."</a>. (Perbaharui <a href='#' data-toggle='modal'
                                                   data-target='#perbaharui_alamat_blog'> disini</a>.)";
                                                   ?>
                                                    <div class="modal fade" id="perbaharui_alamat_blog" tabindex="-1"
                                                        role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title"
                                                                        id="myModalLabel">Perbaharui alamat blog</h4>
                                                                </div>
                                                                {!! Form::open(array('url'=>'topik/perbaharui_alamat_blog','method'=>'POST')) !!}

                                                                        <!--<form method="post" action="../mahasiswa/unggah_ktm" enctype="multipart/form-data">-->
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                                <input type="hidden" name="kelompok"
                                                                   value="<?php echo $kelompok->id;?>"/>
                                                                <div class="modal-body">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <input type="text" class="form-control"
                                                                               placeholder="Contoh: http://tadj.lskk.ee.itb.ac.id/"
                                                                               name="url_blog">
                                                                            </div>
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
                                                    }else {
                                                    echo " Kelompok anda belum menuliskan alamat blog tugas akhir.(Perbaharui <a href='#' data-toggle='modal'
                                                   data-target='#perbaharui_alamat_blog_a'> disini</a>.)";
                                                   ?>
                                                    <div class="modal fade" id="perbaharui_alamat_blog_a" tabindex="-1"
                                                        role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close"><span
                                                                                aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title"
                                                                        id="myModalLabel">Perbaharui alamat blog</h4>
                                                                </div>
                                                                {!! Form::open(array('url'=>'topik/perbaharui_alamat_blog','method'=>'POST')) !!}

                                                                        <!--<form method="post" action="../mahasiswa/unggah_ktm" enctype="multipart/form-data">-->
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                                <input type="hidden" name="kelompok"
                                                                   value="<?php echo $kelompok->id;?>"/>
                                                                <div class="modal-body">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <input type="text" class="form-control"
                                                                               placeholder="Contoh: http://tadj.lskk.ee.itb.ac.id/"
                                                                               name="url_blog">
                                                                            </div>
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
                                                    }
                                                    ?>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4" align="center">
                                                    <span
                                                            class="text-danger">Poster produk: </span>

                                                    <?php
                                                    if($final_ambil_media->lokasi_poster != null){
                                                    ?>
                                                    <!--<img src="<?php //echo '../' . $final_ambil_media->lokasi_poster;?>"
                                                         class="img-responsive">-->
													<img src="<?php echo $final_ambil_media->lokasi_poster;?>"
                                                         class="img-responsive">
                                                    <?php
                                                    }else {
                                                    ?>
                                                    <img src="../core/resources/assets/image/poster_produk_belum_diunggah.png"
                                                         class="img-responsive">

                                                    <?php
                                                    }
                                                    ?>
                                                    <br/>
                                                    <div class="row" align="left">
                                                        <div class="container">
                                                            {!! Form::open(array('url'=>'topik/unggah_poster_produk','method'=>'POST', 'files'=>true)) !!}
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>
                                                            <input type="hidden" name="kelompok"
                                                                   value="<?php echo $kelompok->id;?>"/>
                                                            {!! Form::file('poster') !!}
                                                            <br/>
                                                            <button class="btn btn-danger" type="submit">Submit</button>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1" align="center"><br/></div>
                                                <div class="col-md-7" align="center">
                                                    <span
                                                            class="text-danger">Video produk: </span>

                                                    <?php
                                                    if($final_ambil_media->lokasi_video_produk != null){
                                                    ?>
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <video class="embed-responsive-item" controls>
                                                            <source src="<?php echo $final_ambil_media->lokasi_video_produk;?>"
                                                                    type="video/mp4">
																	<!--<source src="<?php //echo '../' . $final_ambil_media->lokasi_video_produk;?>"
                                                                    type="video/mp4">-->
                                                        </video>
                                                    </div>
                                                    <?php
                                                    }else {
                                                    ?>
                                                    <img src="../core/resources/assets/image/video_produk_belum_diunggah.png"
                                                         class="img-responsive">
                                                    <?php
                                                    }
                                                    ?>

                                                    <br/>
                                                    <div class="row" align="left">
                                                        <div class="container">
                                                            {!! Form::open(array('url'=>'topik/unggah_video_produk','method'=>'POST', 'files'=>true)) !!}
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>
                                                            <input type="hidden" name="kelompok"
                                                                   value="<?php echo $kelompok->id;?>"/>
<input type="file" name="video">
                                                            <br/>
                                                            <button class="btn btn-danger" type="submit">Submit</button>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                            }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        }
        ?>
    </div>
@endsection
@section('additional_js')
	$('#table_id').DataTable({
		"pageLength": 30
	});

    function tampilkanSemua(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token' : $('meta[name=_token]').attr('content')}
            });

        $.ajax({
            url: '{{ url('/kelompok/tampilkan_semua') }}',
                                                type: 'get',
                                                data: {

                                                },

                                                success: function (data) {

                                                $('#load-kelompok').hide().fadeIn(2000).load('{{ url('/kelompok/tampilkan_semua') }}/<?php //echo  $konten->id_materi?>');

                                                }
                                                });
    }
@endsection
