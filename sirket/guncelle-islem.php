<?php

     require '../include/function.php';
     require '../my_class/sirket_detay.php';
     
     // Bilgiler gelmiş mi diye kontrol ediliyor
       $pk_sirket = $_GET['pk'];
  
      if (!$pk_sirket) {
          $mesaj = 'Şirket bilgileri eksik geldi..';
          redirect('../sirket/guncelle-form.php?msj='.$mesaj);
      }
     
      // Post verileri değişkenlere alınır
      $sirket_isim = $_POST['sirket_isim'];
      $vergi_dairesi = $_POST['vergi_dairesi'];
      $vergi_no = $_POST['vergi_no'];
      $eposta = $_POST['eposta'];
      $web = $_POST['web'];
      $aciklama = $_POST['aciklama'];
      
      if (!$sirket_isim || !$vergi_dairesi || !$vergi_no ) {
           $mesaj = 'Bilgileri eksik girdiniz...';
           redirect('../sirket/guncelle-form.php?msj='.$mesaj);
      }
      
      $db = new sirket_detay();
      
      // şirket ismi kontrol ediliyor  
      $sonuc = $db->sirket_getir_by_isim($sirket_isim);
          
      if ($sonuc && $sonuc['pk'] != $pk_sirket) {
          $mesaj= 'Bu şirket ismi kullnılmakta.. Başka bir isim giriniz..';
          redirect('../sirket/guncelle-form.php?msj='.$mesaj);
      }
      
      $sonuc = $db->guncelle($pk_sirket, strtoupper($sirket_isim),$vergi_dairesi,$vergi_no,$web,$eposta,$aciklama);
      if ($sonuc > 0) 
          $mesaj = 'Şirket başarılı bir şekilde güncellendi..';
      
      else 
          $mesaj='Şirket güncellenemedi...';
      
      redirect('../sirket/guncelle-form.php?msj='.$mesaj);
  
  ?>