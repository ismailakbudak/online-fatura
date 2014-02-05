 <?php
     
     error_reporting(0);
     require '../include/function.php';
     require '../my_class/musteri_kod.php';
     
     session_start();
     $sirket_fk = $_SESSION['sirket_pk'];
     $kod = $_POST['kod'];
     $aciklama = $_POST['aciklama'];
     
     if (!$kod || !$aciklama ) {
         $mesaj = 'Gerekli alanlları doldurmadınız...';
         redirect('../musteri/kod-ekle-form.php?msj='.$mesaj);
     }
     
     
     $db = new musteri_kod();
    
     $satir_sayisi = $db->ekle($sirket_fk,$kod,$aciklama,"");
     if ($satir_sayisi > 0) 
         $mesaj = 'Müşteri kodu başarılı bir şekilde eklendi ..';
     
     else
         $mesaj = 'Musteri kodu eklenemedi..';
 
     redirect('../anasayfa.php?page=kodlar&msj='.$mesaj);
     
?>