<?php
     error_reporting(0);
   
    /**
     * session bilgisi kontrol edilir
     */ 
    require_once '../my_class/telefon.php';  
    require_once '../my_class/adres.php';
    
    $adres_fk = $_POST['adresler'];   
    if ($adres_fk && strcmp($adres_fk, "0") != 0) {
            
        $db=new telefon();
        $telefonlar = $db->getir($adres_fk);
       if ($telefonlar) {
       foreach ($telefonlar as $sonuc) {
            echo "         
                          <div class='kullanici_ekle_satir'>
                             <label style ='float:left; padding-top:5px;  width:100px;'> Telefon :</label>
                             <label style ='float:left; padding-top:5px; width:100px;'> {$sonuc['telefon']} </label>
                             <label style ='float:left; padding-top:5px; width:100px;'> Faks :</label>
                             <label style ='float:left; padding-top:5px; width:100px;'> {$sonuc['faks']} </label>
                             <input style ='float:left; padding-top:2px; width:20px;' type='checkbox' name='tel[]' value='{$sonuc['pk']}' />
                          </div>
            ";
           }
              echo "  <div class='kullanici_ekle_satir' style='height:40px;'>
                            <div class='kullanici_ekle_sag' > &nbsp  </div>
                            <input  class='my_button' type='submit' name='onay' value='Telefonları Sil' />
                     </div> ";
        }
        else {
                
            $db=new adres();
            $sonuc = $db->adres_getir2($adres_fk);   
            if ($sonuc) {
                $musteri_pk = $sonuc['musteri_fk'];
             } 
            echo " <div class='kullanici_ekle_satir' style='height:40px;'>
                      <div class='kullanici_ekle_sag' > &nbsp  </div>
                      <h3> Telefon bilgisi bulunamadı. Telefon eklemek için  
                          <a href='adres-ekle-form.php?musteri_pk={$musteri_pk}' class='view' >Tıklayınız.</a> 
                      </h3>
                   </div>
                   ";
        }
     }

?>