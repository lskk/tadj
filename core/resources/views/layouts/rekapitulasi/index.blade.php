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
                                <a href="{{url('/dashboard')}}"><img src="{{url('core/resources/assets/image/halaman_utama/logo.png')}}"
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
                                <li><a href="{{url('/topik')}}" id="nav-topik-pake-login">Judul Tugas Akhir</a></li>
								<li><a href="{{url('/rekapitulasi/semua')}}" id="nav-dashboard">Rekapitulasi</a></li>
                                <li><a href="{{url('/bimbingan')}}">Bimbingan</a></li>
								<li><a href="http://tadjblog.lskk.ee.itb.ac.id/" target = "_blank">Blog</a></li>

                                <?php
                                }else if(Session::get('status') == 2){//pengguna sebagai universitas
                                ?>
                                <li><a href="topik" id="nav-topik-pake-login">Topik Tugas Akhir</a></li>
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
		<form method="post" action="{{url('/rekapitulasi/filter')}}">
		<input type="hidden" name="_token"
                   value="{{ csrf_token() }}"/>
		<div class="row col-md-12">
		    <div class="col-md-4">
				<select class="form-control" name="prodi">
                        <option value="">Prodi</option>
						<?php
						foreach($prodi as $prodi){
						?>
						<option value="<?php echo $prodi->id_prodi;?>"><?php echo $prodi->detail_prodi;?></option>
						<?php
						}
						?>
                </select>
			</div>
            <div class="col-md-4">
				<select class="form-control" name="tahun_ajaran">
                        <option value="">Tahun ajaran</option>
						<?php
						foreach($tahun_ajaran as $tahun_ajaran){
						?>
						<option value="<?php echo $tahun_ajaran->tahun_ajaran;?>"><?php echo $tahun_ajaran->tahun_ajaran;?></option>
						<?php
						}
						?>
                </select>
			</div>
			<div class="col-md-4">
				<select class="form-control" name="semester">
                        <option value="">Semester</option>
						<option value="1">Ganjil</option>
						<option value="2">Genap</option>
                </select>
			</div>
        </div>
		<br/>
		<br/>
		<div class="row col-md-12">
			<div class="col-md-2">
				<button type="submit" class="btn btn-danger col-md-12">Filter</button>
			</div>
		</div>
		</form>
		<br/>
		<br/>
		<br/>
		<div class="row col-md-12 container" style="font-weight:lighter;font-size:14px;">
			<div class="row col-md-12">
			<div class="col-md-10">
			</div>
			<div class="col-md-2">
				<a onClick="$('#table_id').tableExport({type:'pdf',escape:'false',pdfFontSize:'7',pdfLeftMargin:2,pdfRightMargin:5});" class="btn btn-danger col-md-12" target="_blank">
				<span
															class="glyphicon glyphicon-download-alt"
															aria-hidden="true"></span>
				Unduh
				</a>
			</div>
		</div>
		<br/>
		<br/>
		<br/>
			<table class="table" id="table_id">
						<thead>
                            <tr class="danger">
                                <th>No</th>
                                <th>No TA</th>
                                <th>Judul</th>
                            </tr>
							</thead>
							<tbody>
								<?php
								$no=1;
								foreach($judul_universitas as $judul_universitas){
								?>
								<tr>
									<td><?php echo $no;?></td>
									<td><a href='../ta/<?php echo $judul_universitas->no_kelompok;?>' target="_blank"><?php echo $judul_universitas->no_kelompok;?></a></td>
									<td><?php echo $judul_universitas->judul;?></td>
								</tr>
								<?php
								$no++;
								}
								?>
							<tbody>
                        </table>

		</div>
	</div>
@endsection
@section('additional_js')
	$('#table_id').DataTable({
		"pageLength": 20
	});
@endsection
