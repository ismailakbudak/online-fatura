<?php

    require_once  'mySQL.php';
    class fatura_urun extends mySQL {
         
         // Ekleme metodu  
         public function ekle($fatura_detay_fk, $urun_kodu, $urun_adi, 
                              $miktar, $birim_fiyati, $miktar_birim, 
                              $iskonto_tutari, $tutar)
         {
          	 if (isset ($this->bag)) {
         	       $sonuc = $this->bag->exec("INSERT INTO `fatura_urun`
         	                             ( `fatura_detay_fk`, `urun_kodu`, `urun_adi`, 
         	                             `miktar`, `birim_fiyati`, `miktar_birim`, 
         	                             `iskonto_tutari`, `tutar`) 
         	                              VALUES ( '{$fatura_detay_fk}' , '{$urun_kodu}' , '{$urun_adi}' , 
                                                    '{$miktar}' , '{$birim_fiyati}' , '{$miktar_birim}' , 
                                                    '{$iskonto_tutari}' , '{$tutar}' )");
                  
                  return $sonuc;
         	    }
              else {
                  return -1;
              } 
         }
          
         // Güncelleme metodu
         public function guncelle($fatura_urun_pk , $fatura_detay_fk, $urun_kodu, $urun_adi, 
                                        $miktar, $birim_fiyati, $miktar_birim, 
                                        $iskonto_tutari, $tutar)
         {
              if (isset ($this->bag)) {
                  $sonuc = $this->bag->exec("UPDATE `fatura_urun` SET 
                                                    `fatura_detay_fk`='{$fatura_detay_fk}',
                                                    `urun_kodu`='{$urun_kodu}',
                                                    `urun_adi`='{$urun_adi}',
                                                    `miktar`='{$miktar}',
                                                    `birim_fiyati`='{$birim_fiyati}',
                                                    `miktar_birim`='{$miktar_birim}',
                                                    `iskonto_tutari`='{$iskonto_tutari}',
                                                    `tutar`='{$tutar}'
                                             WHERE pk = $fatura_urun_pk");
                  
                  return $sonuc;
              }
              else {
                  return -1;
              } 
         } 
         
         //silme işlemi
         function sil($fatura_urun_pk ){
               if (isset ($this->bag)) {
                       
                       $sonuc = $this->bag->exec( "DELETE FROM `fatura_urun` 
                                                   WHERE pk = '{$fatura_urun_pk}' " );
                      return $sonuc;
              }
              else {
                  return -1;
              } 
           }
                              
          // fatura_detay_fk ya göre ürünleri getirir
          function fatura_urun_getir_by_fatura_detay_fk($fatura_detay_fk){
               if (isset ($this->bag)) {
                  $sonuc = $this->bag->query(" SELECT f.* , u.kdv_orani FROM `fatura_urun` as f 
                                               INNER JOIN `urunler` as u ON u.urun_kodu = f.urun_kodu 
                                               WHERE fatura_detay_fk = $fatura_detay_fk");
                  if ($sonuc) {
                      return $sonuc->fetchAll();
                  }
                  else {
                      return false;
                  }
              }
              else {
                  return -1;
              } 
          }    
                       
          // fatura_detay_fk ve urun_koduna  göre ürünleri getirir
          function fatura_urun_getir_by_id($fatura_urun_pk){
               if (isset ($this->bag)) {
                  $sonuc = $this->bag->query(" SELECT f.*, u.pk as urun_fk , u.kdv_orani  FROM `fatura_urun` as f
                                               INNER JOIN `urunler` as u ON u.urun_kodu = f.urun_kodu 
                                               WHERE f.pk = '{$fatura_urun_pk}' ");
                  if ($sonuc) {
                      return $sonuc->fetch();
                  }
                  else {
                      return false;
                  }
              }
              else {
                  return -1;
              } 
          }                            
    

    }
?>    