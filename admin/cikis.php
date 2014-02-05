<?php 

  session_start();

  // sessiona atanan değeri siler
  unset($_SESSION['kullanici_session']);

  // session yok eder
  session_destroy();

   // giris sayfasına mesaj ile yönlendirir
   $cikis = "Başarılı bir şekilde çıkış yaptınız..";
   $url= "giris.php?cikis=".$cikis;
   echo "<script>
                  window.location = '{$url}';
        </script>";
   exit();

?>