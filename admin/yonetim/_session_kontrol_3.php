<?php

      error_reporting(0);
      session_start();
	
	// Session var mı yok mu kontrol ediliyor
	 if(!isset($_SESSION['kullanici_session'])){
         $url = '../../giris.php';
          echo "<script>
                  window.location = '{$url}';
	      </script>";
	     exit();
      }
?>