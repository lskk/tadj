<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="http://167.205.7.228:8089/tadj/shortcut-icon.png"/>
    <?php echo Html::style('core/resources/assets/css/bootstrap.min.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/main.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/normalize.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/owl.carousel.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/responsive.css');?>
    <?php echo Html::style('core/resources/assets/css/halaman_utama/slicknav.css');?>
    <title>TADJ | Tugas Akhir Dalam Jaringan</title>
    <style>
        body {
            font-family: 'Lato';
        }
        @yield('additional_css')
    </style>
</head>

<body>
<section id="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block-right">
                    <nav class="navbar navbar-default" role="navigation">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
								<?php
								if(Session::get('status') == null){
								?>
                                <div class="nav-logo">
                                    <a href="../"><img src="../core/resources/assets/image/halaman_utama/logo.png" alt="logo" style="width:2.1em;height:2em;"></a>
                                </div>
								<?php
								}else{
									?>
								<div class="nav-logo">
                                    <a href="../"><img src="../core/resources/assets/image/halaman_utama/logo.png" alt="logo" style="width:2.1em;height:2em;"></a>
                                </div>
								<?php
								}
								?>
                            </div>
                            @yield('nav_link')
                            <!-- Collect the nav links, forms, and other content for toggling -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>
            </div><!-- .col-md-6 -->
        </div><!-- .row close -->
    </div><!-- .container close -->
</section>
@yield('content')
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <div class="footer-contant">
                        <h4 style="color:#FFF">© 2016 PPTIK Institut Teknologi Bandung</h4>
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
<?php echo Html::script('core/resources/assets/js/jquery.lazyload.js');?>
<script>
    $("img.lazy").lazyload({
    effect : "fadeIn"
    });
    @yield('additional_js')
</script>
</body>
</html>