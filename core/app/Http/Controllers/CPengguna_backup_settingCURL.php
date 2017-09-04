<?php
    
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

//session_start();

use App\MDosen;
use App\MMahasiswa;
use App\MMahasiswaKonfirmasi;
use App\MUniversitas;
use Hash;
use DB;
use Mail;
use Session;
use Auth;
use Cookie;
use App\MPengguna;
use Illuminate\Support\Facades\Redirect;
use App\Libraries\ldap\ldap_connect;
use App\Libraries\ldap\SimpleLDAP;
    
class CPengguna extends Controller
{
    
    
    //awal inti CPengguna
    /**
     * Show the profile for the given user.
     *
     * @param  int $id
     * @return Response
     */
    public function index()
    {
        //$pengguna = MPengguna::all();

        //return view('layouts.index')->with('pengguna', $pengguna);
        if (Session::get('status') == NULL) {
            return view('layouts.index');
        } else {
            //ambil informasi
            /*$ambil_informasi = DB::table('informasi')
                ->get();*/

            /*return view('layouts.dashboard')
                ->with('informasi',$ambil_informasi);*/
            return Redirect::to('dashboard');
        }
    }

    public function lupa_kata_sandi(){
      $data = array(
        'name' => "Learning Laravel",
      );

      Mail::send('layouts.email.fpassword', $data, function ($message) {

          $message->from('tadjlskk@gmail.com', 'Learning Laravel');

          $message->to('emilhamep@gmail.com')->subject('Learning Laravel test email');

      });
      return view('layouts.pengguna.lupa_sandi');
    }

    public function daftar()
    {
        
        //universitas
        $universitas = DB::table('pengguna')
            ->select('universitas.id as id_universitas', 'pengguna.nama as nama_pengguna')
            ->join('universitas', 'pengguna.id', '=', 'universitas.id_pengguna')
            ->where('pengguna.status', '=', '2')
            ->orderBy('pengguna.nama', 'asc')
            ->get();

        //prodi
        $prodi = DB::table('prodi')
            ->where('id', '!=', 0)
            ->orderBy('prodi.detail_prodi', 'asc')
            ->get();

        //jenjang pendidikan
        $jenjang_pendidikan = DB::table('jenjang')
            ->orderBy('jenjang.detail_jenjang', 'asc')
            ->get();
        
        
        return view('layouts.daftar')
            ->with('prodi', $prodi)
            ->with('jenjang', $jenjang_pendidikan)
            ->with('universitas', $universitas);
    }

    public function GenerateAllTableWp($nama_blog,$id_mahasiswa,$email){
            date_default_timezone_set('Asia/Jakarta');
            $datetime=date("Y-m-d h:i:s"); //create date time
            
            $sqlInsertWPBlogs = DB::connection('mysql3')->insert("insert into wordpress.wp_blogs (site_id,domain,path,registered) VALUES (1,'tadj.lskk.ee.itb.ac.id','/blog/".$nama_blog."/','$datetime')");            
            //$sqlInsertWPBlogs="INSERT INTO wordpress.wp_blogs (site_id,domain,path,registered) VALUES (1,'tadj.lskk.ee.itb.ac.id','/blog/$blog_name/','$datetime')";
            if($sqlInsertWPBlogs){
                 $this->createTableWpOptions($nama_blog,$id_mahasiswa,$email);
            }else{
                echo $sqlInsertWPBlogs;
            }
    }

    public function createTableWpOptions($nama_blog,$id_mahasiswa,$email){
            $id_blog = null;

            $sqlGetBlog_id = DB::connection('mysql3')->select("select * from wordpress.wp_blogs WHERE path='/blog/".$nama_blog."/'");
            //$sqlGetBlog_id=mysql_query("SELECT * FROM wordpress.wp_blogs WHERE path='/blog/$blog_name/'");
            // while ($rowGetID=mysql_fetch_array($sqlGetBlog_id)) {
            //       $Blog_ID=$rowGetID[0];
            // }

            foreach ($sqlGetBlog_id as $sgbi) {
                $id_blog = $sgbi->blog_id;
            }

            date_default_timezone_set('Asia/Jakarta');
            $datetime=date("Y-m-d h:i:s"); //create date time

            //konfigurasi masuk ke wordpress masing-masing akun
            
            //comment meta
            DB::connection('mysql3')->statement("CREATE TABLE IF NOT EXISTS wp_".$id_blog."_commentmeta (
              `meta_id` bigint(20) unsigned NOT NULL,
              `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
              `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `meta_value` longtext COLLATE utf8mb4_unicode_ci
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_commentmeta` ADD PRIMARY KEY (`meta_id`),ADD KEY `comment_id` (`comment_id`),ADD KEY `meta_key` (`meta_key`(191));");
            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_commentmeta` MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");
            //akhir comment meta
            
            //comments    
        DB::connection('mysql3')->statement("CREATE TABLE IF NOT EXISTS wp_".$id_blog."_comments (
          `comment_ID` bigint(20) unsigned NOT NULL,
          `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
          `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
          `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
          `comment_karma` int(11) NOT NULL DEFAULT '0',
          `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
          `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
          `user_id` bigint(20) unsigned NOT NULL DEFAULT '0'
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        DB::connection('mysql3')->statement("ALTER TABLE wp_".$id_blog."_comments
                  ADD PRIMARY KEY (`comment_ID`),
                  ADD KEY `comment_post_ID` (`comment_post_ID`),
                  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
                  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
                  ADD KEY `comment_parent` (`comment_parent`),
                  ADD KEY `comment_author_email` (`comment_author_email`(10));");

        DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_comments` MODIFY `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;");        

        DB::connection('mysql3')->insert("INSERT INTO `wp_".$id_blog."_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES (1, 1, '', '', '', '', '$datetime', '$datetime', '', 0, '1', '', '', 0, 0);");
            //akhir comments

            //links            
            DB::connection('mysql3')->statement("CREATE TABLE IF NOT EXISTS wp_".$id_blog."_links (
              `link_id` bigint(20) unsigned NOT NULL,
              `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
              `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
              `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
              `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
              `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
              `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
              `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
              `link_rating` int(11) NOT NULL DEFAULT '0',
              `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
              `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
              `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");    

            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_links`ADD PRIMARY KEY (`link_id`),ADD KEY `link_visible` (`link_visible`);");        
            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_links` MODIFY `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;");        

            //akhir links

            //options        

            DB::connection('mysql3')->statement("CREATE TABLE IF NOT EXISTS wp_".$id_blog."_options (
              `option_id` bigint(20) unsigned NOT NULL,
              `option_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
              `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
              `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
            ) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");    

            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_options` ADD PRIMARY KEY (`option_id`),ADD UNIQUE KEY `option_name` (`option_name`);");        
            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_options` MODIFY `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137");        
            //akhir options

            //postmeta            
            DB::connection('mysql3')->statement("CREATE TABLE IF NOT EXISTS wp_".$id_blog."_postmeta (
              `meta_id` bigint(20) unsigned NOT NULL,
              `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
              `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `meta_value` longtext COLLATE utf8mb4_unicode_ci
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");    

            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_postmeta`ADD PRIMARY KEY (`meta_id`),ADD KEY `post_id` (`post_id`),ADD KEY `meta_key` (`meta_key`(191));");        
            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_postmeta` MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;");        
            DB::connection('mysql3')->insert("INSERT INTO `wp_".$id_blog."_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (1, 2, '_wp_page_template', 'default')");
            //akhir postmeta

            //posts          
            DB::connection('mysql3')->statement("CREATE TABLE IF NOT EXISTS wp_".$id_blog."_posts (
                  `ID` bigint(20) unsigned NOT NULL,
                  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
                  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
                  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
                  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
                  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
                  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
                  `post_password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
                  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
                  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
                  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                  `menu_order` int(11) NOT NULL DEFAULT '0',
                  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
                  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                  `comment_count` bigint(20) NOT NULL DEFAULT '0'
                ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");    

            DB::connection('mysql3')->statement("ALTER TABLE wp_".$id_blog."_posts
                  ADD PRIMARY KEY (`ID`),
                  ADD KEY `post_name` (`post_name`(191)),
                  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
                  ADD KEY `post_parent` (`post_parent`),
                  ADD KEY `post_author` (`post_author`);");        

            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_posts` MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;");        
            DB::connection('mysql3')->insert("INSERT INTO `wp_".$id_blog."_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '$datetime', '$datetime', 'Welcome to ', 'Hello world!', '', 'publish', 'open', 'open', '', 'hello-world', '', '', '$datetime', '$datetime', '', 0, 'http://tadj.lskk.ee.itb.ac.id/blog/".$nama_blog."/?p=1', 0, 'post', '', 1)");
            //akhir posts

            //terms                
        DB::connection('mysql3')->statement("CREATE TABLE IF NOT EXISTS wp_".$id_blog."_terms (
          `term_id` bigint(20) unsigned NOT NULL,
          `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `term_group` bigint(10) NOT NULL DEFAULT '0'
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");    

            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_terms`
                  ADD PRIMARY KEY (`term_id`),
                  ADD KEY `slug` (`slug`(191)),
                  ADD KEY `name` (`name`(191));");        

            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_terms` MODIFY `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;");        
            DB::connection('mysql3')->insert("INSERT INTO `wp_".$id_blog."_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES (1, 'Uncategorized', 'uncategorized', 0);");
            //akhir terms

            //term_relationship            
            DB::connection('mysql3')->statement("CREATE TABLE IF NOT EXISTS `wp_".$id_blog."_term_relationships` (
              `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
              `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
              `term_order` int(11) NOT NULL DEFAULT '0'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");    

            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_term_relationships`
                      ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
                      ADD KEY `term_taxonomy_id` (`term_taxonomy_id`)");        
            
            DB::connection('mysql3')->insert("INSERT INTO `wp_".$id_blog."_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES (1, 1, 0)");
            //akhir_term_relationship

            //term_taxonomy
            DB::connection('mysql3')->statement("CREATE TABLE IF NOT EXISTS wp_".$id_blog."_term_taxonomy (
          `term_taxonomy_id` bigint(20) unsigned NOT NULL,
          `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
          `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
          `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
          `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
          `count` bigint(20) NOT NULL DEFAULT '0'
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");    

            DB::connection('mysql3')->statement("ALTER TABLE `wp_".$id_blog."_term_taxonomy`
              ADD PRIMARY KEY (`term_taxonomy_id`),
              ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
              ADD KEY `taxonomy` (`taxonomy`);");        
            
            DB::connection('mysql3')->insert("INSERT INTO `wp_".$id_blog."_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES (1, 1, 'category', '', 0, 1);"); 
            //akhir term_taxonomy

            //akhir konfigurasi
            //$wp_options = DB::connection('mysql3')->statement('select * from wordpress.wp_99_options');
            $wp_options = DB::connection('mysql3')->select('select * from wordpress.wp_99_options');

            

            foreach ($wp_options as $row) {
                DB::connection('mysql3')->insert("INSERT INTO wordpress.wp_".$id_blog."_options VALUES ('".$row->option_id."','".$row->option_name."','".$row->option_value."','".$row->autoload."')"); 
                DB::connection('mysql3')->statement("UPDATE wordpress.wp_".$id_blog."_options SET option_value='http://tadj.lskk.ee.itb.ac.id/blog/$blog_name' WHERE option_id=1");        
                DB::connection('mysql3')->statement("UPDATE wordpress.wp_".$id_blog."_options SET option_value='http://tadj.lskk.ee.itb.ac.id/blog/$blog_name' WHERE option_id=2");        
                DB::connection('mysql3')->statement("UPDATE wordpress.wp_".$id_blog."_options SET option_value='$blog_name' WHERE option_id=3");
                DB::connection('mysql3')->statement("UPDATE wordpress.wp_".$id_blog."_options SET option_value='".$email."' WHERE option_id=6");
                DB::connection('mysql3')->statement("UPDATE wordpress.wp_".$id_blog."_options SET option_name='wp_".$id_blog."_user_roles' WHERE option_id=89");
            }


            DB::connection('mysql')->insert("INSERT INTO tadj_new.blog (id_mahasiswa,url_blog) VALUES ('".$id_mahasiswa."','http://tadj.lskk.ee.itb.ac.id/blog/".$nama_blog."/')");


        }

    public function proses_daftar()
    {
		//Cek email sudah terdaftar sebelumnya/belum
		$cek_email = DB::table('pengguna')
            ->select('*')
            ->where('email', '=', $_POST['email'])
            ->get();
		
		$cek_username = DB::table('pengguna')
					->select('*')
					->where('nama', '=', $_POST['nama'])
					->get();		
		
		if(count($cek_email)== 0 && count($cek_username) == 0){//bisa dilanjutkan
			//pengguna
        $pengguna = new MPengguna();

        $pengguna->email = $_POST['email'];
		$pengguna->password_murni = $_POST['password'];
        $pengguna->password = bcrypt($_POST['password']);
        //$pengguna->nim = $_POST['nim'];
        $pengguna->nama = $_POST['nama'];//$_POST["nama_depan"]
		$pengguna->nama_depan = $_POST['nama_depan'];
		$pengguna->nama_belakang = $_POST['nama_belakang'];
        $pengguna->jenjang = $_POST['jenjang'];
        $pengguna->id_universitas = $_POST['universitas'];
        $pengguna->id_prodi = $_POST['prodi'];
        $pengguna->status = $_POST['peran'];

        $pengguna->save();



        $ambil_id_pengguna = DB::table('pengguna')
            ->select('id','id_universitas')
            ->where('email', '=', $_POST['email'])
            ->get();

        $final_ambil_id_pengguna = null;
        foreach ($ambil_id_pengguna as $ambil_id_pengguna) {
            $final_ambil_id_pengguna = $ambil_id_pengguna;
        }

        if ($_POST['peran'] == 3) {
            //dosen
            $dosen = new MDosen();

            $dosen->id_pengguna = $final_ambil_id_pengguna->id;
            $dosen->id_universitas = $_POST['universitas'];
            $dosen->save();

            //untuk penentuan informasi di dashboard

            Session::set('status','3');
            Session::set('nama', $_POST['nama']);
            Session::set('id_pengguna', $final_ambil_id_pengguna->id);

            //ambil id dosen
            $ambil_id_dosen = DB::table('dosen')
                ->select('id')
                ->where('id_pengguna', '=', $final_ambil_id_pengguna->id)
                ->get();

            $final_ambil_id_dosen = null;
            foreach ($ambil_id_dosen as $a) {
                $final_ambil_id_dosen = $a;
            }

            Session::set('id', $final_ambil_id_dosen->id);
            Session::set('id_universitas', $final_ambil_id_pengguna->id_universitas);
			
			//ke Active Directory  Windows Server 2012
        // Username used to connect to the server
		$username = "emilhamep";

		// Password of the user.
		$password = "Fadillah!24";

		// Domain used to connect to.
		$domain = "tadj.local";

		// Proper username to connect with.
		$domain_username = "$username" . "@" . $domain;

		// User directory. Such as all users are placed in
		// the Users directory by default.
		$user_dir = "DC=tadj,DC=local";

		// Either an IP or a domain.
		$ldap_server = "ta.tadj.local";

		// Get a connection
		$ldap_conn = ldap_connect($ldap_server);

		// Set LDAP_OPT_PROTOCOL_VERSION to 3
		ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3) or die ("Could not set LDAP Protocol version");

		// Authenticate the user and link the resource_id with
		// the authentication.
		if($ldapbind = ldap_bind($ldap_conn, $domain_username, $password) == true)
		{
		// Setup the data that will be used to create the user
		// This is in the form of a multi-dimensional
		// array that will be passed to AD to insert.

		$adduserAD["cn"] = $_POST["nama"];
		$adduserAD["givenname"] = $_POST["nama_depan"];
		$adduserAD["sn"] = $_POST["nama_belakang"];
		$adduserAD["sAMAccountName"] = $_POST['nama'];
		//$adduserAD['userPrincipalName'] = $_POST["nama_depan"]."@tadj.local";
    $adduserAD['userPrincipalName'] = str_replace(' ', '', $_POST["nama"])."@tadj.local";
		$adduserAD["mail"] = $_POST["email"];
		$adduserAD["objectClass"] = "User";
		$adduserAD["displayname"] = $_POST["nama"];
		$adduserAD["userPassword"] = $_POST['password'];
		$adduserAD["userAccountControl"] = "544";

		$base_dn = "cn=".$_POST["nama"].", OU=TADJUsers,DC=tadj,DC=local";

		// Attempt to add the user with ldap_add()
		if(ldap_add($ldap_conn, $base_dn, $adduserAD) == true)
		{

		// The user is added and should be ready to be logged
		// in to the domain.
		echo "User added!<br>";
		
		$group_name = "CN=Dosen,OU=TADJUsers,DC=tadj,DC=local";
		$group_info['member'] = $base_dn; // User's DN is added to group's 'member' array

		if(ldap_mod_add($ldap_conn,$group_name,$group_info) == true)
		{
			//echo "User ditambahkan ke grup";
		}else{
			//echo "gagal ditambahkan ke grup";
		}

		}else{

		// This error message will be displayed if the user
		// was not able to be added to the AD structure.
		echo "Sorry, the user was not added.<br>Error Number: ";
		echo ldap_errno($ldap_conn) . "<br />Error Description: ";
		echo ldap_error($ldap_conn) . "<br />";
		}
		}else{
		echo "Could not bind to the server. Check the username/password.<br />";
		echo "Server Response:"

		// Error number.
		. "<br />Error Number: " . ldap_errno($ldap_conn)

		// Error description.
		. "<br />Description: " . ldap_error($ldap_conn);
		}

		// Always make sure you close the server after
		// your script is finished.
		ldap_close($ldap_conn);
        //akhir ke Active Directory  Windows Server 2012
		
        } else if ($_POST['peran'] == 4) {


            //mahasiswa
            $mahasiswa = new MMahasiswa();

            $mahasiswa->id_pengguna = $final_ambil_id_pengguna->id;
            $mahasiswa->status_konfirmasi = 0;
            $mahasiswa->save();

            //mahasiswa_konfirmasi
//            $mahasiswa_konfirmasi = new MMahasiswaKonfirmasi();
//
//            $mahasiswa_konfirmasi->id_universitas = $_POST['universitas'];
//            $mahasiswa_konfirmasi->id_mahasiswa = $final_ambil_id_mahasiswa->id;
//            $mahasiswa_konfirmasi->status = 0;
//            $mahasiswa_konfirmasi->save();

            //untuk penentuan informasi di dashboard
            Session::set('status','4');
            Session::set('nama', $_POST['nama']);
            Session::set('id_pengguna', $final_ambil_id_pengguna->id);
            //ambil id mahasiswa
            $ambil_id_mahasiswa = DB::table('mahasiswa')
                ->select('id')
                ->where('id_pengguna', '=', $final_ambil_id_pengguna->id)
                ->get();

            $final_ambil_id_mahasiswa = null;
            foreach ($ambil_id_mahasiswa as $ambil_id_mahasiswa) {
                $final_ambil_id_mahasiswa = $ambil_id_mahasiswa;
            }

            //ke wordpress
            /*$final_nama = $_POST['nama'];
            $nama_blog=$_POST['jenjang'].$_POST['nim'].$final_nama;
            $this->GenerateAllTableWp($nama_blog,$final_ambil_id_mahasiswa->id,$_POST['email']);*/
            //akhir ke wordpress

            Session::set('id_pengguna_mahasiswa', $final_ambil_id_mahasiswa->id);

            Session::set('id_universitas', $final_ambil_id_pengguna->id_universitas);
            //Session::flash('dari_pendaftaran', 'ada');
			
			//ke Active Directory  Windows Server 2012
        // Username used to connect to the server
		$username = "emilhamep";

		// Password of the user.
		$password = "Fadillah!24";

		// Domain used to connect to.
		$domain = "tadj.local";

		// Proper username to connect with.
		$domain_username = "$username" . "@" . $domain;

		// User directory. Such as all users are placed in
		// the Users directory by default.
		$user_dir = "DC=tadj,DC=local";

		// Either an IP or a domain.
		$ldap_server = "ta.tadj.local";

		// Get a connection
		$ldap_conn = ldap_connect($ldap_server);

		// Set LDAP_OPT_PROTOCOL_VERSION to 3
		ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3) or die ("Could not set LDAP Protocol version");

		// Authenticate the user and link the resource_id with
		// the authentication.
		if($ldapbind = ldap_bind($ldap_conn, $domain_username, $password) == true)
		{
		// Setup the data that will be used to create the user
		// This is in the form of a multi-dimensional
		// array that will be passed to AD to insert.

		$adduserAD["cn"] = $_POST["nama"];
		$adduserAD["givenname"] = $_POST["nama_depan"];
		$adduserAD["sn"] = $_POST["nama_belakang"];
		$adduserAD["sAMAccountName"] = $_POST['nama'];
    $adduserAD['userPrincipalName'] = str_replace(' ', '', $_POST["nama"])."@tadj.local";
		//$adduserAD['userPrincipalName'] = $_POST["nama_depan"]."@tadj.local";
		$adduserAD["mail"] = $_POST["email"];
		$adduserAD["objectClass"] = "User";
		$adduserAD["displayname"] = $_POST["nama"];
		//$adduserAD["userPassword"] = $_POST['password'];
		$adduserAD["userPassword"] = $_POST['password'];
		$adduserAD["userAccountControl"] = "544";

		$base_dn = "cn=".$_POST["nama"].", OU=TADJUsers,DC=tadj,DC=local";

		// Attempt to add the user with ldap_add()
		if(ldap_add($ldap_conn, $base_dn, $adduserAD) == true)
		{

		// The user is added and should be ready to be logged
		// in to the domain.
		echo "User added!<br>";
		
		$group_name = "CN=Mahasiswa,OU=TADJUsers,DC=tadj,DC=local";
		$group_info['member'] = $base_dn; // User's DN is added to group's 'member' array

		if(ldap_mod_add($ldap_conn,$group_name,$group_info) == true)
		{
			//echo "User ditambahkan ke grup";
		}else{
			//echo "gagal ditambahkan ke grup";
		}

		}else{

		// This error message will be displayed if the user
		// was not able to be added to the AD structure.
		echo "Sorry, the user was not added.<br>Error Number: ";
		echo ldap_errno($ldap_conn) . "<br />Error Description: ";
		echo ldap_error($ldap_conn) . "<br />";
		}
		}else{
		echo "Could not bind to the server. Check the username/password.<br />";
		echo "Server Response:"

		// Error number.
		. "<br />Error Number: " . ldap_errno($ldap_conn)

		// Error description.
		. "<br />Description: " . ldap_error($ldap_conn);
		}

		// Always make sure you close the server after
		// your script is finished.
		ldap_close($ldap_conn);
        //akhir ke Active Directory  Windows Server 2012
        }

        Session::set('password', $_POST['password']);
        Session::set('email', $_POST['email']);
		
        

        //ke hosting_alumni		
		/*$connection = mysqli_connect("tadj.lskk.ee.itb.ac.id","emilhamep","Fadillah!24","hostingalumni");

		mysqli_query($connection,"insert into hostingalumni.tbl_user values(null,'".$_POST["nama"]."','".$_POST["nama_depan"]."','".$_POST["nama_belakang"]."','".$_POST['email']."','".$_POST['password']."','".$_POST['nama']."')");

		$query = mysqli_query($connection,"select * from hostingalumni.tbl_profile order by id desc limit 0,1");

		$id = 0;
		while($row = mysqli_fetch_array($query,MYSQLI_NUM)){
			$id = $row[0]+1;
		}
		mysqli_query($connection,"insert into hostingalumni.tbl_profile values('".$id."',null,0,'','0000-00-00',0,'','','','',0)");

		$query = mysqli_query($connection,"select * from hostingalumni.tbl_photo order by id desc limit 0,1");
		$id = 0;
		while($row = mysqli_fetch_array($query,MYSQLI_NUM)){
			$id = $row[0]+1;
		}
		mysqli_query($connection,"insert into hostingalumni.tbl_photo values('".$id."',null,0,null,'','0000-00-00',0,0)");
		$_SESSION['username'] = $_POST["nama"];*/
        //akhir ke hosting_alumni

        //ke hosting alumni

        //tbl_user
        $random_id = sha1(microtime());
        DB::connection('mysql2')->insert("insert into hostingalumni.tbl_user values('".$random_id."','".$_POST["nama"]."','".$_POST["nama_depan"]."','".$_POST["nama_belakang"]."','".$_POST['email']."','".bcrypt($_POST['password'])."','".$_POST['nama']."')");
        //akhir tbl_user

        //tbl_profile
        $ambil_profile_yang_terakhir = DB::connection('mysql2')->select('select * from hostingalumni.tbl_profile order by id desc limit 0,1');

        $id_tbl_profile = null;
        foreach ($ambil_profile_yang_terakhir as $ayt) {
            $id_tbl_profile = $ayt->id+1;
        }

        DB::connection('mysql2')->insert("insert into hostingalumni.tbl_profile values('".$id_tbl_profile."',0,0,'','0000-00-00',0,'','','','',0)");
        //akhir tbl_profile

        //tbl_photo
        $ambil_photo_yang_terakhir = DB::connection('mysql2')->select('select * from hostingalumni.tbl_photo order by id desc limit 0,1');
        $id_tbl_photo = null;
        foreach ($ambil_photo_yang_terakhir as $apt) {
            $id_tbl_photo = $apt->id+1;
        }

        DB::connection('mysql2')->insert("insert into hostingalumni.tbl_photo values('".$id_tbl_photo."','".$random_id."',0,'default.png','','0000-00-00',0,0)");

        //akhir tbl_photo
        //Cookie::make('cname', $_POST["nama"], 60);
        setcookie('cname', $_POST["nama"], time() + (86400 * 30), "/");

        //akhir ke hosting alumni    


        Auth::attempt(['email' => $_POST['email'], 'password' => $_POST['password']]);
        Session::flash('pesan_berhasil_masuk_sistem', '<b>Email dan sandi tidak cocok</b>.');
    
        return Redirect::to('dashboard');            
		}else{
			Session::flash('gagal_daftar', '<b>Maaf email atau username sudah terdaftar sebelumnya</b>.');
            return Redirect::to('daftar');
		}	                      
    }
	
	public function login(){
		return view('layouts.masuk');
	}
    public function masuk()//proses login
    {
        //ambil password berdasarkan email pengguna

        $password = DB::table('pengguna')
            ->select('password')
            ->where('email', '=', $_POST['email'])
            ->get();

        if($password != null){//email terdaftar dan lakukan pengecekan email
            $ambil_password = null;
            foreach ($password as $password) {
                $ambil_password = $password;
            }

            $pengguna = Hash::check($_POST['password'], $ambil_password->password);
            if($pengguna == true){//email dan sandi cocok
                //ambil status pengguna

                //curl
        curl_init();

        curl_setopt(curl_init(), CURLOPT_URL,"http://tadj.lskk.ee.itb.ac.id/moodle/login/index.php");
        curl_setopt(curl_init(), CURLOPT_POST, 1);
        curl_setopt(curl_init(), CURLOPT_POSTFIELDS,"username=MTadj&&password=mTadj");

        
        curl_setopt(curl_init(), CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec (curl_init());

        echo $server_output;
        curl_close (curl_init());
        //end curl

                $ambil_status_pengguna = DB::table('pengguna')
                    ->select('*')
                    ->where('pengguna.email', '=', $_POST['email'])
                    ->get();

                $final_ambil_status_pengguna = null;

                foreach ($ambil_status_pengguna as $a) {
                    $final_ambil_status_pengguna = $a;
                }

                Session::set('status', $final_ambil_status_pengguna->status);
                Session::set('nama', $final_ambil_status_pengguna->nama);
                Session::set('password', $_POST['password']);
                Session::set('id_pengguna', $final_ambil_status_pengguna->id);

                //cek peran pengguna
                if ($final_ambil_status_pengguna->status == 3) {//dosen
                    //ambil id dosen
                    $ambil_id_pengguna = DB::table('dosen')
                        ->select('id','id_universitas')
                        ->where('id_pengguna', '=', $final_ambil_status_pengguna->id)
                        ->get();

                    $final_ambil_id_pengguna = null;
                    foreach ($ambil_id_pengguna as $a) {
                        $final_ambil_id_pengguna = $a;
                    }


                    Session::set('id', $final_ambil_id_pengguna->id);
                    Session::set('id_universitas', $final_ambil_id_pengguna->id_universitas);
                    //Session::set('nama_universitas', $final_ambil_status_pengguna->id_universitas);
                } else if ($final_ambil_status_pengguna->status == 2) {//universitas
                    //ambil id universitas
                    $ambil_id_pengguna = DB::table('universitas')
                        ->select('id')
                        ->where('id_pengguna', '=', $final_ambil_status_pengguna->id)
                        ->get();

                    $final_ambil_id_pengguna = null;
                    foreach ($ambil_id_pengguna as $a) {
                        $final_ambil_id_pengguna = $a;
                    }

                    Session::set('id_pengguna_universitas', $final_ambil_id_pengguna->id);
                } else if ($final_ambil_status_pengguna->status == 1) {

                } else if($final_ambil_status_pengguna->status == 4){//mahasiswa
                    $ambil_id_pengguna = DB::table('pengguna')
                        ->select('id','id_universitas','nama')
                        ->where('email', '=', $_POST['email'])
                        ->get();

                    $final_ambil_id_pengguna = null;
                    foreach ($ambil_id_pengguna as $ambil_id_pengguna) {
                        $final_ambil_id_pengguna = $ambil_id_pengguna;
                    }

                    //ambil id mahasiswa
                    $ambil_id_mahasiswa = DB::table('mahasiswa')
                        ->select('id','id_kelompok')
                        ->where('id_pengguna', '=', $final_ambil_id_pengguna->id)
                        ->get();

                    $final_ambil_id_mahasiswa = null;
                    foreach ($ambil_id_mahasiswa as $ambil_id_mahasiswa) {
                        $final_ambil_id_mahasiswa = $ambil_id_mahasiswa;
                    }

                  

                    Session::set('id_pengguna_mahasiswa', $final_ambil_id_mahasiswa->id);
                    Session::set('id_kelompok_ta', $final_ambil_id_mahasiswa->id_kelompok);
                    Session::set('id_universitas', $final_ambil_id_pengguna->id_universitas);
                    setcookie('cname', $final_ambil_id_pengguna->nama, time() + (86400 * 30), "/");
                    

                }else{

                }
                Auth::attempt(['email' => $_POST['email'], 'password' => $_POST['password']]);

                Session::flash('pesan_berhasil_masuk_sistem', '<b>Email dan sandi tidak cocok</b>.');
                return Redirect::to('dashboard');
            }else{//email dan sandi tidak cocok
                Session::flash('gagal', 'Email dengan sandi tidak cocok');
                return Redirect::to('masuk');
				//return view('layouts.masuk');
            }
        }else{//email tidak terdaftar
            Session::flash('gagal', 'Email tidak terdaftar');
            return Redirect::to('masuk');
			//return view('layouts.masuk');
        }
    }

    public function keluar()
    {
        setcookie('mycookie', '', time() -3600);

        Session::flush();
        Auth::logout();
        

        
        return Redirect::to('/');
               
    }

    public function validasi_email(){
        $ketersediaan = DB::table('pengguna')
                        ->where('email','=',$_POST['email'])
                        ->count();

        if($ketersediaan == 0 && $_POST['email'] !=NULL){
            return "Email dapat digunakan";
        }else if($ketersediaan == 1 && $_POST['email'] !=NULL){
            return "Email tidak dapat digunakan karena sudah dipakai";
        }else if($_POST['email'] ==NULL){
            return "Email kosong";
        }
    }

    public function tambah_oleh_administrator()
    {
        return view('layouts.pengguna.tambah');
    }

    public function proses_tambah_oleh_administrator()
    {
        //pengguna
        $pengguna = new MPengguna();

        $pengguna->email = $_POST['email'];
        $pengguna->password = bcrypt($_POST['password']);
        $pengguna->nama = $_POST['universitas'];
        $pengguna->status = 2;
        $pengguna->save();

        //universitas
        $ambil_id_pengguna = DB::table('pengguna')
            ->select('id')
            ->where('email', '=', $_POST['email'])
            ->get();

        $final_ambil_id_pengguna = null;
        foreach ($ambil_id_pengguna as $a) {
            $final_ambil_id_pengguna = $a;
        }

        $universitas = new MUniversitas();
        $universitas->id_pengguna = $final_ambil_id_pengguna->id;
        $universitas->save();

        return Redirect::to('dashboard');
    }
}