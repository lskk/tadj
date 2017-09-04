 <?php
                                        if($kelompok != null){
                                        ?>
                                        <table class="table">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama kelompok <span class="text-danger">(klik nama kelompok untuk melihat detail)</span>
                                                </th>
                                                <th>Kuota tersedia</th>
                                                <th>Aksi</th>
                                            </tr>
											<span>
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
                                                    if ($sisa_kuota == 0) {
                                                        echo '-';
                                                    } else {
                                                        echo $sisa_kuota;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if($sisa_kuota != 0){
                                                    ?>
                                                    <form method="post" action="../mahasiswa/gabung_kelompok">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                        <input type="hidden" name="id_kelompok"
                                                               value="<?php echo $kelompok->id;?>"/>
                                                        <input type="hidden" name="id_mahasiswa"
                                                               value="<?php echo Session::get('id_pengguna_mahasiswa');?>"/>
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin bergabung kelompok ini?')">Gabung</button>
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
                                                                                    ->select('pengguna.nama as nama','pengguna.email as email')
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
                                                                                <li class="list-group-item">
                                                                                    
																					<?php echo $no_detail_kelompok . '. ' . $anggota->nama.' ('.$anggota->email.')';?>
																					
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
                                                                    <div class="col-md-12">Topik Tugas Akhir:
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
											</span>
                                        </table>
										<hr/>
										
                                        <?php
                                        }else {
                                            echo 'Hasil tidak ditemukan';
                                        }
                                        ?>