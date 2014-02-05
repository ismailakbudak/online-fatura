<?php 

     session_start();
     
     // sessiona atanan değeri siler
     unset($_SESSION['kullanici_ses']);
     unset($_SESSION['sirket_pk']);
     
     // session yok eder
     session_destroy();
     
     // giris sayfasına mesaj ile yönlendirir
     $mesaj = "Başarılı bir şekilde çıkış yaptınız..";
     $url = "giris.php?cikis=".$mesaj;
     echo "<script>
                window.location = '{$url}';
     	  </script>";
     exit();

?>