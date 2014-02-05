<?php

    
    // session bilgisi kontrol edilir
    require_once '../_session_kontrol_3.php';
    require_once '_metotlar_3.php';
	require_once ('../../my_class/kullanicilar.php');
    
    function geri_yonlendir($value){
		$url = 'ekle.php?msj='.$value;
		 echo "<script>
                          window.location = '{$url}';
	               </script>";
               exit();
	}
	
	$ad=$_POST['ad'];
	$soyad =$_POST['soyad'];
	$kul_sifre = $_POST['kul_sifre'];
	$kul_ad = $_POST['kul_ad'];
	$yetki = $_POST['yetki'];
	
	if (!($ad && $soyad)) {
		$mesaj = 'Ad ve Soyad girmediniz.... ';
		geri_yonlendir($mesaj);
	}
	if (!($kul_ad && $kul_sifre)) {
		$mesaj = 'Kullanıcı Adı ve Şifre girmediniz.... ';
		geri_yonlendir($mesaj);
	}
	if($yetki == 0){
		$mesaj = 'Kullanıcı Yetkisini seçmediniz.... ';
		geri_yonlendir($mesaj);
	}
  
    $db = new kullanicilar();
	
	$sonuc = $db->kullanici_adi_kontrol($kul_ad);
	if ($sonuc) {
		$mesaj = 'Bu kullanıcı adlı kişi kayıtlı .... ';
		geri_yonlendir($mesaj);
	}
	else {
		$sonuc = $db->ekle(strtoupper($ad),strtoupper($soyad),$kul_ad,md5($kul_sifre),$yetki);
    	if($sonuc > 0){
		  $url = '../kullanici_islem.php?msj=Kullanıcı başarılı bir şekilde eklendi..';
		  echo "<script>
                             window.location = '{$url}';
	                 </script>";
                  exit();
	     }
        	else {
	    	$mesaj = 'Kullanıcı eklenemedi .... ';
		    geri_yonlendir($mesaj);
	     }
    }
		
  
?>