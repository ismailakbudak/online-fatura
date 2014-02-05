<?php
 
  error_reporting(E_ALL);
 
  // kullanılan hata fonksiyonu sayfayı hata sayfasına yönlendirir
    function hata_var($value=1){
       $url ="error_404.php?msj=".$value;
      echo "<script>
                  window.location = '{$url}';
	      </script>";
      exit();
    }

  // sesssion kontrol
  $sonuc = include_once '_session_kontrol.php';
  $sonuc2 = include_once '_metotlar.php'; 
  if (!$sonuc || !$sonuc2) 
       hata_var();
  
  ust_yaz();
  
   echo "   <div id='containerHolder'>
            <div id='container'>
                <div id='main'>
                    <form action='' class='jNice'>
                     
                     <h3>
         ";   
   // Hata mesajlarının numarasına göre hatalar yazılır
  if ($_GET['msj'] == 1) {
     echo "Gerekli dosyalar include edilemedi... ):";
   }
  else if ($_GET['msj'] == 2) {
     echo "Veritabanında bir sorun var... ):";
   }
    else if ($_GET['msj'] == 3) {
     echo "Veritabanı sınıflarında bir sorun var... ):";
   }
   else {
       echo $_GET['msj'];
   }
                  
    echo "           </h3> 
                   </form>
                </div>
                <br />
                <br /> 
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <div class='clear'></div>
            </div>
        </div>  
        ";
 
   alt_yaz();
   
?>