<?php
$no = 1;
                    foreach ($tampilkan_semua as $hasil) {
                    ?>
                    <a href="#myModal<?php echo $no;?>" class="list-group-item" data-toggle="modal"
                       data-target="#myModal<?php echo $no;?>">
                        <h4 class="list-group-item-heading" style="color:#c2000b;"><?php echo $hasil->judul;?></h4>

                        <p class="list-group-item-text"><?php echo $hasil->nama;?></p>
                    </a>

                    <?php


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

                    $query_detail_topik = DB::table('topik')
                    ->select('*')
                    ->join('topik_universitas','topik_universitas.id_topik','=','topik.id')
                    ->join('kelompok','topik_universitas.id_kelompok','=','kelompok.id')
                                  ->where('topik.id', '=', $hasil->id_topik)
                                  ->get();
                          $judul = null;
                          $no_kelompok = null;
                          foreach ($query_detail_topik as $query_detail_topik) {
                              $no_kelompok = $query_detail_topik->no_kelompok;
                              $judul = $query_detail_topik->judul;
                          }
                    ?>

                    <div class="modal fade" id="myModal<?php echo $no;?>" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?php echo $judul;?></h4>
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
                                                        <?php echo $no_kelompok;?></li>
                                                    <li class="list-group-item"><span class="text-danger">Topik Universitas:</span>
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
                                                        <?php echo $hasil->deskripsi;?></li>

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
?>
