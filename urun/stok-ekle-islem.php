 <?php

     error_reporting(0);
     session_start();
     require '../include/function.php';
     require '../my_class/stok.php';
     
     $sirket_pk = $_SESSION['sirket_pk']; 
     $kullanici_pk = $_SESSION['kullanici_ses'];;
     
     $urun_fk = $_POST['urun_fk'];
     $musteri_fk = $_POST['musteri_fk'];     
     $urun_adet = $_POST['urun_adet'];
     $adet_birim = $_POST['adet_birim'];     
     $birim_fiyat = $_POST['birim_fiyat'];
     
     $indirim = $_POST['indirim'];
     $islem = 1;    
     $tarih = date("Y-m-d"); // Geçerli sistem tarihini almak için 
     
     if (!$sirket_pk || !$kullanici_pk || !$urun_fk || !$musteri_fk || !$urun_adet || !$adet_birim || !$birim_fiyat ) {
         $mesaj = 'Gerekli alanlları doldurmadınız...';
         redirect('../urun/stok-ekle-form.php?msj='.$mesaj);
     }
     
     $db = new stok();
     $satir_sayisi = $db->ekle($sirket_pk, $urun_fk, $kullanici_pk, $musteri_fk, $urun_adet,strtoupper( $adet_birim), $birim_fiyat, $indirim, $islem,$tarih);
     
     if ($satir_sayisi > 0) 
           $mesaj = "Ekleme işlemi başarılı..";    
     else 
         $mesaj = "Ekleme işlemi başarısız..";
     
      redirect('../urun/stok-ekle-form.php?msj='.$mesaj);
     
 ?>