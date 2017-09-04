@extends('layouts.koleksi_master.heater')
@section('additional_css')
    form{
    font-weight:lighter;
    font-family:'Lato'
    }
    #nav-dosen{
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
                                    if (Session::get('status') == 3) {//pengguna sebagai dosen
                                    ?>
                                    <li><a href="topik" id="nav-topik-pake-login">Topik Tugas Akhir</a></li>
                                    <li><a href="keluar" id="nav-keluar">Keluar</a></li>
                                    <?php
                                    }else if(Session::get('status') == 2){//pengguna sebagai universitas
                                    ?>
                                    <li><a href="topik" id="nav-topik-pake-login">Judul Tugas Akhir</a></li>
                                    <li><a href="kelompok">Kelompok</a></li>
                                    <li><a href="prodi" id="nav-prodi">Prodi</a></li>
                                    <li><a href="mahasiswa" id="nav-mahasiswa">Mahasiswa</a></li>
                                    <li><a href="" id="nav-dosen">Dosen</a></li>
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
                                    }else if(Session::get('status') == 4) {
                                    ?>
                                    <li><a href="../topik" id="nav-topik-pake-login">Topik Tugas Akhir</a></li>
                                    <li><a href="" id="nav-dashboard">Kelompok</a></li>
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
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">Daftar dosen anda</span>
                </div>
                <div class="panel-body" style="font-size:14px;">
                    <div class="table-responsive">
                        <table class="table" id="table_id">
						<thead>
                            <tr class="danger">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kartu Tanda Pengajar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
							</thead>
							<tbody>
                            <?php
                            $no = 1;
                            foreach ($dosen as $dosen) {
                            ?>
                            <tr>
                                <td><?php echo $no;?></td>
                                <td><?php echo $dosen->email;?></td>
                                <td>
                                    <?php
                                    if($dosen->photo_url == null){
                                    ?>
                                    belum diunggah
                                    <?php
                                    }else{
                                    ?>
                                    <a href="<?php echo $dosen->photo_url;?>" target="_blank" class="btn btn-info">Lihat</a>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($dosen->status_konfirmasi == 0){
                                    ?>
                                    <span class="label label-default">Tidak diterima</span>

                                    <?php
                                    }else if ($dosen->status_konfirmasi == 1) {
                                    ?>
                                    <span class="label label-danger">Diterima</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($dosen->status_konfirmasi == 1){
                                        echo "-";
                                    }else{
                                    ?>
                                    <form method="post" action="dosen/proses_konfirmasi">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                        <input type="hidden" name="id_dosen" value="<?php echo $dosen->id_dosen;?>"/>
                                        <button type="submit" class="btn btn-danger">Terima</button>
                                    </form>
                                    <?php
                                    }
                                    ?>

                                </td>
                            </tr>
                            <?php $no++;} ?>
							</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additional_js')
	$('#table_id').DataTable({
		"pageLength": 15
	});
@endsection
