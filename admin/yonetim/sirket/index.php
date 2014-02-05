<?php
   
       // session bilgisi kontrol edilir
       require_once '../_session_kontrol_3.php';
       
       $url = '../../anasayfa.php';
       echo "<script>
                  window.location = '{$url}';
	      </script>";
       exit();
?>