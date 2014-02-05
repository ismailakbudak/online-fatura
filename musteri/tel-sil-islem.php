<?php
     require_once '../include/function.php';
     require_once '../my_class/adres_musteri.php';
     require_once '../my_class/adres.php';
     require_once '../my_class/telefon.php';    
     
  $tel = $_POST['tel'];
  $musteri_pk = $_GET['pk'];
  
  if (!$tel){
      $mesaj = 'Eksik bilgi geldiği için işlem yapılamıyor..'; 
      redirect('adres-sil-form.php?musteri_pk='.$musteri_pk .'&msj='.$mesaj);
   }
  
   $db = new telefon();
   
   $sonuc = $db->getir_2($tel[0]);
   $adres_pk = "";
   if ($sonuc) {
       $adres_pk = $sonuc['adres_fk'];
   }
   
   $sonuc = 0;
   for ($i=0; $i < count($tel); $i++) { 
         $sonuc += $db->sil_by_id($tel[$i]); 
   }
   
   if ($sonuc == count($tel) ) 
       $mesaj = 'Telefon başarılı bir şekilde silindi..';
   
   else if($sonuc > 0) 
       $mesaj = 'Telefonların hepsi silinemedi..';
   
   else 
       $mesaj = 'Telefon silinemedi..'; 
   
   redirect('adres-sil-form.php?musteri_pk='.$musteri_pk .'&adres_pk='.$adres_pk .'&msj='.$mesaj);
 
?>