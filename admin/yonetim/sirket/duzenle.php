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
	require_once '../../my_class/sirket_detay.php';
	
	$pk_sirket = $_GET['pk'];
    if (!$pk_sirket) 
         geri_yonlendir('Eksik bilgi geldi...');
     
	
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
           <a class='active' href='#'>Düzenle</a>
        </h2>
<?php	

    $db = new sirket_detay();
    $sirket = $db->sirket_getir($pk_sirket);
	
	/*  Kullanıcı bilgileri gelmez ise geri yönlendirir  */
	if (!$sirket) {
		 $mesaj = "Şirket bilgileri çekilemedi..";
		 geri_yonlendir($mesaj);
	}
	
	echo "
	    <div id='main' style='float:left; margin-left:120px;'>
            <form onsubmit='return kontrol_sirket()' action='duzenle_islem.php?pk={$sirket['pk']}' method='post' class='jNice'> 
	               <h3>Şirket Bilgileri</h3>
	            <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Şirket İsim :</div>
                  <input value='{$sirket['sirket_isim']}' id='ad' type='text'  placeholder='Şirket İsim ' name='sirket_isim' />
                </div>
                
                 <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Vergi Dairesi Adı :</div>
                  <input value='{$sirket['vergi_dairesi']}' id='vergi_dairesi' type='text'  placeholder='Vergi Dairesi Adı ' name='vergi_dairesi' />
                </div>
                 <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Vergi No :</div>
                  <input value='{$sirket['vergi_no']}' id='vergi_no' type='number'  placeholder='Vergi no ' name='vergi_no' />
                </div>
                              
                 <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Şirket Eposta :</div>
                  <input value='{$sirket['eposta']}' id='eposta' type='email'  placeholder='Opsiyonel Şirket Eposta Adresi ' name='eposta' />
                </div>
                
                 <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Şirket Web Adresi:</div>
                  <input value='{$sirket['web']}' id='web' type='text'  placeholder=' Opsiyonel Şirket Web Adresi' name='web' />
                </div>
                
                 <div class='kullanici_ekle_satir' style='height:50px'>
                  <div class='kullanici_ekle_sag' > Açıklama :</div>
                  <textarea id='resizable' name='aciklama' style='height:50px; float:left; width:300px;' rows='5' cols='20'>{$sirket['aciklama']}</textarea>                    
                </div> 
                  
                <div class='kullanici_ekle_satir'>
                        <div class='kullanici_ekle_sag' > &nbsp  </div>
                        <input  class='my_button' type='submit' name='onay' value='Şirketi Güncelle' />
                 </div>            
            </form>
        </div>
      ";
 ?>
	    <div class="clear"></div>
      </div>
   </div>
	 
<?php
   alt_yaz(); 
?>