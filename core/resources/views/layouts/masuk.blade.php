@extends('layouts.koleksi_master.heater')
@section('additional_css')
    form{
    font-weight:lighter;
    font-family:'Lato'
    }
    #nav-masuk{
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
                                    <a href="/"><img src="core/resources/assets/image/halaman_utama/logo.png"
                                                         alt="logo" style="width:2.1em;height:2em;"></a>
                                </div>
                            </div>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li><a href="topik/lihat_selengkapnya" id="nav-topik">Topik Tugas Akhir</a></li>
                                    <li><a href="/#service" id="nav-tentang">Alur</a></li>
                                    <li><a href="#" id="nav-masuk">Masuk</a></li>
                                    <li><a href="{{url('daftar')}}" id="nav-daftar">Daftar</a></li>
                                </ul>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
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
			@if ( Session::has('gagal') )
				<div class="alert alert-danger" role="alert">
					{{ Session::get('gagal') }}
				</div>
			@endif

		
            <div class="col-md-6">
                
                
                       
                        <img src="http://167.205.7.228:8089/tadj/halaman_awal/desk.png" alt="img">
                
                
            </div>
            <!-- .col-md-6 close -->

            <div class="col-md-6" id="masuk" style="padding-bottom:5em;">                                                                                   
                            <form method="post" action="masuk" style="margin-top:2em;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                <div class="form-group input-group-lg">
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                                <br>

                                <div class="form-group input-group-lg">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <br>

                                <div class="form-group input-group-lg">
                                    <button type="submit" class="btn btn-danger btn-lg">Submit</button>
                                    <!-- <span style="font-size: 118%;"><a href="lupa_kata_sandi">Lupa kata sandi?</a></span> -->
                                </div>
                            </form>                                                                                      
            </div>
			
            <!-- .col-md-6 close -->
        </div>
    </div>
@endsection

