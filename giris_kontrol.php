<?php
 
    session_start();
    
    // gerekli dosyalar dahil ediliyor   
    require_once 'my_class/kullanicilar.php';
    require_once 'my_class/kullanici_sirket.php';
  
    // Kullanıcı adı ve sifre post edildi ise kullanıcı girişi kontrol ediliyor
    if($_POST['kulanici_adi'] && $_POST['sifre'] )
    {
    	if ($_POST['code']) 
    	{	  
            $kul_ad =  $_POST['kulanici_adi'];
 	        $kul_sifre = md5($_POST['sifre']);
 	        $code = $_POST['code'];
 	    	 
 	        if(strcmp($code, $_SESSION['captcha']['code']) == 0)
 	        {
 	                    $db = new kullanicilar();
 	                    $kullanici = $db->kisi_sorgula_for_giris($kul_ad, $kul_sifre);  
 	                    if ($kullanici ) {
 	                          $db = new kullanici_sirket();
                                 $kullanici_pk = $kullanici['pk'];  
                                 $sirketler = $db->getir_by_kullanici($kullanici_pk);
     
                               //  kullanıcının baktığı şirket var mı yok mu kontrol ediliyor   
                                if ($sirketler) {
     	    	                      $_SESSION['kullanici_ses'] = $kullanici_pk;
     	    	                      $_SESSION['time'] = time();
     	    	           
     	    	                       $url="index.php";
     	    	                       echo "<script>
                                                window.location = '{$url}';
     	                               </script>";
     	                               exit();
                                  }
                                  else {
                                       $msj = "Herhangi bir şirkete bakmaya yetkiniz yok ..";
                                      $url = 'giris.php?msj='.$msj;
     	    	                        echo "<script>
                                                     window.location = '{$url}';
     	                                   </script>";
     	                                   exit();
                    
                                }   
          	             }
          	            else {
          	                  $msj = "Kullanıcı Adı veya Şifre hatalı ..";
                              $url = 'giris.php?msj='.$msj;
                              echo "<script>
                                         window.location = '{$url}';
          	                  </script>";
          	                  exit();
          	            }
          	}
          	else {
          		$msj = "Captcha kodunu yanlış girdiniz..";
                $url = 'giris.php?msj='.$msj;
                echo "<script>
                       window.location = '{$url}';
             </script>";
          	    exit();
          	}
        }
        else {
        	$msj = "Captcha kodunu girmelisiniz..";
            $url = 'giris.php?msj='.$msj;
            echo "<script>
                     window.location = '{$url}';
                 </script>";
          	      exit();
   	    }  
    }  
    else {  
         $msj = "Kullanıcı Adı ve Şifre girmelisiniz..";
         $url = 'giris.php?msj='.$msj;
         echo "<script>
                    window.location = '{$url}';
 	     </script>";
 	     exit();
   }
 
   
?>
