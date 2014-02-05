<?php

    require_once '../_session_kontrol_3.php';
    require_once '../kullanici/_metotlar_3.php';
    require_once '../../my_class/kullanicilar.php';
    require_once '../../my_class/sirket_detay.php';

    ust_yaz();
     
     echo " <div class='hatali'></div>  ";
     $mesaj = $_GET['msj'];
     if(isset($mesaj) && strcmp($mesaj, "") != 0)
           echo "<script> myClick('.hatali','{$mesaj}','UYARI'); </script>";   
     
?>
    <div id="containerHolder">
        <div id="container" style="height: 470px;  background: #fff;">
           <h2 style='float:left; margin-left:120px;'>
             <a href='../../yonetim.php#'>YÖNETİM</a> 
             &raquo; 
             <a href='../kullanici_sirket.php'>Kullanıcı Şirketleri</a>
             &raquo;
             <a class='active' href='#'>Kullanıcıya Şirket Ekle</a>
           </h2>
           <script> var dizi = new Array('sirket','kullanici');  </script>
           <div id='main' style='float:left; margin-left:120px;'>
             <form onsubmit='return kontrol_dizi(dizi);' action='ekle_islem.php' method='post' class='jNice'> 
                <div class='my' > 
                   <div class='kullanici_ekle_sag' > Kullanıcılar : </div>  
                   <div class='myy' >
                      <select name='kullanici' class='kullanici'>
                         <option value='0'>Kullanıcı Seçiniz</option>
<?php        
     $db = new kullanicilar();
     $kullancilar = $db->listele();     
     if ($kullancilar) {
         foreach ($kullancilar as $row) {
             echo " <option value='{$row['pk']}'> {$row['kullanici_adi']}</option> ";
         }
     }
 ?>           
                     </select>
                   </div>
                </div> 
                <div class='my' > 
                   <div class='kullanici_ekle_sag' > Şirketler : </div>  
                   <div class='myy' >
                      <select name='sirket' class='sirket'>
                         <option value='0'>Şirket Seçiniz</option>
<?php           
     $db = new sirket_detay();
     $sirketler = $db->listele();     
     if ($sirketler) {
         foreach ($sirketler as $row) {
             echo " <option value='{$row['pk']}'> {$row['sirket_isim']}</option> ";
         }
     }
?>           
                    </select>
                   </div>
                </div> 
               <div class='kullanici_ekle_satir' style='margin-top:20px;'>
                        <div class='kullanici_ekle_sag' > &nbsp  </div>
                        <input  class='my_button' type='submit' name='onay' value='Kullanıcıya Ekle' />
                 </div>
              </form>
           </div>
           <div class="clear"></div>
      </div>
   </div>	          
<?php
     alt_yaz(); 
?>