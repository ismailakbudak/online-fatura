 <?php
     ob_start();
     require '../include/function.php';
     require '../my_class/musteri_kod.php';
     
     $kod_pk = $_GET['kod_pk'];
     $kod = $_POST['kod'];
     $aciklama = $_POST['aciklama'];
     
     if (!$kod_pk || !$kod || !$aciklama ) {
         $mesaj = 'Gerekli alanlları doldurmadınız...';
         redirect(' ../musteri/kod-ekle-form.php?msj='.$mesaj);
         exit;
     }
     
     
     $db = new musteri_kod();
    
     $satir_sayisi = $db->guncelle($kod_pk,$kod,$aciklama,"");
     if ($satir_sayisi > 0) 
         $mesaj = 'Müşteri kodu başarılı bir şekilde güncellendi ..';
     
     else
         $mesaj = 'Musteri kodu güncellenemedi..';
 
     redirect(' ../anasayfa.php?page=kodlar&msj='.$mesaj);
     exit;
?>