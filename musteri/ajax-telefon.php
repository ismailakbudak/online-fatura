
<?php
     error_reporting(0);
   
    require_once '../my_class/telefon.php';  
    require_once '../my_class/adres.php'; 
  
    $adres_fk = $_POST['adresler'];   
    if ($adres_fk && strcmp($adres_fk, "0") != 0) {
            
        $db=new telefon();
        $telefonlar = $db->getir($adres_fk);
        
        if ($telefonlar) {
            

            foreach ($telefonlar as $sonuc) {
            echo "   <form onsubmit='' action='tel-guncelle-islem.php?pk={$sonuc['pk']}' method='post' class='jNice'>              
                         
                          <div class='kullanici_ekle_satir'>
                             <div class='kullanici_ekle_sag' > Telefon :</div>
                             <input value='{$sonuc['telefon']}' id='tel' type='number'  placeholder='Telefon Numarası ' name='tel' />
                          </div>
                          
                         <div class='kullanici_ekle_satir'>
                             <div class='kullanici_ekle_sag' > Faks :</div>
                             <input value='{$sonuc['faks']}' id='faks' type='number'  placeholder='Faks Numarası ' name='faks' />
                          </div>
                          
                          <div class='kullanici_ekle_satir' style='height:40px;'>
                            <div class='kullanici_ekle_sag' > &nbsp  </div>
                            <input  class='my_button' type='submit' name='onay' value='Telefonu Güncelle' />
                          </div>
                        
                   </form>
            ";
              
            }
        }        
        else {
                
            $db=new adres();
            $sonuc = $db->adres_getir2($adres_fk);   
            if ($sonuc) {
                $musteri_pk = $sonuc['musteri_fk'];
             } 
            echo "
                     <h3> Telefon bilgisi bulunamadı.. 
                     <a href='adres-ekle-form.php?musteri_pk={$musteri_pk}' class='view' >Buradan </a> Telefon Ekleyebilirsin. </h3>
                  ";
        }
    }
    

?>