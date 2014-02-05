<?php
    
    
    // session bilgisi kontrol edilir
    require_once '../_session_kontrol_3.php';
    require_once ('../../my_class/kullanici_sirket.php');
    
    function geri_yonlendir($value){
        $url = 'ekle.php?msj='.$value;
         echo "<script>
                  window.location = '{$url}';
	      </script>";
        exit();
    }
    
    $sirket_fk = $_POST['sirket'];
    $kullanici_fk = $_POST['kullanici'];
    
    if (!($sirket_fk && $kullanici_fk)) {
        $mesaj = 'Şirket veya Kulanıcı seçmediniz.... ';
        geri_yonlendir($mesaj);
    }
    
    $db = new kullanici_sirket();
    
    $sonuc = $db->getir($kullanici_fk, $sirket_fk);
    if ($sonuc) {
              
          if ($d = $sonuc->fetch()) {
             $mesaj = 'Bu kullanıcıya şirket daha önceden eklenmiş..';
          }
          else {  
                $sonuc = $db->ekle($kullanici_fk,$sirket_fk);
                if ($sonuc) {
                   $mesaj = 'Başarılı bir şekilde kullanıcıya şirket eklendi..';
                }
                else {
                   $mesaj = 'Kullanıcıya şirket eklenemedi...';
                 }
         }          
    }
    else 
        $mesaj = 'Bir hata oluştu kontrol yapılamadı bu yüzden kullanıcıya şirket eklenemedi..';
    
    
    geri_yonlendir($mesaj);
    
?>