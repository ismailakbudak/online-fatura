<?php

    // session bilgisi kontrol edilir
    require_once '../_session_kontrol_3.php';
    require_once ('../../my_class/kullanici_sirket.php');

    function geri_yonlendir($mesaj,$pk){
        $url= 'duzenle.php?msj='.$mesaj . '&pk='.$pk;
         echo "<script>
                  window.location = '{$url}';
	      </script>";
        exit();
    }
    
    $pk = $_GET['pk'];
    $sirket_fk = $_POST['sirket'];
    $kullanici_fk = $_POST['kullanici'];

    if (!$pk) 
        geri_yonlendir("","");
    
    
    if (!($sirket_fk || !$kullanici_fk)) {
        $mesaj = 'Şirket veya Kulanıcı seçmediniz.... ';
        geri_yonlendir($mesaj , $pk);
    }
    
    $db = new kullanici_sirket();
    $sonuc = $db->getir($kullanici_fk, $sirket_fk);
    if ($sonuc) {
              
          if ($d = $sonuc->fetch()) {
             $mesaj = 'Bu kullanıcıya şirket daha önceden eklenmiş..';
          }
          else {  
                  $sayi = 0;
                  $sonuc = $db->guncelle('kullanici_fk', $kullanici_fk, $pk);
                  if ($sonuc) {
                    $sayi++;
                   }
                  $sonuc = $db->guncelle('sirket_fk', $sirket_fk, $pk);
                  if ($sonuc) {
                     $sayi++;
                  }
                  if ($sayi > 0) {
                     $mesaj = 'Başarılı bir şekilde güncellendi..';
                  }
                  else {
                     $mesaj = 'Ne yazık ki güncellenemedi..';
                  }
          }
    } 
    else 
        $mesaj = 'Bir hata oluştu kontrol yapılamadı bu yüzden bilgiler güncellenemedi..';
    
    geri_yonlendir($mesaj, $pk);

?>