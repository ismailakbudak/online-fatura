<?php
 
     require '../include/function.php';
     require '../my_class/urunler.php';
     
     $urun_pk = $_GET['pk'];
     if (!$urun_pk){
          $mesaj = 'Ürün bilgileri eksik geldi..';
          redirect('../anasayfa.php?page=urunler&msj='.$mesaj);
     }
     
     $db = new urunler();
     $satir_sayisi = $db->sil($urun_pk);
     
     if($satir_sayisi > 0)
         $mesaj = 'Ürün başarılı bir şekilde silindi..';
     else
         $mesaj = 'Ürün silinemedi..';
     
     redirect('../anasayfa.php?page=urunler&msj='.$mesaj);
     
?>