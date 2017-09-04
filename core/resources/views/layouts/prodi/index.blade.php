@extends('layouts.koleksi_master.heater')
@section('additional_css')
    #nav-prodi{
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
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    Tambah Prodi
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingOne">
                            <div class="panel-body">
                                <form method="post" action="prodi/tambah_prodi_universitas">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                    <div class='container'>Pilih prodi</div>
                                    <div class="form-group input-group-md col-md-12">
                                        <select class="form-control"
                                                name="prodi">
                                            <?php
                                            foreach ($prodi as $prodi) {
                                            ?>
                                            <option value="<?php echo $prodi->id;?>"><?php echo $prodi->detail_prodi;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-group input-group-md col-md-6">
                                        <button type="submit" class="btn btn-danger btn-md">Submit</button>
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
                                    Daftar Prodi Universitas/ Institusi anda
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table" id="table_id">
									<thead>
                                        <tr class="danger">
                                            <th>No</th>
                                            <th>Nama Prodi</th>
                                        </tr>
										</thead>
										<tbody>
                                        <?php
                                        $number = 1;

                                        foreach ($prodi_universitas as $prodi_universitas) {
                                        ?>
                                        <tr>
                                            <td><?php echo $number;?></td>
                                            <td><?php echo $prodi_universitas->detail_prodi;?></td>
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
		"pageLength": 5
	});
@endsection
