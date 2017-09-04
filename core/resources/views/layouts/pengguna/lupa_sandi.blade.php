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
            <li><a href="" id="nav-topik">Topik Tugas Akhir</a></li>
            <li><a href="../mahasiswa/konfirmasi" id="nav-dashboard">Kelompok</a></li>
            <li><a href="../bimbingan">Kemajuan</a></li>
			<li><a href="http://tadjblog.lskk.ee.itb.ac.id/" target = "_blank">Blog</a></li>
            <li><a href="../keluar" id="nav-keluar">Keluar</a></li>
            <?php
            }else{
            ?>
            <li><a href="../topik/lihat_selengkapnya">Topik Tugas Akhir</a></li>
            <li><a href="../#service">Tentang Kami</a></li>
            <li><a href="../#masuk">Masuk</a></li>
            <li><a href="../#daftar">Daftar</a></li>
            <?php
            }
            ?>
        </ul>
    </div><!-- /.navbar-collapse -->


@endsection

@section('content')
    <div class="container">
        <p style="font-size:110%;">Password akan dikirimkan melalui email yang anda tuliskan.</p>
        <form method="post" action="../topik/cari">
            <input type="hidden" name="_token"
                   value="{{ csrf_token() }}"/>
            <div class="form-group input-group-lg">
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                                <!-- <br>

                                <div class="form-group input-group-lg">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div> -->                                
                                <div class="form-group input-group-lg">
                                    <button type="submit" class="btn btn-danger btn-lg">Kirim</button>
                                </div>
        </form>  
    </div>
@endsection
@section('additional_js')

@endsection