<?php
    require_once '../include/function.php';
    require_once '../my_class/adres.php';
    
   /**
    *  gerekli veriler gelmiş mi kontrol ediliyor
    */
    
   $adres_pk = $_GET['pk'];
   $adres  =$_POST['adres'];
   $aciklama=$_POST['aciklama'];
   $musteri_pk = '';
 
   if ( !$adres_pk) {
       $mesaj = 'Gerekli bilgiler gelmediği için işlem yapılamıyor...';
       redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
   }
   
    $db=new adres();
    $sonuc = $db->adres_getir2($adres_pk);   
     if ($sonuc) {
         $musteri_pk = $sonuc['musteri_fk'];
     }
    
    if (!$adres) {
        $mesaj = 'Adres girmediniz..';
        redirect('../musteri/adres-guncelle-form.php?musteri_pk='.$musteri_pk.'&adres_pk= '.$adres_pk .'&msj='.$mesaj);
    } 
     
     
     $sonuc = $db->guncelle($adres_pk,$adres,$aciklama );
     if ($sonuc > 0) 
         $mesaj = 'Adres başarılı bir şekilde güncellendi..';
     
     else 
         $mesaj = 'Adres güncellenemedi..';
     

    redirect('../musteri/adres-guncelle-form.php?musteri_pk='.$musteri_pk.'&adres_pk= '.$adres_pk .'&msj='.$mesaj);
 ?>