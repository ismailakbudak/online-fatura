<?php
     ob_start();
     
     require '../include/function.php';
     require_once '../my_class/musteri_detay.php';    
     require_once '../my_class/adres.php';   
     require_once '../my_class/adres_musteri.php';   
    
     session_start();
     $sirket_fk = $_SESSION['sirket_pk'];
       
   /**
    * Post verileri değişkenlere alınır
    */
    $musteri_kod =$_POST['musteri_kod'];
    $musteri_unvan = $_POST['musteri_unvan'];
    $vergi_dairesi = $_POST['vergi_dairesi'];
    $vergi_no = $_POST['vergi_no'];
    $adres    = $_POST['adres'];
    /**
     * Bilgiler Eksik geldiyse geri yönlendirme yapılır
     */
    if (!$sirket_fk || !$musteri_kod || !$musteri_unvan || !$vergi_dairesi || !$vergi_no || !$adres) {
        $mesaj = 'Bilgileri eksik girdiniz...';
        $url = '../musteri/ekle-form.php?msj='.$mesaj;
        //header('Location: ../musteri/ekle-form.php?msj='.$mesaj);
         echo "<script>
                  window.location = '{$url}';
	      </script>";
	  exit;
    }
       

     $db = new musteri_detay();    
 
      $musteri_pk = $db->ekle($sirket_fk,$musteri_kod,$musteri_unvan,$vergi_dairesi,$vergi_no,"","","");
     
      if ($musteri_pk) {
          
              $db = new adres();
              $adres_pk = $db->ekle($adres,"İlk Adres","");
    
              if ($adres_pk){
                  $db = new adres_musteri();
                  $sonuc = $db->ekle($adres_pk,$musteri_pk);
                
                   if ($sonuc) {
                     $mesaj = 'Müşteri başarılı bir şekilde kayıt edildi..'; 
                   }
                   else {
                       $mesaj = 'Müşteri başarılı bir şekilde kayıt edildi.. Adres kayıdı yapılamadı.. '; 
                   }
               }
              else {
                   $mesaj = 'Müşteri başarılı bir şekilde kayıt edildi.. Adres kayıdı yapılamadı.. ';   
             }
      }
      else 
          $mesaj = 'Müşteri kayıt edilemedi...';
       
      $url= "../musteri/detay.php?pk=".$musteri_pk."&msj=".$mesaj;
    echo "<script>
                  window.location = '{$url}';
         </script>";
     exit;
?>