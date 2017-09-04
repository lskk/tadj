@extends('layouts.koleksi_master.heater')
@section('additional_css')
    form{
    font-weight:lighter;
    font-family:'Lato'
    }
    .container{
    font-size:13px;
    }
    .list-group{
    font-weight:lighter;
    font-family:'Lato'
    }
    .red{
      color:#be272d;
    }
@endsection

@section('content')
    <div class="container">
      <div class="row">
        <?php
        foreach ($topik_universitas as $topik_universitas) {
        ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title red"><?php echo $topik_universitas->no_kelompok;?></h3>
          </div>
          <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item"><span class="red">Judul Tugas Akhir: </span><?php echo $topik_universitas->judul;?></li>
              <li class="list-group-item"><span class="red">Deskripsi:</span>
                <?php
                if($topik_universitas->deskripsi != NULL){
                ?>
                <a href='<?php echo $topik_universitas->deskripsi;?>' target='_blank' class="btn btn-sm btn-danger"><span
															class="glyphicon glyphicon-download-alt"
															aria-hidden="true"></span> Unduh</a>
                <?php }else{
                  ?>
                  -
                  <?php
                }?>
              </li>
              <li class="list-group-item"><span class="red">Blog:</span>
                <a href='<?php echo $topik_universitas->alamat_blog;?>' target="_blank"><?php echo $topik_universitas->alamat_blog;?></a>
              </li>
            </ul>
            <ul class="list-group">
              <li class="list-group-item red">Anggota Kelompok</li>
              <li class="list-group-item">
                <table class="table" id="table_id">
                  <thead>
                                  <tr class="danger">
                                      <th>No</th>
                                      <th>Nama lengkap</th>
                                      <th>Email</th>
                                      <th>Username</th>
                                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $anggota = DB::table('topik_universitas')
                              ->join('kelompok','kelompok.id','=','topik_universitas.id_kelompok')
                              ->join('mahasiswa','mahasiswa.id_kelompok','=','kelompok.id')
                              ->join('pengguna','pengguna.id','=','mahasiswa.id_pengguna')
                              ->where('topik_universitas.id_kelompok','=',$topik_universitas->id_kelompok)
                              ->get();
                      foreach ($anggota as $anggota) {
                     ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <th><?php echo $anggota->nama_depan.' '.$anggota->nama_belakang;?></th>
                        <th><?php echo $anggota->email;?></th>
                        <th><?php echo $anggota->nama;?></th>
                    </tr>
                    <?php
                    $no++;
                    }
                     ?>
                  </tbody>
                </table>
              </li>
            </ul>

            <ul class="list-group">
              <li class="list-group-item red">Dosen Pembimbing</li>
              <li class="list-group-item">
                <table class="table" id="table_id">
                  <thead>
                                  <tr class="danger">
                                      <th>No</th>
                                      <th>Nama lengkap</th>
                                      <th>Email</th>
                                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $pembimbing = DB::table('pembimbing')
                              ->join('dosen','dosen.id','=','pembimbing.id_dosen')
                              ->join('pengguna','pengguna.id','=','dosen.id_pengguna')
                              ->where('pembimbing.id_topik','=',$topik_universitas->id_topik)
                              ->get();
                      foreach ($pembimbing as $pembimbing) {
                     ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <th><?php echo $pembimbing->nama_depan.' '.$pembimbing->nama_belakang;?></th>
                        <th><?php echo $pembimbing->email;?></th>
                    </tr>
                    <?php
                    $no++;
                    }
                     ?>
                  </tbody>
                </table>
              </li>
            </ul>

            <div class="col-md-12">
              <div class="col-md-6 red" align="center">
              Poster
              <br/>
              <?php
              if($topik_universitas->lokasi_poster != NULL){ //poster ada
               ?>
              <img src="<?php echo $topik_universitas->lokasi_poster;?>" class="img-responsive"/>
              <?php
            }else{//poster tdk ada
              ?>
              <img src="http://tadj.lskk.ee.itb.ac.id/core/resources/assets/image/poster_produk_belum_diunggah.png" class="img-responsive"/>
              <?php
            }?>
              </div>
              <div class="col-md-6 red" align="center">
              Video
              <br/>
              <?php
              if($topik_universitas->lokasi_video_produk != NULL){ //video ada
               ?>
               <div class="embed-responsive embed-responsive-16by9">
                                                     <video class="embed-responsive-item" controls>
                                                         <source src="<?php echo $topik_universitas->lokasi_video_produk;?>"
                                                                 type="video/mp4">
                                                     </video>
                                                 </div>

              <?php
            }else{//video tdk ada
              ?>
              <img src="http://tadj.lskk.ee.itb.ac.id/core/resources/assets/image/video_produk_belum_diunggah.png" class="img-responsive"/>
              <?php
            }?>
              </div>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
      </div>
    </div>
@endsection
@section('additional_js')
	$('#table_id').DataTable({
		"pageLength": 10
	});
@endsection
