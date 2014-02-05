<?php 


    require_once '../_session_kontrol_3.php';
    require_once ('../../my_class/sirket_detay.php');
     
    function geri_yonlendir($mesaj){
	   $url= '../sirket_islem.php?msj='.$mesaj;
	   echo "<script>
                  window.location = '{$url}';
	      </script>";
           exit();
	}
    
    $pk_sirket = $_GET['pk'];
    if (!$pk_sirket) 
         geri_yonlendir('Eksik bilgi geldi...');
     
	$db = new sirket_detay();
	$sonuc = $db->sil($pk_sirket);
    
    if($sonuc )
        geri_yonlendir('Şirket başarılı bir şekilde silindi...' );
     
    else 
		geri_yonlendir('Şirket silinemedi .... ');
    
  
?>