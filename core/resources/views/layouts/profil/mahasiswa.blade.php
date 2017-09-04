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
    font-size:13px;
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
                                    <a href="../dashboard"><img
                                                src="../core/resources/assets/image/halaman_utama/logo.png"
                                                alt="logo" style="width:2.1em;height:2em;"></a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li><a href="../topik/lihat_selengkapnya" id="nav-topik-pake-login">Judul Tugas
                                            Akhir</a></li>
                                    <li><a href="konfirmasi">Kelompok</a></li>
                                    <li><a href="../bimbingan">Bimbingan</a></li>
                                    <li><a href="http://tadjblog.lskk.ee.itb.ac.id/" target = "_blank">Blog</a></li>
                                    <li>

                                        <a class="dropdown-toggle" type="button" id="dropdownMenu1 nav-dashboard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="#">
                                            <?php echo Session::get('nama');?>
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="{{url('mahasiswa/profil')}}" id="nav-dashboard">Profil</a></li>
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

        @if ( Session::has('pesan_gagal') )
            <div class="alert alert-danger" role="alert">{{ Session::get('pesan_gagal')}}</div>
        @endif

        @if ( Session::has('pesan_berhasil') )
            <div class="alert alert-success" role="alert">{{ Session::get('pesan_berhasil')}}</div>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">Ganti Sandi</span>
            </div>
            <div class="panel-body">
                <?php
                foreach ($penggunas as $pengguna){
                ?>
                <form method="post" action="{{url('ganti_sandi')}}" style="margin-top:2em;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="id_pengguna" value="<?php echo $pengguna->id;?>"/>

                    <div class="form-group input-group-lg">
                        <span>Tulis sandi lama anda</span>
                        <input type="password" name="sandi_lama" class="form-control" placeholder="Sandi Lama">
                    </div>
                    <br>
                    <div class="form-group input-group-lg">
                        <span>Tulis sandi baru</span>
                        <input type="password" name="sandi_baru" class="form-control" placeholder="Sandi Baru">
                    </div>
                    <br>
                    <div class="form-group input-group-lg">
                        <button type="submit" class="btn btn-danger btn-lg">Ubah Sandi</button>
                        <!-- <span style="font-size: 118%;"><a href="lupa_kata_sandi">Lupa kata sandi?</a></span> -->
                    </div>
                </form>
                <?php }?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">Profil</span>
            </div>
            <div class="panel-body">
                <?php
                foreach ($penggunas as $pengguna){
                ?>
                <form method="post" action="{{url('ganti_profil')}}" style="margin-top:2em;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="id_pengguna" value="<?php echo $pengguna->id;?>"/>

                    <div class="form-group input-group-lg">
                        <span>Email</span>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $pengguna->email;?>">
                    </div>
                    <br>

                    <div class="form-group input-group-lg">
                        <span>NIM</span>
                        <input type="text" name="nim" class="form-control" placeholder="NIM" value="<?php echo $pengguna->nim;?>">
                    </div>
                    <br>


                    <div class="form-group input-group-lg">
                        <span>Username</span>
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $pengguna->nama;?>">
                    </div>
                    <br>
                    <div class="form-group input-group-lg">
                        <span>Nama Depan</span>
                        <input type="text" name="nama_depan" class="form-control" placeholder="Nama Depan" value="<?php echo $pengguna->nama_depan;?>">
                    </div>
                    <br>
                    <div class="form-group input-group-lg">
                        <span>Nama Belakang</span>
                        <input type="text" name="nama_belakang" class="form-control" placeholder="Nama Belakang" value="<?php echo $pengguna->nama_belakang;?>">
                    </div>
                    <br>

                    <div class="form-group input-group-lg">
                        <button type="submit" class="btn btn-danger btn-lg">Ubah Profil</button>
                        <!-- <span style="font-size: 118%;"><a href="lupa_kata_sandi">Lupa kata sandi?</a></span> -->
                    </div>
                </form>
                <?php
                }
                ?>
            </div>
        </div>


    </div>
@endsection
@section('additional_js')

@endsection
