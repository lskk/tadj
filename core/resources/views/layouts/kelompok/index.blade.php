@extends('layouts.koleksi_master.heater')
@section('additional_css')
    #nav-kelompok{
    color:#be272d;
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
                                    <li><a href="topik">Topik Tugas Akhir</a></li>
                                    <li><a href="keluar" id="nav-keluar">Keluar</a></li>
                                    <?php
                                    }else if(Session::get('status') != NULL && Session::get('status') == 2){//pengguna sebagai universitas
                                    ?>
                                    <li><a href="topik" id="nav-topik-pake-login">Judul Tugas Akhir</a></li>
                                    <li><a href="kelompok" id="nav-kelompok">Kelompok</a></li>
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
		<div class="row container">
		@if ( Session::has('berhasil'))
			<div class="alert alert-danger" role="alert">
					{{ Session::get('berhasil') }}
				</div>
		@endif
		</div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    Tambah kelompok
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingOne">
                            <div class="panel-body">
                                <form method="post" action="proses_tambah_kelompok">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                    Prodi
                                    <div class="row">
                                        <div class="form-group input-group-sm col-sm-12">
                                            <select class="form-control"
                                                    name="prodi">
                                                <?php
                                                foreach ($prodi_universitas as $prodi_universitas) {
                                                ?>
                                                <option value="<?php echo $prodi_universitas->id . '.' . $prodi_universitas->singkatan;?>"><?php echo $prodi_universitas->detail_prodi;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    Tahun ajaran
                                    <div class="row">
                                        <div class="form-group col-sm-12 input-group-sm">
                                            <select class="form-control"
                                                    name="tahun_mulai">
                                                <?php
                                                foreach ($tahun_mulai as $tahun) {
                                                ?>
                                                <option value="<?php echo $tahun->detail_tahun;?>"><?php echo $tahun->detail_tahun;?></option>
                                                <?php } ?>
                                            </select>
											/
											<select class="form-control"
                                                    name="tahun_selesai">
                                                <?php
                                                foreach ($tahun_selesai as $tahun) {
                                                ?>
                                                <option value="<?php echo $tahun->detail_tahun;?>"><?php echo $tahun->detail_tahun;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>


                                    </div>

                                    Semester
                                    <div class="row">
                                        <div class="form-group input-group-sm col-sm-12">
                                            <select class="form-control"
                                                    name="semester">
                                                <?php
                                                foreach ($semester as $semester) {
                                                ?>
                                                <option value="<?php echo $semester->id;?>">
												<?php
													switch($semester->detail_semester){
														case 1:echo "Ganjil";;break;
														case 2:echo "Genap";;break;
													}
													?>
												</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    Kuota per orang
                                    <div class="row">
                                        <div class="form-group input-group-sm col-sm-12">
                                            <select class="form-control"
                                                    name="kuota">
                                                <?php
                                                foreach ($kuota as $k) {
                                                ?>
                                                <option value="<?php echo $k->id;?>"><?php echo $k->detail_kuota;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

									<div class="row">
                                    <div class="form-group input-group-sm col-sm-6">
                                        <button type="submit" class="btn btn-danger btn-md">Submit</button>
                                    </div>
									</div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Kelompok yang sudah dibuat
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingTwo">
                            <div class="panel-body">
								<div class="row">
									<form method="post" action="pencarian_kelompok">

                                        <input type="hidden" name="_token"
                                               value="{{ csrf_token() }}"/>

                                    <div class="col-md-4">
                                        <select class="form-control" name="prodi">
                                            <option value="">prodi</option>
                                            <?php
                                                foreach ($prodi_universitas2 as $prodi_universitas) {
                                                ?>
                                                <option value="<?php echo $prodi_universitas->id . '.' . $prodi_universitas->singkatan;?>"><?php echo $prodi_universitas->detail_prodi;?></option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
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
									<div class="col-md-4">
                                        <select class="form-control" name="prodi">
                                            <option value="">semester</option>
                                            <option value="1">Ganjil</option>
											<option value="2">Genap</option>
                                        </select>
                                    </div>
									<br/>
									<br/>
                                    <button type="submit" class="btn btn-danger" style="margin-left:1em;">Cari</button>
                                </form>

								</div>
								<br/>
                                <div class="table-responsive">
                                    <table class="table" id="table_id">
									<thead>
                                        <tr class="danger">
                                            <th>No</th>
                                            <th>No kelompok</th>
                                            <th>Kuota</th>
											<th>Judul TA</th>
                                        </tr>
										</thead>
										<tbody>
                                        <?php
                                        $number = 1;

                                        foreach ($kelompok as $k) {
                                        ?>
                                        <tr>
                                            <td><?php echo $number;?></td>
                                            <td><a href="ta/<?php echo $k->no_kelompok;?>" target="_blank">
                                              <?php echo $k->no_kelompok;?></a>
                                            </td>
                                            <td><?php echo $k->id_kuota;?></td>
											<td>
												<?php
													$judul = DB::table('topik_universitas')
															->join('topik','topik.id','=','topik_universitas.id_topik')
															->where('topik_universitas.id_universitas','=',Session::get('id_pengguna_universitas'))
															->where('topik_universitas.id_kelompok','=',$k->id)
															->get();
													foreach($judul as $j)
													{
														echo $j->judul;
													}
													?>
											</td>
                                        </tr>
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
    </div>
@endsection
@section('additional_js')
	$('#table_id').DataTable({
		"pageLength": 15
	});
@endsection
