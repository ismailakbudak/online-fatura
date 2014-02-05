<?php
 
    // session bilgisi kontrol edilir
    require_once '../_session_kontrol_3.php';
    require_once '_metotlar_3.php';
	require_once ('../../my_class/kullanicilar.php');
   
    function geri_yonlendir($mesaj){
		$url = '../kullanici_islem.php?msj='.$mesaj;
		 echo "<script>
                            window.location = '{$url}';
	               </script>";
                 exit();
	}
	
   
    $pk_kul = $_GET['pk'];
	if (!$pk_kul) {
		$mesaj = "Eksik bilgi geldi ...";
		geri_yonlendir($mesaj);
	}
	
	
   	ust_yaz();
     echo " <div class='hatali'></div>  ";
     $mesaj = $_GET['msj'];
     if(isset($mesaj)){
	        echo "<script> myClick('.hatali','{$mesaj}','UYARI'); </script>";	
	    }
?>

    <div  id="containerHolder">
       <div id="container" style="height: 480px; background: #fff">        
         <h2 style="float:left; margin-left:120px;">
            <a href="../../yonetim.php#">YÖNETİM</a> 
            &raquo; 
            <a href="../kullanici_islem.php">Kullanıcılar</a>
            &raquo;
           <a class="active" href="#">Detay</a>
        </h2>
	    <div id="main" style="float:left; margin-left:120px;">
            <form action="post" class="jNice">
            <h3>Kullanıcı Bilgileri</h3>
    
<?php   
	echo "Kullanıcının baktığı şirketlerde gelecek";
	echo "kullanıcı bilgileri gelecek";
	
	$db = new kullanicilar();
    $row = $db->kullanici_getir($pk_kul);
	
	if ($row) {
	    echo	$row['ad'] . $row['soyad'];
	}
	else {
		echo "gelmesi";
	}
?>
          </form>
        </div>
       <div class="clear"></div>
     </div
    </div>
<?php
       alt_yaz();	
?>