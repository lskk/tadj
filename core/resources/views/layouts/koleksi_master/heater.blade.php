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
    <?php echo Html::style('core/resources/assets/css/halaman_utama/sweetalert.css');?>
	<?php echo Html::style('core/resources/assets/css/jquery.dataTables.min.css');?>
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
    @yield('header')
    <!-- .container close -->
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
<?php echo Html::script('core/resources/assets/js/jquery-ui.min.js');?>
<?php echo Html::script('core/resources/assets/js/halaman_utama/owl.carousel.min.js');?>
<?php echo Html::script('core/resources/assets/js/halaman_utama/bootstrap.min.js');?>
<?php echo Html::script('core/resources/assets/js/halaman_utama/main.js');?>
<?php echo Html::script('core/resources/assets/js/halaman_utama/sweetalert.min.js');?>
<?php echo Html::script('core/resources/assets/js/jquery.validate.min.js');?>
<?php echo Html::script('core/resources/assets/js/jquery.dataTables.min.js');?>
<?php echo Html::script('core/resources/assets/js/dataTables.bootstrap.min.js');?>
<?php echo Html::script('core/resources/assets/js/jquery.dataTables.yadcf.js');?>

<?php echo Html::script('core/resources/assets/export-table/tableExport.js');?>
<?php echo Html::script('core/resources/assets/export-table/jquery.base64.js');?>

<?php echo Html::script('core/resources/assets/export-table/jspdf/libs/sprintf.js');?>
<?php echo Html::script('core/resources/assets/export-table/jspdf/jspdf.js');?>
<?php echo Html::script('core/resources/assets/export-table/jspdf/libs/base64.js');?>



<script type='text/javascript'>

    
	
	$(document).ready(function(){
    @yield('additional_js')
	});
</script>
</body>
</html>