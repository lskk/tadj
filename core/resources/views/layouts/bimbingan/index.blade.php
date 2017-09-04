@extends('layouts.koleksi_master.heater')
@if ( Session::has('bimbingan') )
@section('additional_js')
    $(document).ready(function(){
    sweetAlert("Bimbingan berhasil!","{!! session('bimbingan') !!}","success")
    });
@endsection
@endif


@section('additional_css')
    td{
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
                                    <a href="dashboard"><img
                                                src="core/resources/assets/image/halaman_utama/logo.png"
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
                                    if(Session::get('status') == 4){//mahasiswa
                                    ?>
                                    <li><a href="topik/lihat_selengkapnya" id="nav-topik">Judul Tugas Akhir</a></li>
                                    <li><a href="mahasiswa/konfirmasi" id="nav-dashboard">Kelompok</a></li>
                                    <li><a href="bimbingan" style="color:#be272d;">Bimbingan</a></li>
									<li><a href="http://tadjblog.lskk.ee.itb.ac.id/" target = "_blank">Blog</a></li>
                                    
                                    <?php
                                    }else if(Session::get('status') == 3){//dosen
                                    ?>
                                    <li><a href="topik">Judul Tugas Akhir</a></li>
									<li><a href="{{url('/rekapitulasi/semua')}}">Rekapitulasi</a></li>
                                    <li><a href="bimbingan" style="color:#bd000b;">Bimbingan</a></li>
									<li><a href="http://tadjblog.lskk.ee.itb.ac.id/" target = "_blank">Blog</a></li>
                                    
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
		
        <?php
        if (Session::get('status') == 4) {//mahasiswa

        $cek_konfirmasi = DB::table('mahasiswa')
                ->select('status_konfirmasi')
                ->where('id', '=', Session::get('id_pengguna_mahasiswa'))
                ->where('status_konfirmasi', '=', 1)
                ->count();
        if ($cek_konfirmasi == 0) {
        ?>
        <div class="row">
            <div class="col-md-12">
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
                                $status = "<div class='alert alert-danger' role='alert' style='margin-right:2em;'>Anda belum dianggap mahasiswa " . $nama_universitas->nama . ". Segeralah lakukan konfirmasi dengan menggungah foto berupa hasil scan kartu mahasiswa anda <a href = '#' data-toggle='modal'
                                                   data-target='#unggah_ktm'>disini</a></div>";
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
                            } else if ($cek_konfirmasi == 0) {
                                $status = "<span style = 'font-weight: lighter;'>Sedang dalam pemeriksaan bahwa anda mahasiswa " . $nama_universitas->nama . "</span>";
                            }
							echo $status;
                            ?>
							<br/>
							<br/>
							
            </div>
        </div>
        <?php
        } else {
            if($pembimbing == NULL){
        ?>
        <div class="row">
            Anda belum memilih judul tugas akhir, silahkan ambil <a href='topik/lihat_selengkapnya'>disini.</a>
			
        </div>
		<br/>
        <?php 
        }else{
        ?>
		<!--<div class="alert alert-danger" role="alert">Data dosen pembimbing akan segera di perbaharui, daftar dosen dibawah masih dosen pengusul Judul TA.</div>-->
        <div class="row">
            <div class="col-md-12">
                <span class="text-danger">Pembimbing</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group">
                    <?php
                    foreach ($pembimbing as $pembimbing) {
                    ?>
                    <li class="list-group-item">
                        <span style="color:#BE272D;">Ke-<?php echo $pembimbing->pembimbing_ke . ': </span>' .$pembimbing->nama_depan.' '.$pembimbing->nama_belakang.' - '.$pembimbing->email;?></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span class="text-danger">Kemajuan</span>
                    <br/>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $count_tahap = 0;
                        foreach ($tahap as $tahap) {
                        ?>
                        <li role="presentation"><a href="#nav-tabs<?php echo $tahap->tahap;?>"
                                                   aria-controls="nav-tabs<?php echo $tahap->id;?>" role="tab"
                                                   data-toggle="tab">Tahap <?php echo $tahap->tahap;?></a></li>
                        <?php
                        $count_tahap++;
                        }
                        ?>
                                <!-- tombol tambah -->
                        <?php 
                        //id topik
                        $id_topik_kelompoka = DB::table('kelompok_topik_tugas_akhir')
                        ->select('*')
                        ->where('id_kelompok', '=', Session::get('id_kelompok_ta'))
                        ->get();   
                                            $id_topik = null;
                                foreach ($id_topik_kelompoka as $id_topik_kelompok2) {
                                    $id_topik = $id_topik_kelompok2->id_topik;
                                }
                        //kondisi bahwa tombol tambah ditampilkan
                        
                        if($count_tahap < 5) {
                        ?>                                
                        <li role="presentation">
                            <form method="post" action="bimbingan/tambah_tahap">                            
                                <input type="hidden" name="_token"
                                       value="{{ csrf_token() }}"/>
                                <input type="hidden" name="topik"
                                       value="<?php echo $id_topik;?>"/>
                                <input type="hidden" name="kelompok"
                                       value="<?php echo Session::get('id_kelompok_ta');?>"/>
                                <button type="submit" class="btn btn-default" style="border: 0px hidden"><span
                                            class="glyphicon glyphicon-plus text-danger"
                                            aria-hidden="true"></span></button>(maksimal 5 tahap)
                            </form>
                        </li>
                        <?php 
                    }
                        ?>                                
                        <!-- akhir tombol tambah -->
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php
                        //ambil id kelompok
                        $kelompok = DB::table('kelompok')
                                ->select('kelompok.no_kelompok as no_kelompok', 'kelompok.id as id')
                                ->join('kelompok_mahasiswa', 'kelompok.id', '=', 'kelompok_mahasiswa.id_kelompok')
                                ->where('kelompok_mahasiswa.id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
                                ->get();

                        $id_kelompok = null;

                        foreach ($kelompok as $kelompok) {
                            $id_kelompok = $kelompok->id;
                        }

                        foreach ($tahap2 as $tahap2) {
                        ?>
                        <div role="tabpanel" class="tab-pane" id="nav-tabs<?php echo $tahap2->tahap;?>">
                            <br/>
                            <a class="btn btn-danger" data-toggle="modal"
                               data-target="#lakukan_bimbingan<?php echo $tahap2->tahap;?>">Laporan Kemajuan</a>
                            <!-- Lakukan bimbingan -->
                            <div class="modal fade" id="lakukan_bimbingan<?php echo $tahap2->tahap;?>" tabindex="-1"
                                 role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Lakukan bimbingan
                                                tahap <?php echo $tahap2->tahap;?></h4>
                                        </div>
                                        <form method="post" action="bimbingan/tambah_bimbingan"
                                              enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" name="_token"
                                                       value="{{ csrf_token() }}"/>
                                                <input type="hidden" name="topik" value="<?php echo $id_topik;?>">
                                                <input type="hidden" name="kelompok" value="<?php echo $id_kelompok;?>">
                                                <input type="hidden" name="tahap" value="<?php echo $tahap2->tahap;?>">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                                           placeholder="Judul Bimbingan" name="judul">
                                                </div>
                                                <div class="form-group">
                                                    <input placeholder="Tanggal Bimbingan" type="text"
                                                           onfocus="(this.type='date')" class="form-control"
                                                           id="exampleInputEmail1" name="tanggal">
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control"
                                                              placeholder="Permasalahan" name="permasalahan"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control"
                                                              placeholder="Penyelesaian" name="penyelesaian"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <select name="pembimbing" class="form-control">
                                                        <option value="" disabled selected>Pilih pembimbing</option>
                                                        <?php
                                                        foreach ($pembimbing2 as $pembimbinga) {
                                                        ?>
                                                        <option value="<?php echo $pembimbinga->id_dosen;?>"><?php echo $pembimbinga->nama_depan.' '.$pembimbinga->nama_belakang;?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Unggah berkas kemajuan <span
                                                                class="text-danger">(berkas dapat berupa dokumen atau dokumentasi berupa gambar atau video)</span></label>
                                                    <input type="file" id="exampleInputFile" title=" " name="berkas">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                                </button>
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--Akhir lakukan bimbingan-->
                            <br/>
                            <br/>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr class="danger">
                                        <td>Judul</td>
                                        <td>Tanggal</td>
                                        <td>Pembimbing ke</td>
                                        <td>Permasalahan</td>
                                        <td>Penyelesaian</td>
                                        <td>Berkas bimbingan</td>
                                        <td>Status Bimbingan</td>
                                        <td>Revisi</td>
                                        <td>Berkas revisi</td>
                                    </tr>
                                    <?php
                                    //ambil detail bimbingan
                                    $query_detail_bimbingan = DB::table('bimbingan_detail')
                                            ->select('*', 'bimbingan_detail.id as id_bimbingan_detail')
                                            ->join('bimbingan_tahap', 'bimbingan_detail.tahap', '=', 'bimbingan_tahap.tahap')
                                            ->where('bimbingan_detail.tahap', '=', $tahap2->tahap)
                                            ->where('bimbingan_detail.id_universitas', '=', Session::get('id_universitas'))
                                            ->where('bimbingan_detail.id_topik', '=', $tahap2->id_topik)
                                            ->where('bimbingan_tahap.id_kelompok', '=', Session::get('id_kelompok_ta'))
                                            ->orderBy('bimbingan_detail.tanggal', 'desc')
                                            ->distinct()
                                            ->get();

                                    $detail_bimbingan = null;
                                    foreach ($query_detail_bimbingan as $query_detail_bimbingan) {
                                    $detail_bimbingan = $query_detail_bimbingan;
                                    ?>
                                    <tr>
                                        <td><?php echo $detail_bimbingan->judul;?></td>
                                        <td><?php echo $detail_bimbingan->tanggal;?></td>
                                        <td>
                                            <?php
                                            //menentukan pembimbing ke- berdasarkan id dosen
                                            $pembimbing_ke = DB::table('pembimbing')
                                                    ->where('id_universitas', '=', Session::get('id_universitas'))
                                                    ->where('id_topik', '=', $detail_bimbingan->id_topik)
                                                    ->where('id_dosen', '=', $detail_bimbingan->id_dosen_pembimbing)
                                                    ->get();

                                            $final_pembimbing_ke = null;
                                            foreach ($pembimbing_ke as $pembimbing_ke) {
                                                $final_pembimbing_ke = $pembimbing_ke->pembimbing_ke;
                                            }
                                            echo $final_pembimbing_ke;
                                            ?>

                                            <?php
                                            ?>
                                        </td>
                                        <td><a class="btn btn-default" style="border: 0px hidden;" data-toggle="modal"
                                               data-target="#permasalahan<?php echo $detail_bimbingan->id_bimbingan_detail;?>"><span
                                                        class="glyphicon glyphicon-search text-danger"
                                                        aria-hidden="true"></span></a></td>
                                        <td>
                                            <?php
                                            if($detail_bimbingan->penyelesaian == null || $detail_bimbingan->penyelesaian == ''){
                                                echo '-';
                                            }else{
                                            ?>
                                            <a class="btn btn-default" style="border: 0px hidden;" data-toggle="modal"
                                               data-target="#penyelesaian<?php echo $detail_bimbingan->id_bimbingan_detail;?>"><span
                                                        class="glyphicon glyphicon-search text-danger"
                                                        aria-hidden="true"></span></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($detail_bimbingan->lokasi_berkas_bimbingan == null || $detail_bimbingan->lokasi_berkas_bimbingan == ''){
                                                echo '-';
                                            }else{
                                            ?>
                                            <a class="btn btn-default" style="border: 0px hidden;" target="_blank"
                                               href="<?php echo $detail_bimbingan->lokasi_berkas_bimbingan;?>"><span
                                                        class="glyphicon glyphicon-download-alt text-danger"
                                                        aria-hidden="true"></span></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                            switch ($detail_bimbingan->status_bimbingan) {
                                                case 0:
                                                    echo "<span class = 'text-info'>belum diperiksa</span>";
                                                    break;
                                                case 1:
                                                    echo "<span class = 'text-danger'>sudah diperiksa</span>";
                                                    break;
                                            }
                                            ?></td>
                                        <td>
                                            <?php
                                            if($detail_bimbingan->revisi == null || $detail_bimbingan->revisi == ''){
                                                echo '-';
                                            }else{
                                            ?>
                                            <a class="btn btn-default" style="border: 0px hidden;" data-toggle="modal"
                                               data-target="#revisi<?php echo $detail_bimbingan->id_bimbingan_detail;?>"><span
                                                        class="glyphicon glyphicon-search text-danger"
                                                        aria-hidden="true"></span></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($detail_bimbingan->lokasi_berkas_revisi == null || $detail_bimbingan->lokasi_berkas_revisi == ''){
                                                echo '-';
                                            }else{
                                            ?>
                                            <a class="btn btn-default" style="border: 0px hidden;" href="<?php echo $detail_bimbingan->lokasi_berkas_revisi;?>" target="_blank"><span
                                                        class="glyphicon glyphicon-search text-danger"
                                                        aria-hidden="true"></span></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <!--Modal yang digunakan dalam detail bimbingan-->
                                    <!-- Permasalahan-->
                                    <div class="modal fade"
                                         id="permasalahan<?php echo $detail_bimbingan->id_bimbingan_detail;?>"
                                         tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel"><span class="text-danger">Permasalahan</span>
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo $detail_bimbingan->permasalahan;?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Akhir permasalahan-->
                                    <!--Penyelesaian-->
                                    <div class="modal fade"
                                         id="penyelesaian<?php echo $detail_bimbingan->id_bimbingan_detail;?>"
                                         tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel"><span class="text-danger">Penyelesaian</span>
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo $detail_bimbingan->penyelesaian;?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir penyelesaian-->
                                    <!--Revisi-->
                                    <div class="modal fade"
                                         id="revisi<?php echo $detail_bimbingan->id_bimbingan_detail;?>"
                                         tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel"><span class="text-danger">Penyelesaian</span>
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo $detail_bimbingan->revisi;?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Akhir Revisi-->
                                    <!--Akhir modal yang digunakan dalam detail bimbingan-->
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
        <br/>
        <?php
        }
        }
        } else if (Session::get('status') == 3) {//dosen
        ?>
		@if ( Session::has('diperiksa') )
		<div class="alert alert-success" role="alert">{{ Session::get('diperiksa') }}</div>
		@endif
		@if ( Session::has('direvisi') )
		<div class="alert alert-success" role="alert">{{ Session::get('direvisi') }}</div>
		@endif
        <div class="row">
            <div class="col-md-12">
                <table class="table" id="table_id">
				<thead>
                    <tr style="color:#bd000b;">
                        <td>Tanggal</td>
                        <td>Kelompok</td>
                        <td>Asal Universitas</td>
                        <td>Judul Tugas Akhir</td>
                        <td>Tahap</td>
                        <td>Judul Bimbingan</td>
                        <td>Permasalahan</td>
                        <td>Penyelesaian</td>
                        <td>Status</td>
                        <td>Berkas Bimbingan</td>
                        <td>Revisi</td>
                        <td>Berkas Revisi</td>
                        <td>Aksi</td>
                    </tr>
					</thead>
					<tbody>
                    <?php
                    $bimbingan = DB::table('bimbingan_detail')
                            ->where('id_dosen_pembimbing', '=', Session::get('id'))
                            ->orderBy('tanggal', 'desc')
                            ->get();

                    foreach ($bimbingan as $bimbingan) {
                    ?>
                    <tr>
                        <td><?php echo $bimbingan->tanggal;?></td>
                        <td>
                            <?php
                            //mengambil nama kelompok
                            $nama_kelompok = DB::table('kelompok')
                                    ->where('id', '=', $bimbingan->id_kelompok)
                                    ->get();

                            $fix_nama_kelompok = null;

                            foreach ($nama_kelompok as $nama_kelompok) {
                                $fix_nama_kelompok = $nama_kelompok->no_kelompok;
                            }
                            echo $fix_nama_kelompok;
                            ?>
                        </td>
                        <td>
                            <?php
                            //mengambil nama universitas
                            $nama_universitas = DB::table('universitas')
                                    ->join('pengguna', 'universitas.id_pengguna', '=', 'pengguna.id')
                                    ->where('universitas.id', '=', $bimbingan->id_universitas)
                                    ->get();

                            $fix_nama_universitas = null;

                            foreach ($nama_universitas as $nama_universitas) {
                                $fix_nama_universitas = $nama_universitas->nama;
                            }
                            echo $fix_nama_universitas;
                            ?>
                        </td>
                        <td>
                            <?php
                            //mengambil nama topik
                            $nama_topik = DB::table('topik')
                                    ->where('id', '=', $bimbingan->id_topik)
                                    ->get();

                            $fix_nama_topik = null;

                            foreach ($nama_topik as $nama_topik) {
                                $fix_nama_topik = $nama_topik->judul;
                            }
                            echo $fix_nama_topik;
                            ?>
                        </td>
                        <td><?php echo $bimbingan->tahap;?></td>
                        <td style="text-align: left;"><?php echo $bimbingan->judul;?></td>
                        <td style="text-align: left;"><?php echo $bimbingan->permasalahan;?></td>
                        <td style="text-align: left;"><?php echo $bimbingan->penyelesaian;?></td>
                        <td><?php switch ($bimbingan->status_bimbingan) {
                                case 0:
                                    echo "<span class = 'text-info'>belum diperiksa</span>";
                                    break;
                                case 1:
                                    echo "<span class = 'text-danger'>sudah diperiksa</span>";
                                    break;
                            } ?></td>
                        <td>
                            <?php
                            if($bimbingan->lokasi_berkas_bimbingan == null || $bimbingan->lokasi_berkas_bimbingan == ''){
                                echo '-';
                            }else{
                            ?>
                            <a class="btn btn-default" style="border: 0px hidden;" target="_blank"
                               href="<?php echo $bimbingan->lokasi_berkas_bimbingan;?>"><span
                                        class="glyphicon glyphicon-download-alt text-danger"
                                        aria-hidden="true"></span></a>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($bimbingan->revisi == null) {
                                echo "-";
                            } else {
                            ?>
                            <span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                            <?php
                            } ?>
                        </td>
                        <td>
                            <?php
                            if ($bimbingan->lokasi_berkas_revisi == null) {
                                echo "-";
                            } else {
                            ?>
                            <a class="btn btn-default" style="border: 0px hidden;" href="<?php echo $bimbingan->lokasi_berkas_revisi;?>" target="_blank"><span
                                                        class="glyphicon glyphicon-search text-danger"
                                                        aria-hidden="true"></span></a>
                            <?php
                            } ?>
                        </td>
                        <td>
                            <a class="btn btn-default" data-toggle="modal"
                               data-target="#aksi<?php echo $bimbingan->id;?>"><span
                                        class="glyphicon glyphicon-pencil text-danger" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                    <!--Modal aksi-->
                    <div class="modal fade" id="aksi<?php echo $bimbingan->id;?>" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Aksi</h4>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    if ($bimbingan->status_bimbingan == 0) {
                                    ?>
                                    Anda belum menandai bahwa bimbingan ini sudah diperiksa.
                                    <br/>
                                    <form method="post" action="bimbingan/tandai_sudah_diperiksa">
                                        <input type="hidden" name="_token"
                                               value="{{ csrf_token() }}"/>
                                        <input type="hidden" name="id"
                                               value="<?php echo $bimbingan->id;?>"/>
                                        <button type="submit" class="btn btn-danger">Tandai sudah diperiksa</button>
                                    </form>
                                    <br/>
                                    <br/>
									<hr/>
                                    <?php
                                    }
                                    ?>
									
                                    <form method="post" enctype="multipart/form-data" action="bimbingan/tambah_revisi">
                                        <input type="hidden" name="_token"
                                               value="{{ csrf_token() }}"/>
                                        <input type="hidden" name="id"
                                               value="<?php echo $bimbingan->id;?>"/>
                                        <span class="text-danger">Revisi:</span>
                                    <textarea class="form-control" rows="3" name="revisi">
                                        <?php
                                        echo $bimbingan->revisi;
                                        ?>
                                    </textarea>
                                        <br/>
                                        <label for="exampleInputFile">Unggah berkas revisi <span
                                                    class="text-danger">(bila ada)</span></label>
                                        <input type="file" name="berkas">
                                        <br/>
                                        <button type="submit" class="btn btn-danger">Kirim</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Akhir modal aksi-->
                    <?php
                    }
                    ?>
					</tbody>
                </table>
            </div>
        </div>
        <?php
        }
        ?>

    </div>
@endsection
@section('additional_js')
	$('#table_id').DataTable({
		"pageLength": 5
	});
@endsection