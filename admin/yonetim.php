<?php
 
  // sesssion kontrol
  require_once '_session_kontrol.php';
  require_once '_metotlar.php'; 
  
  ust_yaz();
?>

    <script>
	   $(function(){
	     	$( "#yonetim" ).addClass("active");
	   });
    </script>

    <div id="containerHolder">
			<div id="container" style="height: 470px;">
        		<div id="sidebar">
                	<ul class="sideNav">
                        <li><a href="yonetim/sirket_islem.php">Şirketler </a></li>
                        <li><a href="yonetim/kullanici_islem.php">Kullanıcılar </a></li>
                        <li><a href="yonetim/kullanici_sirket.php">Kullanıcı Şirketleri</a></li>
                    </ul>
                </div>    
            
                <h2>
                   <a class="active" href="#">YÖNETİM</a>
                </h2>
               
                <div id="main">
                	<form action="" class="jNice">
                    </form>
                </div>
                
                <div class="clear"></div>
            </div>
        </div>	
      
<?php
      alt_yaz();
 ?>
