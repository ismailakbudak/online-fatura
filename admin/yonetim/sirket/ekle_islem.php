<?php


    require_once '../_session_kontrol_3.php';	
    require_once ('../../my_class/sirket_detay.php');
    require_once ('../../my_class/sirket_ayar.php');
     
	function geri_yonlendir($mesaj){
		$url = 'ekle.php?msj='.$mesaj;
		echo "<script>
                        window.location = '{$url}';
	              </script>";
               exit();
	}
   
    $sirket_isim = $_POST['sirket_isim'];
    $vergi_dairesi = $_POST['vergi_dairesi'];
    $vergi_no = $_POST['vergi_no'];
    $eposta = $_POST['eposta'];
    $web = $_POST['web'];
    $aciklama = $_POST['aciklama'];
	
	if (!$sirket_isim || !$vergi_dairesi || !$vergi_no ) 
		 geri_yonlendir('Bilgileri eksik girdiniz...');
	 
	// kullanıcı işlemleri yapan metot
	$db = new sirket_detay();
    $sirket = $db->sirket_getir_by_isim($sirket_isim);
    if ($sirket) 
        geri_yonlendir('Bu şirket ismi kullnılmakta.. Başka bir isim giriniz..');
    
	
	$db->bag->beginTransaction();

	$sonuc = $db->ekle(strtoupper($sirket_isim),strtoupper($vergi_dairesi),$vergi_no,$eposta,$web,$aciklama);
	if ($sonuc) {

	     $sirket_pk = $db->bag->lastInsertId();
		 $kurus_ayar = 2;
         $extra = "";

		 $sonuc = $db->bag->exec("INSERT INTO `sirket_ayar`
        			              ( `sirket_fk`, `kurus_ayar`, `extra`) 
        			               VALUES ( '{$sirket_pk}','{$kurus_ayar}','{$extra}')");
         if($sonuc){
		         
		          $mesaj = 'Şirket başarılı bir şekilde eklendi..';
		          $url = '../sirket_islem.php?msj='.$mesaj;
		          $db->bag->commit();
		          echo "<script>
                                 window.location = '{$url}';
	                     </script>"; 
                  exit();
         }
         else {
             $db->bag->rollback();
	     	 geri_yonlendir('Şirket ayarları eklenemediği için şirkette eklenemedi..');
         }
	}
	else{ 
		 $db->bag->rollback();
		 geri_yonlendir('Şirket eklenemedi..');
	}
	
	
	
?>