<html>
  <head>
     <meta Content-Type:"text/html"; charset="utf-8" />
    <title>Yönetici Paneli</title>    
    <!--   CSS  -->
     <link href="../style/css/login.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="../style/css/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" media="screen" />
     
     <!--   JScript  -->
    <script type="text/javascript" src="../style/js/jquery.js"></script>
    <script type="text/javascript" src="../style/js/jNice.js"></script>
    <script type="text/javascript" src="../style/js/JScript_My.js"></script>  
    <script type="text/javascript" src="../style/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="../style/js/jquery-ui.js"></script>
    
    
    <!--- Örnek bir ajax kodu captcha yenilemesinde kullanılıyor---->
    <script>
      function clickMy(){
      	
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
           xmlhttp=new XMLHttpRequest();
        }
        else{// code for IE6, IE5
           xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
   
        xmlhttp.onreadystatechange = function(){
        
           if (xmlhttp.readyState==4 && xmlhttp.status==200){
             document.getElementById("change").innerHTML=xmlhttp.responseText;
           }
         }
        
        xmlhttp.open("GET","../captcha/captcha.php",true);
        xmlhttp.send();
      } 
    </script> 
  </head>
  <body>
    <div class="my"></div> 
    
    <?php
       // captcha için session başlatıldı
        error_reporting(0);
        session_start();
		
        header("Content-Type: text/html; charset = utf-8");
       
       // captcha üreten dosya
       $sonuc = include_once "../captcha/create_captcha.php";
        if ($sonuc) {
               // captcha session'nına değerler atanıyor
               $_SESSION['captcha'] = captcha();
               // print_r($_SESSION['captcha']);
         }
		else {
			$mesaj = "Captcha yüklenirken sorun çıktı ...";
			echo "<script> my('.my','{$mesaj}','UYARI'); </script>";	
		}
		
  	    $mesaj = $_GET['msj'];
        if(isset($mesaj)){
	        echo "<script> my('.my','{$mesaj}','UYARI'); </script>";	
	    }
	
        $cikis = $_GET['cikis'];
	    if(isset($cikis)){
	    	 echo "<script> my('.my','{$cikis}','Çıkış'); </script>";
	    }
    ?>
         
   <div class="wrap">
	 <div id="content">
		<div id="main">
			<div class="full_w">
			    <div style="padding-left: 15px;  text-align: center;  padding-top: 15px; color: #C66653"> Yönetici Panel Girişi </div>
			    <div class="sep"></div> 
				<form id="form1" method="post" action="giris_kontrol.php" >
				    <div class="yazi" > Kullanıcı adı:</div> 
					<div class="my_over"> <input name="kulanici_adi" style="width: 358px; height: 30px" type="text"/> </div>					 
      
                    <div class="yazi" > Şifre: </div>
                    <div class="my_over"> <input name="sifre" style="width: 358px; height: 30px;" type="password"/></div>
                    
                    <div class="sep"></div>
                    
                    <div style="padding: 0px; text-align: center" >
                       <div id="change">
                       <?php
                          if ($_SESSION['captcha']) {
                            echo '<img style="width:90px; height:40px;  margin:5px; margin-right:10px; float:right;  " src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" />';
					       }
					      else {
						 	$mesaj = "Captcha yüklenirken sorun çıktı ...";
		                	echo "<script> myClick('.my','{$mesaj}','UYARI'); </script>";	
						  }
                        ?>
                        </div>
                        <input name="captcha_yenile" class="button" type="button" value=" Yenile " type="submit"  
                                style=" margin:6px; font-size:14px; width: 80px; height: 34px; float:right; "
                                 onclick=" clickMy()"  > </input>

                        &nbsp;
                        &nbsp;
                        <br />
                    </div> 
                    &nbsp;
                    <div class="yazi" > Captcha Kodu: </div>
                    <div class="my_over"> <input name="code" style="width: 358px; height: 30px;" type="text"/></div>
                   
                     <div class="sep"></div>
                     
                     <input class="button" style="font-size:20px;" type="submit"  value=" Giriş "> 
                     &nbsp;
                     &nbsp;
                    <br />
                    &nbsp;
                </form>
			</div>
			<div class="footer">
				<span >» Fatura Projesi</span>
            </div>
		</div>
	</div>
  </div>
   
 </body>
</html>


