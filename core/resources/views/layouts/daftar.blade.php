@extends('layouts.koleksi_master.heater')
@section('additional_css')
    form{
    font-weight:lighter;
    font-family:'Lato'
    }
    #nav-daftar{
    color:#be272d;
    }
    h3{

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
                                    <li><a href="topik/lihat_selengkapnya" id="nav-topik">Judul Tugas Akhir</a></li>
                                    <li><a href="/#service" id="nav-tentang">Alur</a></li>
                                    <li><a href="/#masuk" id="nav-masuk">Masuk</a></li>
                                    <li><a href="" id="nav-daftar">Daftar</a></li>
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
            <div class="col-md-12">
				@if ( Session::has('gagal_daftar') )
					<div class="alert alert-danger" role="alert">Maaf email atau username sudah terdaftar sebelumnya</div>
				@endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <form method="post" action="proses_daftar" id="form_daftar">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                    <div class="form-group input-group-lg col-md-6">
                        <select class="form-control" name="peran" id="peran">
                            <option value="">Daftar sebagai</option>
                            <option value="3">Dosen</option>
                            <option value="4">Mahasiswa</option>
                        </select>
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_prodi" style="color:#be272d;font-size:20px;font-weight: 300;">Pilih peran anda di TADJ</span>
                        <input type="password" class="form-control" placeholder="Tulis Ulang Password"
                               style="visibility: hidden;">
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <input type="text" class="form-control" placeholder="Nama depan" name="nama_depan" id="nama_depan">
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;">Nama depan</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>

                    <div class="form-group input-group-lg col-md-6">
                        <input type="text" class="form-control" placeholder="Nama belakang" name="nama_belakang" id="nama_belakang">
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;">Nama belakang</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>

                    <div class="form-group input-group-lg col-md-6">
                        <input type="text" class="form-control" placeholder="Username" name="nama" id="nama_lengkap">
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;">Username</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <input id="email" type="email" name="email" class="form-control" placeholder="Email" autocomplete="off">
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_email" style="color:#be272d;font-size:20px;font-weight: 300;">Tuliskan email anda</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>

                    <div class="form-group input-group-lg col-md-6">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Tuliskan sandi anda">
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;">Tuliskan sandi anda</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>

                    <div id = "area-validasi-password">
                    <div class ="form-group col-md-6">
                        <div class="alert alert-danger">
                            <ul>
                              <li id ="validasiPasswordNama">Sandi tidak boleh mengandung nama depan atau nama belakang</li>      
                              <li id ="validasiPasswordKarakter">Minimal terdiri dari 8 karakter</li>      
                              <li id ="validasiPasswordAngka">Terdapat angka</li>
                            </ul>
                         </div>   
                    </div>
                    <div class ="form-group col-md-12">
                    </div>
                    </div>

                    <div class="form-group input-group-lg col-md-6">
                        <input type="password" class="form-control" name="tulis_ulang_password"
                               placeholder="Tulis ulang sandi" id="tulis_ulang_password">
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password_ulang" style="color:#be272d;font-size:20px;font-weight: 300;">Tuliskan ulang sandi anda</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>
					<div class ="form-group col-md-12">
                        <span class="alert alert-success" id="sandiSama">Sandi yang anda tuliskan sama.</span>
                        <span class="alert alert-danger" id="sandiBerbeda">Sandi yang anda tuliskan berbeda.</span>
                    </div>
                    <div class ="form-group col-md-12">
                    </div>

                    <div class="form-group input-group-lg col-md-6">
                        <input type="text" class="form-control" placeholder="NIM/NIP" name="nomor_identitas" id="nama_depan">
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;">Nomor Identitas</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>

					<!--
                    <div class="form-group input-group-lg col-md-6">
                        <input type="number" class="form-control" placeholder="Nomor Induk Mahasiswa" name="nim" id="nim">
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;">NIM</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        
                    </div>
					-->
					
                    

                    <div class="form-group input-group-lg col-md-6">
                        <select class="form-control" name="universitas">
                            <option value="">-</option>
                            <?php
                            foreach ($universitas as $u) {
                            ?>
                            <option value="<?php echo $u->id_universitas; ?>"><?php echo $u->nama_pengguna; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;">Pilih universitas asal anda</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>


                    <div class="form-group input-group-lg col-md-6" id="container-prodi">
                        <select class="form-control" name="prodi" id="prodi">
                            <option value="">-</option>
                            <?php
                            foreach ($prodi as $p) {
                            ?>
                            <option value="<?php echo $p->id; ?>"><?php echo $p->detail_prodi; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group input-group-lg col-md-6" id="container-keterangan-prodi">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;">Pilih prodi anda</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>


                    <div class="form-group input-group-lg col-md-6">
                        <select class="form-control" name="jenjang">
                            <option value="">-</option>
                            <?php
                            foreach ($jenjang as $jp) {
                            ?>
                            <option value="<?php echo $jp->id; ?>"><?php echo $jp->detail_jenjang; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;">Pilih jenjang pendidikan anda</span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>


                    <div class="form-group input-group-lg col-md-6">
                        <button id="submit" type="submit" class="btn btn-danger btn-lg">Submit</button>
                        <br/>
                    </div>
                    <div class="form-group input-group-lg col-md-6">
                        <span id="validasi_password" style="color:#be272d;font-size:20px;font-weight: 300;"></span>
                        <input type="email" class="form-control" placeholder="Email" style="visibility: hidden;">
                        <!--pemberi jarak-->
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection
@section('additional_js')

    $(function(){

    $('#sandiSama').css("display","none");
    $('#sandiBerbeda').css("display","none")


    $('#nama_depan').keyup(function(){
        /*$('#nama_lengkap').val($('#nama_depan').val()+$('#nama_belakang').val());
        var text=$(this).val();
        $(this).val(text.replace(/[^A-Za-z]/g,''));*/
    });    

    $('#password').keyup(function(){
        $('#submit').prop('disabled', true);
        var password = $(this).val();

        var nama_depan = $('#nama_depan').val();
        var nama_belakang = $('#nama_belakang').val();

        var resultNamaDepan = password.toLowerCase().indexOf(nama_depan.toLowerCase()) > -1;
        var resultNamaBelakang = password.toLowerCase().indexOf(nama_belakang.toLowerCase()) > -1;

        //validasi dengan nama
        if (resultNamaDepan == true || resultNamaBelakang == true){
            $('#validasiPasswordNama').css('display','');
            $('#submit').prop('disabled', true);
        }else{
            $('#validasiPasswordNama').css('display','none');
            $('#submit').prop('disabled', false);
        }

        //validasi dengan panjang karakter
        if(password.length >= 8){
            $('#validasiPasswordKarakter').css('display','none');
            $('#submit').prop('disabled', false);
        }else{
            $('#validasiPasswordKarakter').css('display','');
            $('#submit').prop('disabled', true);
        }

        //validasi dengan angka
        if(password.match(/\d+/g) == null){
            $('#validasiPasswordAngka').css('display','');
            $('#submit').prop('disabled', true);
        }else{
            $('#validasiPasswordAngka').css('display','none');
            $('#submit').prop('disabled', false);
        }

        //pengatur aktivasi tombol submit
        if($('#validasiPasswordNama').css('display') == 'none' && $('#validasiPasswordKarakter').css('display') == 'none' && $('#validasiPasswordAngka').css('display') == 'none'){
            $('#area-validasi-password').css('display','none');
        }else{
            $('#area-validasi-password').css('display','');
        }
    });

    $('#tulis_ulang_password').keyup(function(){
        if($('#password').val() == $('#tulis_ulang_password').val()){
            $('#sandiSama').css("display","")
            $('#sandiBerbeda').css("display","none")
            /*$('#validasi_password_ulang').text("Sandi yang anda tuliskan ulang cocok");
            $("#validasi_password_ulang").css("color", "green");
            $("#validasi_password_ulang").css("background-color", "transparent");*/
        }else{
            /*$('#validasi_password_ulang').text("Sandi yang anda tuliskan ulang berbeda");
            $("#validasi_password_ulang").css("color", "#be272d");
            $("#validasi_password_ulang").css("background-color", "yellow");*/
            $('#sandiSama').css("display","none")
            $('#sandiBerbeda').css("display","")
        }
    });

    $('#nama_belakang').keyup(function(){
        /*$('#nama_lengkap').val($('#nama_depan').val()+$('#nama_belakang').val());
        var text=$(this).val();
        $(this).val(text.replace(/[^A-Za-z]/g,''));*/
    });    

    $('#email').keyup(function(){
    $('#validasi_email').css('visibility','visible');
    });

    $('#peran').change(function() {
    if($(this).val() == 3){
    $('#container-prodi').css('visibility','hidden');
    $('#container-keterangan-prodi').css('visibility','hidden');
    }else{
    $('#container-prodi').css('visibility','visible');
    $('#container-keterangan-prodi').css('visibility','visible');
    }
    });


    $("#form_daftar").validate({
    rules: {
    // simple rule, converted to {required:true}
    peran: "required",
    // compound rule
    email: {
    required: true,
    email: true
    },
    nama_depan: "required",
    nama_belakang: "required",
    password: "required",
    tulis_ulang_password: "required",
    nama: "required",
    universitas: "required",    
    jenjang: "required"
    },
    messages:{
    peran:"<span class='label label-danger' style='font-weight: lighter;'>Pilih peran anda di TADJ</span>",
    email: {
    required: "<span class='label label-danger' style='font-weight: lighter;'>Tuliskan email anda</span>",
    email: "<span class='label label-danger' style='font-weight: lighter;'>Email harus mengandung simbol '@' dan '.'</span>"
    },
    nama_depan: "<span class='label label-danger' style='font-weight: lighter;'>Tuliskan nama depan anda</span>",
    nama_belakang: "<span class='label label-danger' style='font-weight: lighter;'>Tuliskan nama belakang anda</span>",
    password: "<span class='label label-danger' style='font-weight: lighter;'>Tuliskan password anda</span>",
    tulis_ulang_password: "<span class='label label-danger' style='font-weight: lighter;'>Tuliskan ulang password anda</span>",
    nama: "<span class='label label-danger' style='font-weight: lighter;'>Tuliskan nama lengkap anda</span>",
    universitas: "<span class='label label-danger' style='font-weight: lighter;'>Pilih universitas anda</span>",
    jenjang: "<span class='label label-danger' style='font-weight: lighter;'>Pilih jenjang anda</span>"

    }
    });

    $("#email").keyup(function(){
            
    });


    });
@endsection
