
<?php

    error_reporting(0);
    session_start();
    require_once 'include/function.php'; 
      
     // Session var mı yok mu kontrol ediliyor
	 if(!isset($_SESSION['kullanici_ses'])){
            $url = 'giris.php?msj=Giriş yapınız..';
            echo "<script>
                      window.location = '{$url}';
	              </script>";
	        exit();
      }
     
     if ( !isset($_SESSION['sirket_pk']) ) {
          $url= 'index.php?msj=Şirket seçmelisiniz.';
          echo "<script>
                         window.location = '{$url}';
	            </script>";
	      exit();
     }

     //Oturum süresi için gerekli 
     /*
     if ( $_SESSION['time'] < time() - (10 * 60 )) {
        $url= 'giris.php?msj=Uzun süre işlem yapmadığınız için oturum kapatıldı. Tekrar giriş yapınız.';
          echo "<script>
                         window.location = '{$url}';
	            </script>";
         	exit();
     }
     */
     
     $_SESSION['time'] = time();
     $time =  $_SESSION['time'];
     $sirket_pk = $_SESSION['sirket_pk']; 
     $kullanici_pk = $_SESSION['kullanici_ses'];

?>