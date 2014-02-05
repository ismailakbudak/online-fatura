<?php

	require_once  '../_session_kontrol_3.php';
    require_once '_metotlar_3.php';
	require_once '../../my_class/kullanicilar.php';
	require_once '../../my_class/kullanici_yetki.php';
	
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
   
     ust_yaz(); // html in üst tarafını yazar _metototlar_3.php den gelir 
	   
	  echo " <div class='hatali'></div>  ";
      $mesaj = $_GET['msj'];
      if(isset($mesaj) && strcmp($mesaj, "") != 0){
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
              <a class="active" href="#">Düzenle</a>
          </h2> 
<?php  
    $db = new kullanicilar();
    $kullanici = $db->kullanici_getir($pk_kul);
	
	/*  Kullanıcı bilgileri gelmez ise geri yönlendirir  */
	if (!$kullanici) {
		 $mesaj = "Kullanıcı bilgileri çekilemedi..";
		 geri_yonlendir($mesaj);
	}
 
   /*
    *  Ana menüyü doldurur
    */
     echo "
	    <div id='main' style='float:left; margin-left:120px;'>
            <form onsubmit='return kontrol()' action='islem_duzenle.php?pk={$kullanici['pk']}' method='post' class='jNice'> 
              <fieldeset>
	               <h3>Kullanıcı Bilgileri</h3>
                  
                     <div class='kullanici_ekle_satir'>
                       <div class='kullanici_ekle_sag' > Kullanıcı Adı :</div>
                       <input value='{$kullanici['kullanici_adi']}' id='kul_ad' type='text'  placeholder='Kullanıcı Adı ' name='kul_ad' />
                    </div>

                     <div class='kullanici_ekle_satir'>
                       <div class='kullanici_ekle_sag' > Şifre :</div>
                       <input value='{$kullanici['kullanici_sifre']}' id='kul_sifre' type='password' placeholder='Şifre'  name='kul_sifre' />
                    </div>

                    <div class='kullanici_ekle_satir'>
                       <div class='kullanici_ekle_sag' > Ad :</div>
                       <input value='{$kullanici['ad']}' id = 'ad' type='text' placeholder='Ad' name='ad' />
                    </div>

                     <div class='kullanici_ekle_satir'>
                       <div class='kullanici_ekle_sag' > Soyad :</div>
                       <input value='{$kullanici['soyad']}' id='soyad' type='text' placeholder='Soyad' name='soyad' />
                    </div>
                    
                     <div class='my' style='margin-top:5px;' >
                           <div class='kullanici_ekle_sag' > Yetkisi :</div>
                           <div class='myy'>
                             <select name='yetki' id='yetki'  >
                              <option value='0'>Yetki Seçiniz</option>
    ";

   // select taglarine veritabanından kullanici_yetki tablosu içindeki verileri çekip yazdırır
   $db = new kullanici_yetki();
   $sonuc = $db->listele();
   
   // tablodan veri gelmiiş mi gelmemiş mi kontrol edilir
   if($sonuc){
    foreach($sonuc as $row) {
         if ($kullanici['yetkisi'] == $row['yetkisi'] ) {
             echo " <option selected value='{$row['pk']}'>{$row['yetkisi']}</option> ";
         }else{
             echo " <option value='{$row['pk']}'>{$row['yetkisi']}</option> ";
         }
     }
    }
 ?>                   
                             </select>
                         </div>
                    </div>
                    <div class='kullanici_ekle_satir' style='height:35px;'>
                        <div class='kullanici_ekle_sag' > &nbsp  </div>
                        <input  class='my_button' type='submit' name='onay' value='Güncelle' />
                    </div>
                 </fieldeset>    
            </form>
        </div>
         <div class='clear'></div> 
       </div>
   </div>   
<?php  
      alt_yaz();
?>