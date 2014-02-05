 <?php
  
  // sesssion kontrol
   require_once '_session_kontrol.php';
   require_once '_metotlar.php'; 
 
   ust_yaz();
?>
    <script>
	   $(function(){
	     	$( "#anasayfa" ).addClass("active");
	   });
    </script>
 
     <div id='containerHolder' >
            <div id='container' style="height: 470px;">
                <div id='sidebar'>
                    <ul class='sideNav'>
                    </ul>
                </div>    
            
                <h2>
                   <a class='active' href='#'>ANA SAYFA</a>
                </h2>
               
                <div id='main'>
                    <form action='' class='jNice'>
                    
                    </form>
                </div>
                
                <div class='clear'></div>
            </div>
        </div>  

<?php
  alt_yaz();
 ?>
   

