<?php
   
    require_once '../_session_kontrol_3.php';
    require_once '../../my_class/kullanici_sirket.php';

    function geri($mesaj){
        $url = '../kullanici_sirket.php?msj='.$mesaj ;
         echo "<script>
                  window.location = '{$url}';
	      </script>";
        exit();
    }

    $kullanici_sirket_pk = $_GET['pk'];
    if (!$kullanici_sirket_pk) {
        $mesaj = "Müşteri bilgileri eksik....";
        geri($mesaj);
    }
    
    
     $db = new kullanici_sirket();
     $sonuc = $db->sil($kullanici_sirket_pk);
     if ($sonuc) 
         $mesaj = 'Başarılı bir şekilde silindi..';
     
     else 
         $mesaj = 'Ne yazik ki silinemedi.. '; 
     
     geri($mesaj);

?>