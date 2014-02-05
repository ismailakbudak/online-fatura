<?php

    require_once '../_session_kontrol_3.php';
    require_once '../kullanici/_metotlar_3.php';
    require_once '../../my_class/kullanicilar.php';
    require_once '../../my_class/sirket_detay.php';
    require_once '../../my_class/kullanici_sirket.php';
    
    function geri($mesaj){
        $url = '../kullanici_sirket.php?msj='.$mesaj ;
  
        echo "<script>
                  window.location = '{$url}';
	      </script>";
        exit();
        
    }
     
     ust_yaz();

     echo " <div class='hatali'></div>  ";
     $mesaj = $_GET['msj'];
     if(isset($mesaj) && strcmp($mesaj, "") != 0)
           echo "<script> myClick('.hatali','{$mesaj}','UYARI'); </script>";   
     
     
    $kullanici_sirket_pk = $_GET['pk'];
    if (!$kullanici_sirket_pk) {
        $mesaj = "Bilgiler eksik geldiği için işlem yapılamıyor....";
        geri($mesaj);
    }
    
    $db = new kullanici_sirket();
    $kullanici_sirket = $db->getir2($kullanici_sirket_pk); 
    if ($kullanici_sirket) {
        if ($bilgi = $kullanici_sirket->fetch() ) {
           
        }
        else {
            $mesaj = "Bilgiler eksik geldiği için işlem yapılamıyor....";
            geri($mesaj);
        }
        
    }
    else {
        $mesaj = "Bilgiler eksik geldiği için işlem yapılamıyor....";
        geri($mesaj);
    } 
?>
    <div id="containerHolder">
       <div id="container" style="height: 470px;  background: #fff;">
           <h2 style='float:left; margin-left:120px;'>
             <a href='../../yonetim.php#'>YÖNETİM</a> 
             &raquo; 
             <a href='../kullanici_sirket.php'>Kullanıcı Şirketleri</a>
             &raquo;
             <a class='active' href='#'>Düzenle</a>
           </h2>
           <script>
                   var dizi = new Array('sirket','kullanici');
           </script>
           <div id='main' style='float:left; margin-left:120px;'>
               <form onsubmit='return kontrol_dizi(dizi);' action='duzenle_islem.php?pk=<?=$bilgi['pk'] ?>' method='post' class='jNice'> 
              <div class='my' > 
                   <div class='kullanici_ekle_sag' > Kullanıcı Bilgisi : </div>  
                   <div class='myy' >
                      <select name='kullanici' class='kullanici'>
                         <option value='0'>Kullanıcı Seçiniz</option>
<?php    
     $db = new kullanicilar();
     $kullancilar = $db->listele();     
     if ($kullancilar) {
         foreach ($kullancilar as $row) {
             if ($bilgi['kullanici_fk'] == $row['pk']) {
                 echo " <option selected value='{$row['pk']}'> {$row['kullanici_adi']}</option> ";
             }
             else {
                 echo " <option value='{$row['pk']}'> {$row['kullanici_adi']}</option> ";
             }
         }
     }
?>                     
                     </select>
                   </div>
                </div> 
                <div class='my' > 
                   <div class='kullanici_ekle_sag' > Şirket Bilgisi : </div>  
                   <div class='myy' >
                      <select name='sirket' class='sirket'>
                         <option value='0'>Şirket Seçiniz</option>
<?php           
     $db = new sirket_detay();
     $sirketler = $db->listele();     
     if ($sirketler) {
         foreach ($sirketler as $row) {
             if ($bilgi['sirket_fk'] == $row['pk'] ) {
                  echo " <option selected value='{$row['pk']}'> {$row['sirket_isim']}</option> ";
             }
             else {
                  echo " <option value='{$row['pk']}'> {$row['sirket_isim']}</option> ";
              }
         }
     }
?>     
                     </select>
                   </div>
                </div> 
                <div class='kullanici_ekle_satir' style='margin-top:20px;'>
                        <div class='kullanici_ekle_sag' > &nbsp  </div>
                        <input  class='my_button' type='submit' name='onay' value='Bilgileri Güncelle' />
                 </div>         
              </form>
            </div>
            <div class="clear"></div>
      </div>
   </div>	 

<?php            
     alt_yaz(); 
?>