<?php

     session_start();
     // Session var mı yok mu kontrol ediliyor
     if(!isset($_SESSION['kullanici_ses'])){
         header('Location:../giris.php');
         exit();
      }
     elseif (!isset($_SESSION['sirket_pk'])) {
          header('Location:../sirket_secimi.php');
         exit();
     }
     else {
         header('Location:../anasayfa.php');
         exit();
     }

?>