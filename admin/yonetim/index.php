<?php
  
 
   require_once '_session_kontrol_2.php';
  
    $url = '../anasayfa.php';
    echo "<script>
                  window.location = '{$url}';
	      </script>";
	exit();
   
?>