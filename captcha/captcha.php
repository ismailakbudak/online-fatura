<?php
  
  session_start();
  $sonuc = include_once "create_captcha.php";
        if ($sonuc) {
           // captcha session'nına değerler atanıyor
           $_SESSION['captcha'] = captcha();
           if ($_SESSION['captcha']) {
                 echo '<img style="width:90px; height:40px;  margin:5px;
                             margin-right:10px; float:right;  " 
                             src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" />';
           
		     //print_r($_SESSION['captcha']); 
		   }
		    else {
			     $mesaj = "Captcha yüklenirken sorun çıktı ...";
		         echo "<script> myClick('.my','{$mesaj}','UYARI'); </script>";	
           }
         }
		else {
			$mesaj = "Captcha yüklenirken sorun çıktı ...";
			echo "<script> myClick('.my','{$mesaj}','UYARI'); </script>";	
		}
?>