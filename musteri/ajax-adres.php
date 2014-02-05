<?php
    error_reporting(0);
    require_once '../my_class/adres.php';  
     
     $adres_fk = $_POST['adresler'];   
    if ($adres_fk && strcmp($adres_fk, "0") != 0) {
            
        $db=new adres();
        $sonuc = $db->adres_getir2($adres_fk);
        
        if ($sonuc) {
        echo "<form onsubmit='' action='adres-guncelle-islem.php?pk={$sonuc['pk']}' method='post' class='jNice'>              
                  <div class='kullanici_ekle_satir' style='height:50px'>
                      <div class='kullanici_ekle_sag' > Adres :</div>
                      <textarea  name='adres' style='height:50px; float:left; width:300px;' rows='5' cols='20'>{$sonuc['adres']}</textarea>                    
                  </div>

                  <div class='kullanici_ekle_satir' style='height:50px'>
                      <div class='kullanici_ekle_sag' > Açıklama :</div>
                      <textarea id='resizable' name='aciklama' style='height:50px; float:left; width:300px;' rows='5' cols='20'>{$sonuc['aciklama']}</textarea>                    
                  </div>
              
                  <div class='kullanici_ekle_satir' style='height:40px;'>
                      <div class='kullanici_ekle_sag' > &nbsp  </div>
                      <input  class='my_button' type='submit' name='onay' value='Adresi Güncelle' />
                 </div>
             </form>
           ";
            
            
        }        
        else {
            echo 'Adres bilgileri çekilemedi..';
        }
    }
    

?>