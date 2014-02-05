 <?php
     
     error_reporting(0);
     session_start();
     require '../include/function.php';
     require '../my_class/urun_grup.php';
  
     $urun_ismi = $_POST['grup_ismi'];
     $sirket_pk = $_SESSION['sirket_pk'];
       
     if (!$urun_ismi  || !$sirket_pk) {
         $mesaj = 'Gerekli alanlları doldurmadınız...';
         redirect('../urun_gruplari/ekle-form.php?msj='.$mesaj);
     }
     
     $db = new urun_grup();
     $satir_sayisi = $db->ekle($sirket_pk,strtoupper($urun_ismi));
     
     if ($satir_sayisi > 0) 
         $mesaj = 'Ürün Grubu başarılı bir şekilde eklendi ..';
     
     else
         $mesaj = 'Ürün Grubu eklenemedi..';
 
     redirect('../anasayfa.php?page=urun-gruplari&msj='.$mesaj);
     
?>