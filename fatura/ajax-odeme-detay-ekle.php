<?php 
    require '../my_class/odeme_detay.php';
    $odeme_tur = $_GET['data'];
    if ($odeme_tur) {
        
        $db = new odeme_detay();
        $satir = $db->ekle($odeme_tur);    
         if($satir>0){
            echo "1";
         }
         else {
             echo "0";
         }
    }else{
          echo 0;
     }
?>