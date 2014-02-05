<?php
 
     require '../include/function.php';
     require '../my_class/urun_grup.php';
     
     $grup_pk = $_GET['pk'];
     if (!$grup_pk){
          $mesaj = 'Ürün grubu bilgileri eksik geldi..';
          redirect('../anasayfa.php?page=urun-gruplari&msj='.$mesaj);
     }
     
     $db = new urun_grup();
     $satir_sayisi = $db->sil($grup_pk);
     
     if($satir_sayisi > 0)
         $mesaj = 'Ürün Grubu başarılı bir şekilde silindi..';
     else
         $mesaj = 'Ürün Grubu silinemedi..';
     
     redirect('../anasayfa.php?page=urun-gruplari&msj='.$mesaj);
?>