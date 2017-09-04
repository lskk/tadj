@extends('layouts.koleksi_master.master2')

@section('additional_css')
    #nav-topik{
    color:#be272d;
    }
@endsection
@section('nav_link')

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <?php
            if(Session::get('status') != null){
            ?>
            <li><a href="" id="nav-topik">Judul Tugas Akhir</a></li>
            <li><a href="../mahasiswa/konfirmasi" id="nav-dashboard">Kelompok</a></li>
            <li><a href="../bimbingan">Bimbingan</a></li>
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
            }else{
            ?>
            <li><a href="{{url('/topik/lihat_selengkapnya')}}" style="color:#bd000b;">Judul Tugas Akhir</a></li>
            <li><a href="../#service">Alur</a></li>
            <li><a href="../#masuk">Masuk</a></li>
            <li><a href="{{url('daftar')}}">Daftar</a></li>
            <?php
            }
            ?>
        </ul>
    </div><!-- /.navbar-collapse -->


@endsection

@section('content')
    <div class="container">
        <form method="post" action="../topik/cari">
            <input type="hidden" name="_token"
                   value="{{ csrf_token() }}"/>
            <?php

            //cek apakah pengguna masuk ke sistem sebagai mahasiswa dan juga apakah sudah memiliki kelompok atau belum
            $cek_kelompok = DB::table('kelompok_mahasiswa')
                    ->where('id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
                    ->count();

            if(Session::get('status') != null && $cek_kelompok != 0){
            //apakah menampilkan ketarangan pengambilan topik
            $kelompok = DB::table('kelompok')
                    ->select('kelompok.no_kelompok as no_kelompok', 'kelompok.id as id')
                    ->join('kelompok_mahasiswa', 'kelompok.id', '=', 'kelompok_mahasiswa.id_kelompok')
                    ->where('kelompok_mahasiswa.id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
                    ->get();

            foreach ($kelompok as $kelompok) {
                $kelompok = $kelompok;
            }

            $kelompok_topik_tugas_akhir = DB::table('kelompok_topik_tugas_akhir')
                    ->select('topik.judul as judul')
                    ->join('topik', 'kelompok_topik_tugas_akhir.id_topik', '=', 'topik.id')
                    ->where('id_kelompok', '=', $kelompok->id)
                    ->count();

            if ($kelompok_topik_tugas_akhir == 0) {
            ?>
            <div class="row">
                <div class="container">
                    <span class="label label-danger">Silahkan pilih topik yang tersedia, apabila anda ingin mengambil topik pilih ambil topik (bila tersedia).</span>
                </div>
            </div>
            <?php
            }
            }else if(Session::get('status') != null){
            ?>
            <span class="label label-danger">Anda belum memiliki kelompok tugas akhir, bergabunglah dengan kelompok yang tersedia untuk mengambil tugas akhir <a
                        href="../mahasiswa/konfirmasi">disini</a> .</span>
            <br/>
            <?php
            }
            ?>
            <br/>

            <div class="row">
                <div class="col-md-2">
                    <input type="text" class="form-control small" placeholder="Judul" name="judul">
                </div>
				
                <div class="col-md-2">
                    <select class="form-control" name="universitas">
                        <option value="">Universitas</option>
                        <?php
                        foreach ($universitas as $universita) {
                        ?>
                        <option value="<?php echo $universita->id;?>"><?php echo $universita->nama;?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">

                    <select class="form-control" name="prodi">
                        <option value="">Prodi</option>
                        <?php
                        foreach ($prodi as $p) {
                        ?>
                        <option value="<?php echo $p->id;?>"><?php echo $p->detail_prodi;?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="jenjang">
                        <option value="">Jenjang</option>
                        <?php
                        foreach ($jenjang as $j) {
                        ?>
                        <option value="<?php echo $j->id;?>"><?php echo $j->detail_jenjang;?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="tahun_ajaran">
                        <option value="">Tahun ajaran</option>
                        <?php
                        foreach ($tahun_ajaran as $ta) {
                        ?>
                        <option value="<?php echo $ta->tahun_ajaran;?>"><?php echo $ta->tahun_ajaran;?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
				<div class="col-md-2">
                    <select class="form-control" name="semester">
                        <option value="">Semester</option>
                        <option value="1">Ganjil</option>
						<option value="2">Genap</option>
                    </select>
                </div>
                
            </div>
			<br/>
			<div class="row">
			<div class="col-md-12">
					<select class="form-control" name="dosen">
                        <option value="">Dosen</option>
                        <?php
						$dosen = DB::table('pengguna')
						->select('*','dosen.id as id_dosen')
						->join('dosen','dosen.id_pengguna','=','pengguna.id')
						->orderBy('pengguna.nama_depan','asc')            
						->get();
						
                        foreach ($dosen as $dosen_pembimbing) {
                        ?>
                        <option value="<?php echo $dosen_pembimbing->id_dosen;?>"><?php echo $dosen_pembimbing->nama_depan.' '.$dosen_pembimbing->nama_belakang;?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
			</div>
			<div class="row">
			<div class="col-md-2">
					<br/>
                    <button type="submit" class="btn btn-danger">Temukan</button>
                </div>
			</div>
        </form>
        <br/>

        <div class="row">
            <div class="col-md-12">
                <br/>

                <div class="list-group" id="daftar-topik">

                    <?php
                    if($hasil_pencarian != null){
                    $no = 1;
                    foreach ($hasil_pencarian as $hasil) {
                    ?>
                    <a href="#myModal<?php echo $no;?>" class="list-group-item" data-toggle="modal"
                       data-target="#myModal<?php echo $no;?>">
                        <h4 class="list-group-item-heading" style="color:#c2000b;"><?php echo $hasil->judul;?></h4>

                        <p class="list-group-item-text"><?php echo $hasil->nama;?></p>
                    </a>

                    <?php
                    //untuk ambil no topik, judul, deskripsi

                    /*$query_detail_topik = DB::table('topik')
                            ->where('id', '=', $hasil->id_topik)
                            ->get();*/
							
							$query_detail_topik = DB::table('topik')
							->select('*','topik_universitas.no_ta as no_ta')
							->join('topik_universitas','topik_universitas.id_topik','=','topik.id')
                            ->where('topik.id', '=', $hasil->id_topik)
                            ->get();

                    $detail_topik = null;
                    foreach ($query_detail_topik as $query_detail_topik) {
                        $detail_topik = $query_detail_topik;
                    }

                    //untuk ambil prodi
                    $query_ambil_prodi = DB::table('prodi')
                            ->where('id', '=', $hasil->id_prodi)
                            ->get();

                    $prodi = null;
                    foreach ($query_ambil_prodi as $query_ambil_prodi) {
                        $prodi = $query_ambil_prodi;
                    }

                    //untuk ambil jenjang
                    $query_ambil_jenjang = DB::table('jenjang')
                            ->where('id', '=', $hasil->id_jenjang)
                            ->get();

                    $jenjang = null;
                    foreach ($query_ambil_jenjang as $query_ambil_jenjang) {
                        $jenjang = $query_ambil_jenjang;
                    }
                    ?>

                    <div class="modal fade" id="myModal<?php echo $no;?>" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?php echo $detail_topik->judul;?></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="media">
                                        <div class="row">
                                            <div class="col-md-5" align="center">
                                                <?php
                                                if($hasil->lokasi_poster != null){
                                                ?>
                                                <a href="<?php echo $hasil->lokasi_poster;?>" target="_blank"><img src="<?php echo $hasil->lokasi_poster;?>"
                                                     class="img-responsive lazy"></a>
                                                <?php
                                                }else {
                                                ?>
                                                <img src="../core/resources/assets/image/poster_produk_belum_diunggah.png"
                                                     class="img-responsive">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="list-group">
                                                    <li class="list-group-item"><span
                                                                class="text-danger">No TA:</span>
                                                        <?php echo $detail_topik->no_ta;?></li>
                                                    <li class="list-group-item"><span class="text-danger">Universitas:</span>
                                                        <?php echo $hasil->nama;?></li>
                                                    <li class="list-group-item"><span class="text-danger">Prodi:</span>
                                                        <?php echo $prodi->detail_prodi;?></li>
                                                    <li class="list-group-item"><span
                                                                class="text-danger">Jenjang:</span>
                                                        <?php echo $jenjang->detail_jenjang;?></li>
                                                    <li class="list-group-item"><span
                                                                class="text-danger">Tahun Ajaran:</span>
                                                        <?php echo $hasil->tahun_ajaran;?></li>
													<li class="list-group-item"><span
                                                                class="text-danger">Semester:</span>
                                                        <?php
															if($hasil->semester == 1){
																echo "Ganjil";
															}else if($hasil->semester == 2){
																echo "Genap";
															}															
														?>
													</li>
													<li class="list-group-item"><span
                                                                class="text-danger">Dosen:</span>
                                                        <?php
															$dosen=DB::table('dosen')
																	->join('pengguna','pengguna.id','=','dosen.id_pengguna')
																	->join('pembimbing','pembimbing.id_dosen','=','dosen.id')
																	->where('pembimbing.id_universitas','=',$hasil->id_universitas)
																	->where('pembimbing.id_topik','=',$hasil->id_topik)
																	->orderBy('pembimbing.pembimbing_ke','asc')
																	->get();
															echo "<ul>";
															foreach($dosen as $dosen){
																echo "<li>".$dosen->nama_depan.' '.$dosen->nama_belakang.'</li>';
															}
															echo "</ul>";
														?>
													</li>
                                                    <li class="list-group-item"><span
                                                                class="text-danger">Blog:</span>
                                                        <a href="<?php echo $hasil->alamat_blog;?>" target="_blank"><?php echo $hasil->alamat_blog;?></a></li>    
                                                    <li class="list-group-item"><span
                                                                class="text-danger">Deskripsi:</span>
                                                        <?php
														if($hasil->deskripsi != NULL){
															echo '<a class="btn btn-danger" href="'.$hasil->deskripsi.'" target="_blank" role=button">
															<span
															class="glyphicon glyphicon-download-alt"
															aria-hidden="true"></span> Unduh</a>';
														}else{
															echo '';
														}
														?>
														</li>
                                                    <?php
                                                    //ditampilkan apabila pengguna sebagai mahasiswa
                                                    if(Session::get('status') == 4){
                                                    //ambil kuota
                                                    $ambil_kuota = DB::table('topik_kuota')
                                                            ->where('id_topik', '=', $hasil->id_topik)
                                                            ->get();

                                                    $final_ambil_kuota = null;
                                                    foreach ($ambil_kuota as $ambil_kuota) {
                                                        $final_ambil_kuota = $ambil_kuota->jumlah;
                                                    }

                                                    //cek status ketersediaan pengambilan topik
                                                    $cek_ketersediaan = DB::table('kelompok_topik_tugas_akhir')
                                                            ->where('id_topik', '=', $hasil->id_topik)
                                                            ->count();

                                                    //ambil kuota kelompok yang sudah diambil pengguna
                                                    $ambil_kuota_kelompok_pengguna = DB::table('kelompok')
                                                            ->join('kelompok_mahasiswa', 'kelompok.id', '=', 'kelompok_mahasiswa.id_kelompok')
                                                            ->where('kelompok_mahasiswa.id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
                                                            ->get();

                                                    $ambil_kuota_kelompok_pengguna_final = null;

                                                    foreach ($ambil_kuota_kelompok_pengguna as $ambil_kuota_kelompok_pengguna) {
                                                        $ambil_kuota_kelompok_pengguna_final = $ambil_kuota_kelompok_pengguna;
                                                    }
                                                    ?>
                                                    <li class="list-group-item">
                                                        <span class="text-danger">Jumlah anggota kelompok:</span>
                                                        <?php echo $final_ambil_kuota;?>
                                                    </li>
                                                    <?php
                                                    //cek ketersediaan id kelompok pengguna
                                                    //ambil id kelompok nya pengguna
                                                    $kelompok_pengguna = DB::table('kelompok_mahasiswa')
                                                            ->where('id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
                                                            ->get();

                                                    $final_kelompok_pengguna = null;
                                                    foreach ($kelompok_pengguna as $kelompok_pengguna) {
                                                        $final_kelompok_pengguna = $kelompok_pengguna;
                                                    }

                                                    //cek apakah kelompok pengguna memiliki topik atau tidak
                                                    $cek_kelompok_punya_topik = DB::table('kelompok_topik_tugas_akhir')
                                                            ->join('kelompok_mahasiswa', 'kelompok_topik_tugas_akhir.id_kelompok', '=', 'kelompok_mahasiswa.id_kelompok')
                                                            ->where('kelompok_mahasiswa.id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
                                                            ->count();

                                                    //cek apakah topik sudah pernah diambil di universitas pengguna
                                                    $cek_topik_sudah_diambil = DB::table('kelompok_topik_tugas_akhir')
                                                            ->join('kelompok_topik', 'kelompok_topik_tugas_akhir.id_topik', '=', 'kelompok_topik.id_topik')
                                                            ->where('kelompok_topik.id_universitas', '=', Session::get('id_universitas'))
                                                            ->where('kelompok_topik_tugas_akhir.id_topik', '=', $hasil->id_topik)
                                                            ->count();

                                                    if($cek_kelompok_punya_topik == 0 && $final_kelompok_pengguna != null){//apabila kelompok tidak punya topik
                                                    ?>
                                                    <li class="list-group-item">
                                                        <span class="text-danger">Aksi:</span>

                                                        <form method="post" action="../kelompok/ambil_topik">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>

                                                            <?php
                                                            if ($ambil_kuota_kelompok_pengguna_final->id_kuota == $final_ambil_kuota && $cek_topik_sudah_diambil == 0
                                                            ) {//apabila kuota kelompok sama dengan kuota topik dan topik belum diambil

                                                            //ambil id kelompok nya pengguna
                                                            $kelompok_pengguna = DB::table('kelompok_mahasiswa')
                                                                    ->where('id_mahasiswa', '=', Session::get('id_pengguna_mahasiswa'))
                                                                    ->get();

                                                            $final_kelompok_pengguna = null;
                                                            foreach ($kelompok_pengguna as $kelompok_pengguna) {
                                                                $final_kelompok_pengguna = $kelompok_pengguna;
                                                            }
                                                            ?>
                                                            <input type="hidden" name="kelompok"
                                                                   value="<?php echo $final_kelompok_pengguna->id_kelompok;?>"/>
                                                            <input type="hidden" name="topik"
                                                                   value="<?php echo $hasil->id_topik;?>"/>
                                                            <button type="submit" class="btn btn-danger">Ambil topik
                                                            </button>
                                                            <?php
                                                            }else {
                                                                echo "-";
                                                            }
                                                            ?>
                                                        </form>
                                                    </li>
                                                    <?php
                                                    }

                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <br/>

                                        <div align="center" style="color:#c2000b;">
                                            Video Produk
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" align="center">
                                                <?php
                                                if($hasil->lokasi_video_produk != null){
                                                ?>
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <video class="embed-responsive-item" controls>
                                                        <source src="<?php echo $hasil->lokasi_video_produk;?>"
                                                                type="video/mp4">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $no++;
                    }
                    }else {
                        echo "<span style = 'color:#c2000b'>hasil tidak ditemukan</span>";
                    }
                    ?>
                    <br/>
                    <a onClick="tampilkanSemua();" class="btn btn-danger col-md-12">Tampilkan semua</a>
                    <br/>    
                </div>

            </div>
        </div>
    </div>
@endsection
@section('additional_js')
    function tampilkanSemua(){
        $.ajaxSetup({
            headers: { 
                'X-CSRF-Token' : $('meta[name=_token]').attr('content')}
            });

        $.ajax({
            url: '{{ url('/topik/tampilkan_semua') }}',
                                                type: 'get',
                                                data: {
                                                
                                                },

                                                success: function (data) {
												
                                                $('#daftar-topik').hide().fadeIn(2000).load('{{ url('/topik/tampilkan_semua') }}/<?php //echo  $konten->id_materi?>');

                                                }
                                                });
    }
@endsection