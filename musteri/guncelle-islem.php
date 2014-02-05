<?php 
     
     session_start();
     require '../include/function.php';
     require '../my_class/musteri_detay.php';


   /**
    * Post verileri değişkenlere alınır
    */
    session_start();
    $sirket_fk = $_SESSION['sirket_pk'];
    $musteri_pk = $_GET['pk'];
    $musteri_kod =$_POST['musteri_kod'];
    $musteri_unvan = $_POST['musteri_unvan'];
    $vergi_dairesi = $_POST['vergi_dairesi'];
    $vergi_no = $_POST['vergi_no'];
    $eposta = $_POST['eposta'];
    $web = $_POST['web'];
    $aciklama = $_POST['aciklama'];
    
    if (!$musteri_pk) {
        $mesaj = 'Eksik bilgi var..';
        redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
    } 
        
    if ( !$musteri_kod || !$musteri_unvan || !$vergi_dairesi || !$vergi_no || !$sirket_fk ){ 
        $mesaj = 'Bilgileri eksik girdiniz...';
        redirect('../musteri/guncelle-form.php?pk='.$musteri_pk.'&msj='.$mesaj);
    }
    
    
     $db = new musteri_detay();
     
     
     $satir_sayisi = $db->guncelle($musteri_pk, $sirket_fk, $musteri_kod, $musteri_unvan, $vergi_dairesi, $vergi_no, $eposta, $web, $aciklama);
     if ($satir_sayisi > 0) 
         $mesaj = 'Müşteri başarılı bir şekilde güncellendi..';
     
     else 
          $mesaj = 'Müşteri güncellenemedi..';
     
     redirect('../musteri/guncelle-form.php?pk='.$musteri_pk.'&msj='.$mesaj);
     
?>