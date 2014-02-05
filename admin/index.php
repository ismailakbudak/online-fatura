<?php
     error_reporting(0);
     // ob_start();
     session_start();
     
	 // Session var mı yok mu kontrol ediliyor
      if(isset($_SESSION['kullanici_session'])){
	     
          require_once 'anasayfa.php'; 
       } 
     else{
        $url = 'giris.php';
        echo "<script>
                 window.location = '{$url}';
               </script>";
        exit();
	    
      }
  ?>
