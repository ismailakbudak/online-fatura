<?php
    require_once '../include/function.php';
    require_once '../my_class/telefon.php';
    
   /**
    *  gerekli veriler gelmiş mi kontrol ediliyor
    */
   $tel_pk = $_GET['pk'];
   $tel = $_POST['tel'];
   $faks = $_POST['faks'];
   $musteri_pk = '';
   if ( !$tel_pk ) {
       $mesaj = 'Gerekli bilgiler gelmediği için işlem yapılamıyor...';
       redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
   }
   
    $db=new telefon();
     $sonuc = $db->getir_2($tel_pk);   
     if ($sonuc) {
         $musteri_pk = $sonuc['musteri_fk'];
         $adres_pk = $sonuc['adres_fk'];
     }
     
     if (!$tel) {
         $mesaj = 'Telefon numarası girmediniz..';
         redirect('../musteri/adres-guncelle-form.php?musteri_pk='.$musteri_pk.'&adres_pk= '.$adres_pk .'&msj='.$mesaj);
     }
    
 
     
     $sonuc = $db->guncelle($tel_pk,$tel,$faks);
     if ($sonuc > 0) 
         $mesaj = 'Telefon başarılı bir şekilde güncellendi..';
     
     else 
         $mesaj = 'Telefon güncellenemedi..';
     

     redirect('../musteri/adres-guncelle-form.php?musteri_pk='.$musteri_pk.'&adres_pk= '.$adres_pk .'&msj='.$mesaj);
   
?>