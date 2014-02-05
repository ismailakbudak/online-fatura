<?php 

     require_once '../include/function.php';
     require_once '../my_class/adres_musteri.php';
     require_once '../my_class/adres.php';
     require_once '../my_class/telefon.php';    
     
  $adres_pk = $_POST['adresler'];
  $musteri_pk = $_GET['pk'];
  
  if (!$adres_pk){
       $mesaj = 'Eksik bilgi geldiği için işlem yapılamıyor..'; 
      redirect('adres-sil-form.php?musteri_pk='.$musteri_pk .'&msj='.$mesaj);
  }
  
   $db = new adres();
   $db->sil($adres_pk);
   
   $db = new telefon();
   $db->sil($adres_pk);
   
   $db = new adres_musteri();
   $sonuc = $db->sil($adres_pk);
   
   if ($sonuc > 0) 
       $mesaj = 'Adres başarılı bir şekilde silindi..';
   
   else 
       $mesaj = 'Adres silinemedi..'; 
   
  redirect('adres-sil-form.php?musteri_pk='.$musteri_pk .'&msj='.$mesaj);
 
?>