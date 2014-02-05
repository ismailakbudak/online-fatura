<?php
     ob_start();
     require '../include/function.php';
     require '../my_class/musteri_kod.php';
     
     $kod_pk = $_GET['pk'];

     
     if (!$kod_pk ) {
         $mesaj = 'Gerekli bilgiler gelmediği için işlem yapılamıyor...';
         redirect(' ../anasayfa.php?page=kodlar&msj='.$mesaj);
         exit;
     }
     
     
     $db = new musteri_kod();
    
     $satir_sayisi = $db->sil($kod_pk);
     if ($satir_sayisi > 0) 
         $mesaj = 'Silme işlemi başarılı ..';
     
     else
         $mesaj = 'Silme işlemi başarısız..';
 
     redirect('../anasayfa.php?page=kodlar&msj='.$mesaj);
     exit;

?>