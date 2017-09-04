<!DOCTYPE html><!-- halaman pertama kali diakses sebelum masuk ke sistem-->
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="http://167.205.7.228:8089/tadj/shortcut-icon.png"/>
    <?php echo Html::style('core/resources/assets/css/bootstrap.min.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/main.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/normalize.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/owl.carousel.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/responsive.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/slicknav.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/sweetalert.css');?>
    <title>@yield('title')</title>
    <style>
        body {
            font-family: 'Lato';
        }

        #anchor_lihat_selengkapnya {
            color: #bd000b;
        }
        @yield('additional_css')
    </style>

</head>

<body>
@yield('body')
<section id="header">
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

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li><a href="topik/lihat_selengkapnya">Judul Tugas Akhir</a></li>
                                    <li><a href="#service">Alur</a></li>
                                    <li><a href="#masuk">Masuk</a></li>
                                    <li><a href="daftar">Daftar</a></li>
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
    <!-- .container close -->
</section>

<section id="slider"
         style="background: url(http://167.205.7.228:8089/tadj/halaman_awal/file.png) no-repeat;background-size: cover; background-position: center center; padding-bottom: 255px;padding-top: 180px; ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <div class="slider-text-area">
                        <div class="slider-text">
                            <h2>Ingin mengerjakan tugas akhir dengan mudah?<br></h2>

                            <p class="sub-slider-text">Tugas Akhir Dalam Jaringan solusinya</p>

                            <p class="slider-p">Dengan mendaftarkan diri anda, anda dapat mengambil judul tugas
                                akhir,<br/>
                                melakukan bimbingan, dan kegiatan lainnya yang berhubungan dengan<br/>
                                pengerjaan tugas akhir secara online.</p>
                                <br/>
                            <a class="btn btn-success col-md-2" href="daftar">DAFTAR</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .col-md-12 close -->
        </div>
        <!-- .row close -->
    </div>
    <!-- .container close -->
</section>


<section id="service">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block-top">
                    <div class="service-header">
                        <h1>Alur</h1>
                    </div>
                </div>
            </div>
            <!-- .col-md-12 close -->
        </div>
        <!-- row close -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-bottom">
                    <div class="service-tab">
                        <!-- Nav tabs -->
                        <ul class="badhon-tab" role="tablist">
                            <li class="active"><a href="#pengenalan" aria-controls="home" role="tab" data-toggle="tab">
                                    Mahasiswa
                                </a></li>
                            <!--<li><a href="#visi" aria-controls="profile" role="tab" data-toggle="tab">
                                    Pengenalan
                                </a></li>-->
                            
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content edit-tab-content">
                            <div class="tab-pane active edit-tab" id="pengenalan">
                                <!--<div class="teb-icon-edit">-->
                                <!--<i class="fa fa-heart-o"></i>-->
                                <!--</div>-->
                                <img src="http://167.205.7.228:8089/tadj/halaman_awal/alur.png" style="width:80%;height:80%;" alt="img">
                            </div>
                            <!--<div class="tab-pane edit-tab" id="visi">
                                
                                <div class="embed-responsive embed-responsive-16by9">
                                    <video class="embed-responsive-item" controls>
                                        <source src="http://167.205.7.228:8089/tadj/halaman_awal/video.mp4" type="video/mp4">
                                    </video>
                                </div>
                            </div>-->
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- .col-md-12 close -->
        </div>
        <!-- row close -->
    </div>
    <!-- .container close -->
</section>

<section id="contant-2">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="block-left">
                    <div class="contant-2-img">
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <img src="http://167.205.7.228:8089/tadj/halaman_awal/desk.png" alt="img">
                    </div>
                </div>
            </div>
            <!-- .col-md-6 close -->

            <div class="col-md-6" id="masuk">
                <div class="block-right">
                    <div class="contant-2-text-area">
                        <div class="contant-2-text">
                            <h2>Masuk</h2>

                            <form method="post" action="masuk">
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
                            <p>Jika anda belum memiliki akun TADJ, silahkan pilih tombol daftar di bawah ini. </p>
                            <a class="btn btn-default edit-button-3" href="daftar">DAFTAR</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .col-md-6 close -->
        </div>
        <!-- .row close -->
    </div>
    <!-- .container close -->
</section>

<section id="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <div class="testimonial-area">
                        <div class="tm-header">
                            <h2>Apa yang dikatakan mengenai TADJ</h2>
                        </div>
                        <div class="tm-contant">
                            <div class="tm-contant-items" id="slide-testimonial">
                                <div class="tm-contant-list item">
                                    <div class="tm-img">
                                        <img src="http://167.205.7.228:8089/tadj/halaman_awal/Silvia.jpg" alt="img">
                                    </div>
                                    <div class="tm-text">
                                        <p>" Keren sangat membantu pengerjaan tugas akhir." <span><i> Silvia Graviolen - TKJMD ITB</i></span></p>
                                    </div>
                                </div>                        
                                <div class="tm-contant-list item">
                                    <div class="tm-img">
                                        <img src="http://167.205.7.228:8089/tadj/halaman_awal/Halim.jpg" alt="img">
                                    </div>
                                    <div class="tm-text">
                                        <p>" Terus kembangkan." <span><i> Mohammad Halim Bimantara - TKJMD ITB</i></span></p>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .col-md-12 close -->
        </div>
        <!-- .row close -->
    </div>
    <!-- .container close -->
</section>

<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <div class="footer-contant">
                        <h4 style="color:#FFF">© 2017 PPTIK Institut Teknologi Bandung</h4>
                        {{--<div class="social-icon">--}}
                        {{--<a href="#"><i class="fa fa-facebook"></i></a>--}}
                        {{--<a href="#"><i class="fa fa-twitter"></i></a></div>--}}
                        <!-- <div class="support-link">
                            <ul>
                                <li><a href="#">tadj@lskk.ee.itb.ac.id </a></li>
                                <li><a href="#">+62 22 2500960</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- col-md-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container -->
</section>

<?php echo Html::script('core/resources/assets/js/jquery.min.js');?>
<?php echo Html::script('core/resources/assets/js/halaman_utama/owl.carousel.min.js');?>
<?php echo Html::script('core/resources/assets/js/halaman_utama/bootstrap.min.js');?>
<?php echo Html::script('core/resources/assets/js/halaman_utama/main.js');?>
<?php echo Html::script('core/resources/assets/js/halaman_utama/sweetalert.min.js');?>
<?php echo Html::script('core/resources/assets/js/jquery.lazyload.js');?>
<script type="text/javascript" src="http://arrow.scrolltotop.com/arrow46.js"></script>


<script>
    $("img.lazy").lazyload({
    effect : "fadeIn"
    });
    @yield('additional_js')
</script>
</body>
</html>