<?php
       error_reporting(0);
       require_once '../my_class/urunler.php';
       session_start();
    
       $urun_kodu = $_GET['urun_kodu'];
       if ($urun_kodu) {
            
       $sirket_pk = $_SESSION['sirket_pk'];
       if ($sirket_pk) {
          $db = new urunler();
          $urun = $db->urun_getir_urunkodu($urun_kodu);
      
          if ($urun) {
            echo  $urun['kdv_orani']; 
          }
          else {
            echo "-1";            
          }
         }
         else {
            echo "-1";            
         }      
       }
       else {
           echo "-1";
       }

?>