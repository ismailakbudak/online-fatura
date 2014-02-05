<?php
  
  error_reporting(0);
  session_start();
  
  header("Content-Type: text/html; charset = utf-8");
       
   require_once 'my_class/kullanicilar.php';  
  
  // Kullanıcı adı ve sifre post edildi ise kullanıcı girişi kontrol ediliyor
  if($_POST['kulanici_adi'] && $_POST['sifre'] ){
  	
  	if ($_POST['code']) {		  
      $kul_ad =  $_POST['kulanici_adi'];
	  $kul_sifre = md5($_POST['sifre']);
	  $code = $_POST['code'];
	
	if(strcmp($code, $_SESSION['captcha']['code']) == 0){
	    $db = new kullanicilar(); 
	    $sonuc = $db->kisi_sorgula($kul_ad, $kul_sifre, 'Yönetici');
	
	    if ($sonuc ) {
		  $_SESSION['kullanici_session'] = $sonuc['pk'];
		  $url = "index.php";
		  echo "<script>
                          window.location = '{$url}';
	                </script>";
                  exit();
	    }
	    else
	      $msj = "Kullanıcı Adı veya Şifre hatalı yada bu sayfaya erişim izniniz yok..";
	  }
	 else 
		$msj = "Captcha kodunu yanlış girdiniz..";
	}
	else
		$msj = "Captcha kodunu girmelisiniz..";
  }
  else
  	   $msj = "Kullanıcı Adı ve Şifre girmelisiniz..";
  	   
   $url = "giris.php?msj=".$msj;
   echo "<script>
           window.location = '{$url}';
         </script>";
   exit();
	    
?>