<?php
     
  
    require_once '../_session_kontrol_3.php';
    require_once '../kullanici/_metotlar_3.php';

    ust_yaz();
	
	 echo " <div class='hatali'></div>  ";
     $mesaj = $_GET['msj'];
     if(isset($mesaj) && strcmp($mesaj, "") != 0){
	        echo "<script> myClick('.hatali','{$mesaj}','UYARI'); </script>";	
	 }
	  echo"  <style>
             .ui-resizable-se {
                 bottom: 17px;
              }
            </style>
            <script>
                $(function () {
                    $('#resizable').resizable({
                     handles: 'se'
                     });
                  });
           </script>
	 ";
	
?>	 
	<div id="containerHolder">
     <div id="container" style="height: 470px;  background: #fff;">
     	 <h2 style='float:left; margin-left:120px;'>
            <a href='../../yonetim.php#'>YÖNETİM</a> 
            &raquo; 
            <a href='../sirket_islem.php'>Şirketler</a>
            &raquo;
           <a class='active' href='#'>Ekle</a>
         </h2>
	     <div id='main' style='float:left; margin-left:120px;'>
            <form onsubmit='return kontrol_sirket()' action='ekle_islem.php' method='post' class='jNice'> 
               <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Şirket İsim :</div>
                  <input id='ad' type='text'  placeholder='Şirket İsim ' name='sirket_isim' />
                </div>
                
				 <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Vergi Dairesi Adı :</div>
                  <input id='vergi_dairesi' type='text'  placeholder='Vergi Dairesi Adı ' name='vergi_dairesi' />
                </div>
                 <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Vergi No :</div>
                  <input id='vergi_no' type='number'  placeholder='Vergi no ' name='vergi_no' />
                </div>
              				  
				 <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Şirket Eposta :</div>
                  <input id='eposta' type='email'  placeholder='Opsiyonel Şirket Eposta Adresi ' name='eposta' />
                </div>
                
                 <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Şirket Web Adresi:</div>
                  <input id='web' type='text'  placeholder=' Opsiyonel Şirket Web Adresi' name='web' />
                </div>
                
				 <div class='kullanici_ekle_satir' style='height:50px'>
                  <div class='kullanici_ekle_sag' > Açıklama :</div>
                  <textarea id='resizable' name='aciklama' style='height:50px; float:left; width:300px;' rows='5' cols='20'></textarea>                    
                </div>
    			<div class='kullanici_ekle_satir'>
                        <div class='kullanici_ekle_sag' > &nbsp  </div>
                        <input  class='my_button' type='submit' name='onay' value='Şirketlere Ekle' />
                 </div>   
	          </form>
            </div>
	        <div class="clear"></div>
      </div>
   </div>
	
	
<?php		  
	 alt_yaz();
?>