<?php
	
	 require_once '../_session_kontrol_3.php';
     require_once '_metotlar_3.php';
     require_once '../../my_class/kullanicilar.php';
     
	function geri_yonlendir($mesaj,$kul_pk){
		$url= 'duzenle.php?pk='.$kul_pk .'&msj='.$mesaj ;
		 echo "<script>
                          window.location = '{$url}';
	               </script>";
                exit();
	}
	
	$kul_pk = $_GET['pk'];
	if (!$kul_pk) {
		$mesaj = 'Kullanıcı bilgileri eksik geldi..';
		geri_yonlendir($mesaj, $kul_pk);
	}
    
	$ad=$_POST['ad'];
    $soyad =$_POST['soyad'];
    $kul_sifre = $_POST['kul_sifre'];
    $kul_ad = $_POST['kul_ad'];
    $yetki = $_POST['yetki'];
    
    if (!($ad && $soyad)) {
        $mesaj = 'Ad ve Soyad girmediniz.... ';
        geri_yonlendir($mesaj,$kul_pk);
    }
    if (!($kul_ad && $kul_sifre)) {
        $mesaj = 'Kullanıcı Adı ve Şifre girmediniz.... ';
        geri_yonlendir($mesaj,$kul_pk);
    }
    if($yetki == 0){
        $mesaj = 'Kullanıcı Yetkisini seçmediniz.... ';
        geri_yonlendir($mesaj,$kul_pk);
    }

    
     $db = new kullanicilar();
    $sonuc = $db->kullanici_adi_kontrol($kul_ad);
    if ($sonuc && $sonuc['pk'] != $kul_pk) {
        $mesaj = 'Bu kullanıcı adlı kişi kayıtlı .... ';
        geri_yonlendir($mesaj,$kul_pk);
    }

    $sonuc = $db->guncelle($kul_pk,strtoupper($ad),strtoupper($soyad),$kul_ad, md5($kul_sifre), $yetki);
    
    if($sonuc > 0)
        $mesaj = 'Kullanıcı başarılı bir şekilde güncellendi..';
    
    else 
            $mesaj = 'Kullanıcı güncellenemedi .... ';
    
    geri_yonlendir($mesaj, $kul_pk);

?>