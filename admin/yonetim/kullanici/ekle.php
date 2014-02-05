<?php
   
    
    require_once '../_session_kontrol_3.php';
    require_once '_metotlar_3.php';
	require_once ('../../my_class/kullanici_yetki.php');
    
    
	ust_yaz();
	
	// Hata mesajlarını göstermek için boş bir div
    echo " <div class='hatali'></div>  ";
 
     $mesaj = $_GET['msj'];
     if(isset($mesaj)){
	        echo "<script> myClick('.hatali','{$mesaj}','UYARI'); </script>";	
	    }

?>	 
    <div id="containerHolder">
      <div id="container" style="height: 470px;  background: #fff;">
	    <h2 style="float:left; margin-left:120px;">
            <a href="../../yonetim.php#">YÖNETİM</a> 
            &raquo; 
            <a href="../kullanici_islem.php">Kullanıcılar</a>
            &raquo;
           <a class="active" href="#">Ekle</a>
        </h2>               
        <div id="main" style="float:left; margin-left:120px;">
            <form onsubmit="return kontrol()" action="islem_ekle.php" method="post" class="jNice">
               <fieldeset>
                     <div class="kullanici_ekle_satir">
                       <div class="kullanici_ekle_sag" > Kullanıcı Adı :</div>
                       <input id="kul_ad" type="text"  placeholder="Kullanıcı Adı " name="kul_ad" />
                    </div>

                     <div class="kullanici_ekle_satir">
                       <div class="kullanici_ekle_sag" > Şifre :</div>
                       <input id="kul_sifre" type="password" placeholder="Şifre"  name="kul_sifre" />
                    </div>

                    <div class="kullanici_ekle_satir">
                       <div class="kullanici_ekle_sag" > Ad :</div>
                       <input id = "ad" type="text" placeholder="Ad" name="ad" />
                    </div>

                     <div class="kullanici_ekle_satir">
                       <div class="kullanici_ekle_sag" > Soyad :</div>
                       <input id="soyad" type="text" placeholder="Soyad" name="soyad" />
                    </div>
                    
                     <div class="my" style="margin-top:5px;" >
                           <div class="kullanici_ekle_sag" > Yetkisi :</div>
                           <div class="myy">
                             <select name="yetki" id="yetki"  >
                              <option value="0">Yetki Seçiniz</option>
<?php   
   $db = new kullanici_yetki();
   $sonuc = $db->listele();
   
   // tablodan veri gelmiiş mi gelmemiş mi kontrol edilir
   if($sonuc){
 	foreach($sonuc as $row) {
         // echo $row['pk'] .' - '. $row['yetkisi'] . '<br />';
         echo " <option value='{$row['pk']}'>{$row['yetkisi']}</option> ";
       }
    } 
 ?>                   
                             </select>
                         </div>
                    </div>
                    <div class="kullanici_ekle_satir">
                        <div class="kullanici_ekle_sag" > &nbsp  </div>
                        <input  class="my_button" type="submit" name="onay" value="Kullanıcılara Ekle" />
                    </div>
                </fieldeset>   
            </form>
        </div>
         <div class="clear"></div>
      </div>
   </div>

<?php
    alt_yaz();	
?>