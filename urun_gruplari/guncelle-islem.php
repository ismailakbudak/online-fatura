<?php
 
     require '../include/function.php';
     require '../my_class/urun_grup.php';
     
     $grup_pk = $_GET['pk'];
     $grup_ismi = $_POST['grup_ismi'];
     if (!$grup_pk || !$grup_ismi){
          $mesaj = 'Ürün grubu bilgileri eksik geldi..';
          redirect('../anasayfa.php?page=urun-gruplari&msj='.$mesaj);
     }
     
     $db = new urun_grup();
     $satir_sayisi = $db->guncelle($grup_pk,$grup_ismi);
     
     if($satir_sayisi > 0)
         $mesaj = 'Ürün Grubu başarılı bir şekilde güncellendi..';
     else
         $mesaj = 'Ürün Grubu güncellenemedi..';
     
     redirect('../anasayfa.php?page=urun-gruplari&msj='.$mesaj);
?>