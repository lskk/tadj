<!DOCTYPE html>
<html>
    <head>
        <title>TADJ | Tugas Akhir Dalam Jaringan</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #333;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }

            a{
                color:#be272d;
                text-decoration: none;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Halaman yang anda tuju tidak ditemukan</div>
                <br/>
                <?php
                if (Session::get('status') == NULL) {
                ?>
                <a href="http://tadj.lskk.ee.itb.ac.id">&lt;Kembali ke halaman utama</a>
                <?php
                }else{
                ?>
                <a href="http://tadj.lskk.ee.itb.ac.id">&lt;Kembali ke halaman utama</a>
                <?php
                }
                ?>

            </div>
        </div>
    </body>
</html>
