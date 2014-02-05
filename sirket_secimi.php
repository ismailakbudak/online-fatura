<?php

     error_reporting(0);
     session_start();
     require_once 'include/function.php';
     
     // Session var mı yok mu kontrol ediliyor
     if(!isset($_SESSION['kullanici_ses'])){
         $url= 'giris.php';
         echo "<script>
                         window.location = '{$url}';
	           </script>";
         exit();
      }
     
     
     $sirket_pk = $_POST['sirket'];
     if (!$sirket_pk) 
         redirect('index.php'); 
     
     $_SESSION['sirket_pk'] = $sirket_pk;
     $url= 'anasayfa.php';
     echo "<script>
                 window.location = '{$url}';
	       </script>";
     exit();
      
?>