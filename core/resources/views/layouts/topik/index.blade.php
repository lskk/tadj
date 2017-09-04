@extends('layouts.koleksi_master.heater')
@section('additional_css')
    form{
    font-weight:lighter;
    font-family:'Lato';
    font-size:'16px'
    }
    #nav-topik{
    color:#be272d;
    }
    .container{
    
    font-weight:lighter;
    }
    tr th{
		
    color: #bd000b;
    font-weight:lighter;
    text-align:center;
	
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
                                    if (Session::get('status') != NULL && Session::get('status') == 3) {//pengguna sebagai dosen
                                    ?>
                                    <li><a href="topik" id="nav-topik">Judul Tugas Akhir</a></li>
									<li><a href="{{url('/rekapitulasi/semua')}}">Rekapitulasi</a></li>
                                    <li><a href="bimbingan">Bimbingan</a></li>
									<li><a href="http://tadjblog.lskk.ee.itb.ac.id/" target = "_blank">Blog</a></li>
                                    <li>
								
								  <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
									<?php echo Session::get('nama');?>
									<span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li><a href="{{url('keluar')}}">Keluar</a></li>									
								  </ul>
								
								</li>
                                    <?php
                                    }else if(Session::get('status') != NULL && Session::get('status') == 2){//pengguna sebagai universitas
                                    ?>
                                    <li><a href="topik" id="nav-topik">Judul Tugas Akhir</a></li>
                                    <li><a href="kelompok">Kelompok</a></li>
                                    <li><a href="prodi" id="nav-prodi">Prodi</a></li>
                                    <li><a href="mahasiswa" id="nav-mahasiswa">Mahasiswa</a></li>
                                    <li><a href="dosen" id="nav-dosen">Dosen</a></li>
                                    <li>
								
								  <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
									<?php echo Session::get('nama');?>
									<span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li><a href="{{url('keluar')}}">Keluar</a></li>									
								  </ul>
								
								</li>
                                    <?php
                                    }else if(Session::get('status') == 1){//pengguna sebagai administrator
                                    ?>
                                    @yield('nav_link')
                                    <li><a href="admin/tambah_pengguna" id="nav-keluar">Pengguna</a></li>
                                    <li><a href="keluar" id="nav-keluar">Keluar</a></li>
                                    <?php
                                    }else {
                                    ?>
                                    <li><a href="../topik" id="nav-topik">Topik Tugas Akhir</a></li>
                                    <li><a href="mahasiswa/konfirmasi" id="nav-dashboard">Kelompok</a></li>
                                    <li><a href="../keluar" id="nav-keluar">Keluar</a></li>
                                    <?php
                                    }
                                    ?>


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
        //cek apakah pengguna sbg dosen yanng masuk sudah melakukan dikonfirmasi oleh universitasnya?
        $status_dosen = DB::table('dosen')
                ->where('id', '=', Session::get('id'))
                ->where('status_konfirmasi', '=', 1)
                ->count();

        //cek apakah pengguna sudah mengunggah foto profil atau sebaliknya
        $penggunggahan_photo = DB::table('pengguna')
                ->where('id', '=', Session::get('id_pengguna'))
                ->whereNotNull('photo_url')
                ->count();

        if(Session::get('status') == 3 && $status_dosen == 1){//apabila pengguna sebagai dosen
        ?>
        <div class="row">
            <div class="col-md-12">
			@if ( Session::has('tambah') )
			<div class="alert alert-success" role="alert">{{ Session::get('tambah') }}</div>
			@endif
			@if ( Session::has('ubah') )
			<div class="alert alert-success" role="alert">{{ Session::get('ubah') }}</div>
			@endif
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
					  <div class="panel-heading">
						<h3 class="panel-title">Tambah Judul</h3>
					  </div>
					  <div class="panel-body">
						<form method="post" action="proses_topik_masuk" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                    <div class="form-group input-group-md col-md-6">
                                        <input id="judul" type="text" name="judul" class="form-control"
                                               placeholder="Judul">
                                    </div>
                                    <div class="form-group input-group-md col-md-6">
                                        <span id="validasi_email"
                                              style="color:#be272d;font-size:15px;font-weight: 300;">Judul tugas akhir yang anda buat.</span>
                                        <input type="email" class="form-control" placeholder="Email"
                                               style="visibility: hidden;"><!--pemberi jarak-->
                                    </div>


                                    <div class="form-group input-group-md col-md-6">
                                        <select class="form-control" name="jenjang">
                                            <option value="">Jenjang</option>
                                            <option value="1">D1</option>
                                            <option value="2">D2</option>
                                            <option value="3">D3</option>
                                            <option value="4">D4</option>
                                            <option value="5">S1</option>
                                            <option value="6">S2</option>
                                            <option value="7">S3</option>
                                        </select>
                                    </div>
                                    <div class="form-group input-group-md col-md-6">
                                        <span id="validasi_jenjang"
                                              style="color:#be272d;font-size:15px;font-weight: 300;">Jenjang pendidikan untuk judul yang anda buat.</span>
                                        <input type="password" class="form-control" placeholder="Tulis Ulang Password"
                                               style="visibility: hidden;">
                                    </div>

                                    <div class="form-group input-group-md col-md-6">
                                        <input type="file" class="form-control" name="berkas">
                                    </div>
                                    <div class="form-group input-group-md col-md-6">
                                        <span id="validasi_email"
                                              style="color:#be272d;font-size:15px;font-weight: 300;">Unggah berkas deskripsi judul tugas akhir.</span>
                                        <input type="email" class="form-control" placeholder="Email"
                                               style="visibility: hidden;"><!--pemberi jarak-->
                                    </div>

                                    <br>

                                    <div class="form-group input-group-lg col-md-12">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </form>
                            
					  </div>
					</div>
					
					
					<div class="panel panel-default">
					  <div class="panel-heading">
						<h3 class="panel-title">Judul yang sudah anda buat</h3>
					  </div>
					  <div class="panel-body">
						<table id="table_id" class="table">
						<thead>
                                        <tr>
                                            <th>No</th>                                            
                                            <th>Judul</th>
                                            <th>Jenjang</th>
                                            <th>Deskripsi</th>
                                            <!--<th>Status</th>-->
                                            <th>Aksi</th>
                                        </tr>
										</thead>
										<tbody>
                                        <?php
                                        $number = 1;

                                        foreach ($topik as $a) {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number;?></td>                                            
                                            <td><?php echo $a->judul;?></td>
                                            <td align="center">
												
                                                <?php
                                                echo $a->detail_jenjang;?></td>
                                            </td>
                                            <td>
												<?php 
													if($a->deskripsi != NULL){
														?>
														<a href="<?php echo $a->deskripsi;?>" class="btn btn-danger" target="_blank">Unduh</a>
														<?php
													
													}else{
														echo '-';
													}
												?>
											</td>
                                            <!--<td align="center"><?php
                                                //if($a->id_status == 1){
                                                ?>
                                                <span class="label label-success">Aktif</span>
                                                <?php
                                                //}else{
                                                ?>
                                                <span class="label label-danger">Tidak Aktif</span>
                                                <?php
                                                //}?></td>-->
                                            <!-- status topik-->
                                            <td align="center">
												
                                                <a class="btn btn-default" href="" data-toggle="modal"
                                                   data-target="#ubah_topik<?php echo $a->id;?>">Ubah</a> 
												   <br/>
												   <br/>
                                                <a class="btn btn-info" href="" data-toggle="modal"
                                                   data-target="#bagikan_topik<?php echo $a->id;?>">Bagikan</a>
												
                                            </td>
                                        </tr>
                                        <!--modal-->
                                        <!--ubah topik-->
                                        <div class="modal fade" id="ubah_topik<?php echo $a->id;?>" tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="myModalLabel">Ubah</h4>
                                                    </div>
                                                    <form method="post" action="topik/update_topik" enctype="multipart/form-data">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                        <input type="hidden" name="id" value="<?php echo $a->id;?>"/>

                                                        <div class="modal-body">

                                                            <div class="row">
                                                                <div class="col-md-2">Judul:</div>
                                                                <div class="col-md-10">
                                                                    <div class="form-group input-group-md">
                                                                        <input type="text" class="form-control"
                                                                               placeholder="Judul"
                                                                               value="<?php echo $a->judul;?>"
                                                                               name="judul">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-2">Jenjang:</div>
                                                                <div class="col-md-10">
                                                                    <div class="form-group input-group-md">
                                                                        <select class="form-control" name="jenjang">
                                                                            <?php
                                                                            foreach($jenjang as $b){
                                                                            if($b->detail_jenjang == $a->detail_jenjang){
                                                                            ?>
                                                                            <option value="<?php echo $b->id;?>"
                                                                                    selected><?php echo $b->detail_jenjang;?></option>
                                                                            <?php
                                                                            }else{
                                                                            ?>
                                                                            <option value="<?php echo $b->id;?>"><?php echo $b->detail_jenjang;?></option>
                                                                            <?php
                                                                            }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-2">Deskripsi:</div>
                                                                <div class="col-md-10">
																	<input type="file" name="berkas"/>
                                                                </div>
                                                            </div>                                                            														
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-danger">Simpan
                                                                perubahan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!--bagikan topik-->
                                        <div class="modal fade" id="bagikan_topik<?php echo $a->id;?>" tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="myModalLabel">Bagikan</h4>
                                                    </div>
                                                    <form method="post" action="topik/bagikan">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                        <input type="hidden" name="id" value="<?php echo $a->id;?>"/>
                                                        <input type="hidden" name="judul"
                                                               value="<?php echo $a->judul;?>"/>

                                                        <div class="modal-body">                                                           
                                                            <div class="row">
                                                                <div class="col-md-2">Judul:</div>
                                                                <div class="col-md-10">
                                                                    <?php echo $a->judul;?>
                                                                </div>
                                                            </div>
															<br/>
															<div class="row">
                                                                <div class="col-md-2">Jenjang:</div>
                                                                <div class="col-md-10"><?php echo $a->jenjang;?>
                                                                </div>
                                                            </div>
															<br/>
                                                            <div class="row">
                                                                <div class="col-md-2">Deskripsi:</div>
                                                                <div class="col-md-10">
																	<?php 
																		if($a->deskripsi == NULL){
																			echo '-';
																		}else{
																			echo "<a href='".$a->deskripsi."' target='_blank' class='btn btn-danger'>Unduh</a>";
																		}
																		
																	?>
                                                                </div>
                                                            </div>
															<br/>
                                                            <div class="row">
                                                                <div class="col-md-2">Pilih universitas tujuan:</div>
                                                                <div class="col-md-10">
                                                                    <select class="form-control" name="universitas">
                                                                        <option value="">-</option>
                                                                        <?php
                                                                        foreach ($universitas as $u) {
                                                                        ?>
                                                                        <option value="<?php echo $u->id_universitas;?>"><?php echo $u->nama;?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-danger">Bagikan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- end of modal -->

                                        <?php
                                        $number++;
                                        }
                                        ?>
										</tbody>
                                    </table>
					  </div>
					</div>
					
                    
                </div>
            </div>
        </div>
        <?php
        }
        else if(Session::get('status') == 3 && $status_dosen == 0 && $penggunggahan_photo == 0){
        echo "Anda belum dianggap dosen di universitas/ institusi asal anda.  Silahkan unggah scan foto kartu tanda pengajar anda <a href='#' data-toggle='modal'
                                                   data-target='#unggah_ktp'> disini</a>.<br/><br/>";
        ?>
        <div class="modal fade" id="unggah_ktp" tabindex="-1"
             role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"
                            id="myModalLabel">Unggah Kartu Tanda Pengajar</h4>
                    </div>
                    {!! Form::open(array('url'=>'dosen/unggah_ktp','method'=>'POST', 'files'=>true)) !!}

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
        }else if(Session::get('status') == 3 && $status_dosen == 0 && $penggunggahan_photo == 1){
            $universitas = DB::table('pengguna')
                    ->join('universitas', 'pengguna.id', '=', 'universitas.id_pengguna')
                    ->where('universitas.id', '=', Session::get('id_universitas'))
                    ->get();
            $nama_universitas = null;
            foreach ($universitas as $universitas) {
                $nama_universitas = $universitas->nama;
            }
            echo 'Sedang dalam pemeriksaan bahwa anda dosen universitas ' . $nama_universitas . '.<br/><br/>';
        }else if(Session::get('status') == 2){//pengguna sebagai universitas
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    Daftar Topik Keseluruhan
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table" id="table_id">
									<thead>
                                        <tr class="danger">
                                            <th>No</th>
                                            <!--<th>No TA</th>-->
                                            <th>Judul</th>
                                            <th>Pembimbing</th>
                                            <th>Tahun Ajaran</th>
											<th>Semester</th>
                                            <th>Prodi</th>
                                            <th>Jenjang</th>
                                            <th>Kuota</th>
                                            <!--<th>Status</th>-->
                                            <th>Aksi</th>
                                        </tr>
										</thead>
										<tbody>
                                        <?php
                                        $number = 1;
										
                                        foreach ($topik as $topik) {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number;?></td>
                                            <!--<td align="center"><?php //echo $topik->no_ta;?></td>-->
                                            <td><?php echo $topik->judul;?></td>
                                            <td align="left">
                                                <?php
                                                $pembimbing = DB::table('pengguna')
                                                        ->select('*')
                                                        ->join('dosen', 'pengguna.id', '=', 'dosen.id_pengguna')
                                                        ->join('pembimbing', 'dosen.id', '=', 'pembimbing.id_dosen')
                                                        ->where('pembimbing.id_topik', $topik->id_topik)
                                                        ->where('pembimbing.id_universitas', '=', Session::get('id_pengguna_universitas'))
                                                        ->get();
                                                $counter = 1;
                                                foreach ($pembimbing as $pem) {
                                                    echo $counter . '. ' . $pem->nama_depan.' '.$pem->nama_belakang. '<br/><br/>';
                                                    $counter++;
                                                }
                                                ?></td>
                                            </td>
                                            <td align="center"><?php
                                                $tahun_ajaran = DB::table('tahun_aktif_topik')
                                                        ->select('tahun_ajaran')
                                                        ->where('id_universitas', Session::get('id_pengguna_universitas'))
                                                        ->where('id_topik', '=', $topik->id_topik)
                                                        ->get();
                                                $final_tahun_ajaran = null;
                                                foreach ($tahun_ajaran as $tahun_ajaran) {
                                                    $final_tahun_ajaran = $tahun_ajaran->tahun_ajaran;
                                                }

                                                if ($final_tahun_ajaran == null) {
                                                    echo 'belum diatur';
                                                } else {
                                                    echo $topik->tahun_ajaran;
                                                }
                                                ?>
                                            </td>
											<td>
												<?php 
													$semester = DB::table('topik_semester')
																->select('id_semester')
																->where('id_topik','=',$topik->id_topik)
																->where('id_universitas', '=', Session::get('id_pengguna_universitas'))
																->get();
													
													$semester_val = NULL;
													
													foreach($semester as $semester){
														$semester_val = $semester->id_semester;
													}			
                                                    
													if($semester_val == 0){
														echo '-';
													}else{
														if($semester_val == 1){
															echo 'Ganjil';
														}else{
															echo 'Genap';
														}
													}													
												?>
											</td>
                                            <td align="center">
                                                <?php
                                                echo $topik->detail_prodi;
                                                ?>
                                            </td>
                                            <td align="center">
                                                <?php
                                                echo $topik->jenjang;
                                                ?>
                                            </td>
                                            <td align="center">
                                                <?php
                                                echo $topik->jumlah;
                                                ?>
                                            </td>
                                            <!--<td align="center">
                                                <?php
                                                //if ($topik->id_status == 1) {
                                                ?>
                                                <span class="label label-success">Aktif</span>
                                                <?php
                                                //} else {
                                                ?>
                                                <span class="label label-danger">Tidak Aktif</span>
                                                <?php
                                                //}
                                                ?>
                                            </td>-->
                                            <td align="center">
                                                <?php
                                                if($topik->id_status == 1){
                                                ?>
                                                <a class="btn btn-default" href="" data-toggle="modal"
                                                   data-target="#ubah_topik<?php echo $topik->id_topik;?>">Ubah</a>
                                                <br/>
                                                <br/>
                                                <?php
                                                $status_bagikan = DB::table('topik_universitas')
                                                        ->where('id_topik', '=', $topik->id_topik)
                                                        ->where('id_universitas', '=', Session::get('id_pengguna_universitas'))
                                                        ->count();

                                                if($status_bagikan != 0){
                                                    ?>
                                                    <?php
                                                }else{
                                                ?>
                                                <a class="btn btn-info" href="" data-toggle="modal"
                                                   data-target="#bagikan_pada_daftar_topik<?php echo $topik->id_topik;?>">Bagikan
                                                    pada daftar topik universitas</a>
                                                <?php }?>
                                                <?php
                                                }else{
                                                ?>
                                                -
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <!--modal-->
                                        <!--ubah topik-->
                                        <div class="modal fade" id="ubah_topik<?php echo $topik->id_topik;?>"
                                             tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="myModalLabel"><?php echo $topik->judul;?></h4>
                                                    </div>

                                                    <div class="modal-body">
														<!--<form action="{{url('/topik/no_ta/ubah')}}" method="post">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>
                                                            <input type="hidden" name="id_topik"
                                                                   value="<?php echo $topik->id_topik;?>">
															<input type="hidden" name="id_universitas"
                                                                   value="<?php echo Session::get('id_pengguna_universitas');?>">
                                                            <div class="row">
                                                                <div class="col-md-2">No TA
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="no_ta" value=""/>
                                                                    <br/>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        Ubah
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <hr/>-->
                                                        <form action="topik/pembimbing/tambah" method="post">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>
                                                            <input type="hidden" name="id_topik"
                                                                   value="<?php echo $topik->id_topik;?>">

                                                            <div class="row">
                                                                <div class="col-md-2">Tambah Pembimbing:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <select class="form-control"
                                                                            name="dosen_pembimbing">
                                                                        <?php
                                                                        foreach ($dosen as $d) {
                                                                        ?>
                                                                        <option value="<?php echo $d->id_dosen;?>"><?php echo $d->nama_depan.' '.$d->nama_belakang;?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <br/>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        Tambah
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <hr/>
                                                        <form action="topik/update_universitas" method="post">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>
															<input type="hidden" name="id_universitas"
                                                                   value="<?php echo Session::get('id_pengguna_universitas');?>">	   
                                                            <input type="hidden" name="id_topik"
                                                                   value="<?php echo $topik->id_topik;?>">
                                                            <?php
                                                            if($topik->tahun_ajaran == 0){
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-2">Tahun Ajaran:
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select class="form-control"
                                                                            name="tahun_ajaran_awal">
                                                                        <?php
                                                                        foreach ($tahun as $t) {
                                                                        if($t->detail_tahun == 'tidak aktif'){
                                                                        ?>
                                                                        <option value=""><?php echo 'belum diatur';?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $t->detail_tahun;?>"><?php echo $t->detail_tahun;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-1">/
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select class="form-control"
                                                                            name="tahun_ajaran_akhir">
                                                                        <?php
                                                                        foreach ($tahun as $t) {
                                                                        if($t->detail_tahun == 'tidak aktif'){
                                                                        ?>
                                                                        <option value=""><?php echo 'belum diatur';?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $t->detail_tahun;?>"><?php echo $t->detail_tahun;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            }else{
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-2">Tahun Ajaran:
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select class="form-control"
                                                                            name="tahun_ajaran_awal">
                                                                        <?php
                                                                        foreach ($tahun as $t) {
                                                                        if($t->detail_tahun == 'tidak aktif'){
                                                                        ?>
                                                                        <option value=""><?php echo 'belum diatur';?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $t->detail_tahun;?>"><?php echo $t->detail_tahun;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    /
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select class="form-control"
                                                                            name="tahun_ajaran_akhir">
                                                                        <?php
                                                                        foreach ($tahun as $t) {
                                                                        if($t->detail_tahun == 'tidak aktif'){
                                                                        ?>
                                                                        <option value=""><?php echo 'belum diatur';?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $t->detail_tahun;?>"><?php echo $t->detail_tahun;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            }
                                                            ?>
															<br/>
															<div class="row">
																<div class="col-md-2">Semester:
                                                                </div>
                                                                <div class="col-md-10">
																	<select class="form-control"
                                                                            name="semester">
																		<option value="1">Ganjil</option>
																		<option value="2">Genap</option>																		
																	</select>		
																</div>
															</div>
                                                            <br/>

                                                            <div class="row">
                                                                <div class="col-md-2">Prodi:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <select class="form-control"
                                                                            name="prodi">
                                                                        <?php
																		$prodi_universitas = DB::table('prodi')
																					->join('prodi_universitas','prodi.id','=','prodi_universitas.id_prodi')
																					->orderBy('detail_prodi', 'asc')
																					->where('prodi_universitas.id_universitas','=', Session::get('id_pengguna_universitas'))
																					->get();
                                                                        foreach ($prodi_universitas as $p) {
                                                                        
                                                                        ?>
                                                                        <option value="<?php echo $p->id;?>"><?php echo $p->detail_prodi;?></option>
                                                                        
                                                                        <?php } ?>
                                                                    </select>
                                                                    <br/>
                                                                    <!--<button type="submit" class="btn btn-danger">Ubah
                                                                    </button>-->
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-2">Kuota:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <select class="form-control"
                                                                            name="kuota">
                                                                        <?php
                                                                        foreach ($kuota as $k) {
                                                                        if($k->detail_kuota == $topik->jumlah){
                                                                        ?>
                                                                        <option value="<?php echo $k->id;?>"
                                                                                selected><?php echo $k->detail_kuota;?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $k->id;?>"><?php echo $k->detail_kuota;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                    <br/>
                                                                    <button type="submit" class="btn btn-danger">Ubah
                                                                    </button>
                                                                </div>

                                                            </div>


                                                        </form>
                                                        <br/>

                                                        <div class="modal-footer">
                                                            <button type="submit" style="visibility: hidden;">a</button>
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Tutup
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!--bagikan topik universitas-->
                                        <div class="modal fade"
                                             id="bagikan_pada_daftar_topik<?php echo $topik->id_topik;?>"
                                             tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="myModalLabel">Konfirmasi</h4>
                                                    </div>

                                                    <div class="modal-body">
                                                        Apakah anda yakin akan membagikan topik:
                                                        <br/>
                                                        <br/>

                                                        <form action="topik/bagikan/universitas" method="post">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>
                                                            <input type="hidden" name="id_topik"
                                                                   value="<?php echo $topik->id_topik;?>">
                                                            <input type="hidden" name="prodi"
                                                                   value="<?php echo $topik->id_prodi;?>">
                                                            <input type="hidden" name="jenjang"
                                                                   value="<?php echo $topik->id_jenjang;?>">
                                                            <input type="hidden" name="tahun_ajaran"
                                                                   value="<?php echo $topik->tahun_ajaran;?>">
															<?php 
																$semester = DB::table('topik_semester')																					
																					->select('id_semester')
																					->where('id_universitas','=',Session::get('id_pengguna_universitas'))
																					->where('id_topik','=',$topik->id_topik)
																					->get();
																		$semester_val = NULL;
																		foreach($semester as $semester){
																			$semester_val = $semester->id_semester;
																		}
															?>				
															<input type="hidden" name="semester" value="<?php echo $semester_val;?>">	
                                                            
                                                            <div class="row">
                                                                <div class="col-md-2">Judul:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <?php  echo $topik->judul;?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-2">Prodi:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <?php  
																	$prodi = DB::table('prodi')
																				->select('*')
																				->where('id','=',$topik->id_prodi)
																				->get();
																				
																		$prodi_val = NULL;		
																		foreach($prodi as $prodi_1){
																			$prodi_val = $prodi_1->detail_prodi;
																		}
																		echo $prodi_val;	
																	?>
                                                                </div>
                                                            </div>
															<div class="row">
                                                                <div class="col-md-2">Jenjang:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <?php  echo $topik->jenjang;?>
                                                                </div>
                                                            </div>
															<div class="row">
                                                                <div class="col-md-2">Tahun Ajaran:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <?php  echo $topik->tahun_ajaran;?>
                                                                </div>
                                                            </div>
															<div class="row">
                                                                <div class="col-md-2">Semester:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <?php  
																		$semester = DB::table('topik_semester')
																					->select('id_semester')
																					->where('id_universitas','=',Session::get('id_pengguna_universitas'))
																					->where('id_topik','=',$topik->id_topik)
																					->get();
																		$semester_val = NULL;
																		foreach($semester as $semester){
																			$semester_val = $semester->id_semester;
																		}
																		if($semester_val == 1){
																			echo "Ganjil";
																		}else if($semester_val == 2){
																			echo "Genap";
																		}else{
																				echo "-";
																		}
																		
																	?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-2">Deskripsi:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <?php  
																	if($topik->deskripsi != NULL){
																	echo "<a href='".$topik->deskripsi."' class='btn btn-danger'>Unduh</a>";
																	}
																	?>
                                                                </div>
                                                            </div>

                                                            <br/>

                                                            <div class="modal-footer">

                                                                <button type="submit" class="btn btn-danger">
                                                                    Bagikan
                                                                </button>
                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Batal
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- end of modal -->

                                        <?php
                                        $number++;
                                        }
                                        ?>
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                                   aria-expanded="false" aria-controls="collapseTwo">
                                    Topik Universitas
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table" id="table_id_2">
									<thead>
                                        <tr class="danger">
                                            <th>No</th>
                                            <!--<th>No Topik</th>-->
                                            <th>Judul</th>
                                        </tr>
										</thead>
										<tbody>
                                        <?php
                                        $number = 1;

                                        foreach ($topik_universitas as $tu) {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number;?></td>
                                            <!--<td align="center"><?php echo $tu->no_topik;?></td>-->
                                            <td><?php echo $tu->judul;?></td>

                                            </td>
                                        </tr>
                                        <!--modal-->
                                        <!--ubah topik-->
                                        <div class="modal fade" id="ubah_topik<?php echo $topik->no_topik;?>"
                                             tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="myModalLabel"><?php echo $topik->judul;?></h4>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form action="topik/pembimbing/tambah" method="post">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>
                                                            <input type="hidden" name="id_topik"
                                                                   value="<?php echo $topik->id_topik;?>">

                                                            <div class="row">
                                                                <div class="col-md-2">Tambah Pembimbing:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <select class="form-control"
                                                                            name="dosen_pembimbing">
                                                                        <?php
                                                                        foreach ($dosen as $d) {
                                                                        ?>
                                                                        <option value="<?php echo $d->id_dosen;?>"><?php echo $d->nama_dosen;?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <br/>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        Tambah
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <hr/>
                                                        <form action="topik/update_universitas" method="post">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>
                                                            <input type="hidden" name="id_topik"
                                                                   value="<?php echo $topik->id_topik;?>">
                                                            <?php
                                                            if($topik->tahun_ajaran == 0){
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-2">Tahun Ajaran:
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select class="form-control"
                                                                            name="tahun_ajaran_awal">
                                                                        <?php
                                                                        foreach ($tahun as $t) {
                                                                        if($t->detail_tahun == 'tidak aktif'){
                                                                        ?>
                                                                        <option value=""><?php echo 'belum diatur';?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $t->detail_tahun;?>"><?php echo $t->detail_tahun;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-1">/
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select class="form-control"
                                                                            name="tahun_ajaran_akhir">
                                                                        <?php
                                                                        foreach ($tahun as $t) {
                                                                        if($t->detail_tahun == 'tidak aktif'){
                                                                        ?>
                                                                        <option value=""><?php echo 'belum diatur';?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $t->detail_tahun;?>"><?php echo $t->detail_tahun;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            }else{
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-2">Tahun Ajaran:
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select class="form-control"
                                                                            name="tahun_ajaran_awal">
                                                                        <?php
                                                                        foreach ($tahun as $t) {
                                                                        if($t->detail_tahun == 'tidak aktif'){
                                                                        ?>
                                                                        <option value=""><?php echo 'belum diatur';?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $t->detail_tahun;?>"><?php echo $t->detail_tahun;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    /
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <select class="form-control"
                                                                            name="tahun_ajaran_akhir">
                                                                        <?php
                                                                        foreach ($tahun as $t) {
                                                                        if($t->detail_tahun == 'tidak aktif'){
                                                                        ?>
                                                                        <option value=""><?php echo 'belum diatur';?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $t->detail_tahun;?>"><?php echo $t->detail_tahun;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            }
                                                            ?>
                                                            <br/>
															<div class="row">
																<div class="col-md-2">Semester:
                                                                </div>
                                                                <div class="col-md-10">
																	<select class="form-control"
                                                                            name="semester">
																		<option value="1">Ganjil</option>
																		<option value="2">Genap</option>																		
																	</select>		
																</div>
															</div>
															<br/>
                                                            <div class="row">
                                                                <div class="col-md-2">Prodi:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <select class="form-control"
                                                                            name="prodi">
                                                                        <?php
                                                                        foreach ($prodi as $p) {
                                                                        if($p->detail_prodi == $topik->detail_prodi){
                                                                        ?>
                                                                        <option value="<?php echo $p->id;?>"
                                                                                selected><?php echo $p->detail_prodi;?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $p->id;?>"><?php echo $p->detail_prodi;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                    <br/>
                                                                    <!--<button type="submit" class="btn btn-danger">Ubah
                                                                    </button>-->
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-2">Kuota:
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <select class="form-control"
                                                                            name="kuota">
                                                                        <?php
                                                                        foreach ($kuota as $k) {
                                                                        if($k->detail_kuota == $topik->jumlah){
                                                                        ?>
                                                                        <option value="<?php echo $k->id;?>"
                                                                                selected><?php echo $k->detail_kuota;?></option>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <option value="<?php echo $k->id;?>"><?php echo $k->detail_kuota;?></option>
                                                                        <?php }} ?>
                                                                    </select>
                                                                    <br/>
                                                                    <button type="submit" class="btn btn-danger">Ubah
                                                                    </button>
                                                                </div>

                                                            </div>


                                                        </form>
                                                        <br/>

                                                        <div class="modal-footer">
                                                            <button type="submit" style="visibility: hidden;">a</button>
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Tutup
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- end of modal -->

                                        <?php
                                        $number++;
                                        }
                                        ?>
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }else if (Session::get('status') == 4) {
            ?>

           <?php
        }?>
		
		

    </div>
@endsection

@section('additional_js')
	$('#table_id,#table_id_2').DataTable({
		"pageLength": 5
	});
@endsection