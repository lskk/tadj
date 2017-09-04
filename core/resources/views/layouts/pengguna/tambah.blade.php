@extends('layouts.koleksi_master.heater')
@section('additional_css')
    form{
    font-weight:lighter;
    font-family:'Lato';
    font-size:'16px'
    }
    #nav-topik-pake-login{
    color:#be272d;
    }
    .container{
    font-size:16px;
    font-weight:lighter;
    }
    tr th{
    color: #000;
    font-weight:lighter;
    text-align:center;
    }
    #nav-pengguna{
    color: #c2000b;}
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
                                    <a href="../tadj"><img src="../core/resources/assets/image/halaman_utama/logo.png"
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
                                    <?php
                                    if (Session::get('status') != NULL && Session::get('status') != 1) {//pengguna login bukan sebagai administrator
                                    ?>
                                    <li><a href="topik" id="nav-topik-pake-login">Topik Tugas Akhir</a></li>
                                    <li><a href="keluar" id="nav-keluar">Keluar</a></li>
                                    <?php
                                    }else if(Session::get('status') == 1){//pengguna login sebagai administrator
                                    ?>
                                    @yield('nav_link')
                                    <li><a href="../admin/tambah_pengguna" id="nav-pengguna">Pengguna</a></li>
                                    <li><a href="../keluar" id="nav-keluar">Keluar</a></li>
                                    <?php
                                    }else {//tanpa login

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
                    <span class="panel-title">Tambah Universitas</span>
                </div>
                <div class="panel-body">
                    <form method="post" action="../admin/proses_daftar_pengguna">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <div class="form-group input-group-lg col-md-12">
                            <div class="form-group input-group-lg">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group input-group-lg">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group input-group-lg">
                                <input type="text" name="universitas" class="form-control" placeholder="Nama Universitas/ Institusi">
                            </div>
                            <div class="form-group input-group-lg">
                                <button type="submit" class="btn btn-danger btn-lg">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection