<?php
   
    // session bilgisi kontrol edilir
     require_once '../_session_kontrol_3.php';
     require_once '_metotlar_3.php';
     require_once ('../../my_class/kullanicilar.php');
     
    function geri_yonlendir($mesaj){
		$url = '../kullanici_islem.php?msj='.$mesaj;
		 echo "<script>
                          window.location = '{$url}';
	               </script>";
                 exit();
      }
   
	$pk_kul = $_GET['pk'];
	
	if (!$pk_kul) 
		geri_yonlendir("Eksik bilgi geldi ...");
	
    $db = new kullanicilar();
	$sonuc = $db->sil($pk_kul);
    if($sonuc)
        geri_yonlendir('Kullanıcı başarılı bir şekilde silindi...');
     
     else 
		geri_yonlendir('Kullanıcı silinemedi .... ');
     
	


?>