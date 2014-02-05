<?php

    function geri_yonlendir($mesaj){
          $url = '../sirket_islem.php?msj='.$mesaj;
	      echo "<script>
                  window.location = '{$url}';
	            </script>";
          exit();
	}
     
    require_once '../_session_kontrol_3.php';
    require_once '../kullanici/_metotlar_3.php';
	 
    $pk_sirket = $_GET['pk'];
    if (!$pk_sirket) 
         geri_yonlendir('Eksik bilgi geldi...');
    
	 
	ust_yaz();
	
	 echo " <div class='hatali'></div>  ";
     $mesaj = $_GET['msj'];
     if(isset($mesaj) && strcmp($mesaj, "") != 0){
	        echo "<script> myClick('.hatali','{$mesaj}','UYARI'); </script>";	
     }
?>	 
	  
  <div id="containerHolder">
     <div id="container" style="height: 470px;  background: #fff;">
	    <h2 style='float:left; margin-left:120px;'>
            <a href='../../yonetim.php#'>YÖNETİM</a> 
            &raquo; 
            <a href='../sirket_islem.php'>Şirketler</a>
            &raquo;
           <a class='active' href='#'>Detay</a>
        </h2>
 	    <div id='main' style='float:left; margin-left:120px;'>
            <form action='post' class='jNice'> 
	               <h3>Şirket Bilgileri</h3>
	 
	                Şirket bilgileri detaylı bir şekilde gelecek bu şirkete bakan kullanıcıların bilgileri gelecek..
	
             </form>
          </div>
        <div class="clear"></div>
      </div>
   </div>	 
	
<?php	 
	 alt_yaz();
?>