<?php

    require_once  'mySQL.php';

    class fatura_detay extends mySQL {
         // ekleme metodu
         public function ekle($musteri_fk,$odeme_turu, $fatura_tarih,
                              $aciklama, $acik, $fatura_basim_tarihi, 
                              $kdv_tutar, $toplam_tutar, $kdvsiz_toplam_tutar, 
                              $vergi_daire_no, $vergi_no, $toplamdan_iskonto_tutari,
                              $fiili_sevk_tarihi, $iskontadan_onceki_toplam,
                              $fatura_no, $sirket_fk)
         {
             if (isset ($this->bag)) {     
                 $sonuc = $this->bag->exec(" INSERT INTO `fatura_detay`
                                           ( `musteri_fk`,`odeme_turu`, `fatura_tarih`, 
                                            `aciklama`, `acik`, `fatura_basim_tarihi`, 
                                            `kdv_tutar`, `toplam_tutar`, `kdvsiz_toplam_tutar`, 
                                            `vergi_daire_no`, `vergi_no`, `toplamdan_iskonto_tutari`, 
                                            `fiili_sevk_tarihi`, `iskontadan_onceki_toplam`, 
                                            `fatura_no`, `sirket_fk`) 
                                            VALUES ( '{$musteri_fk}', '{$odeme_turu}' , '{$fatura_tarih}' ,
                                                     '{$aciklama}' , '{$acik}' , '{$fatura_basim_tarihi}' , 
                                                     '{$kdv_tutar}' , '{$toplam_tutar}' , '{$kdvsiz_toplam_tutar}' , 
                                                     '{$vergi_daire_no}' , '{$vergi_no}' , '{$toplamdan_iskonto_tutari}' ,
                                                     '{$fiili_sevk_tarihi}' , '{$iskontadan_onceki_toplam}' , '{$fatura_no}' , '{$sirket_fk}')");
                  if ($sonuc) {
                        return  $sonuc = $this->bag->lastInsertId();
                  }
                  else {
                        return FALSE;
                  }
             }
             else {
                 return -1;
             } 
         }

         // silme metodu
         function sil($fatura_pk){
             if (isset ($this->bag)) {
                      $sonuc = $this->bag->exec("DELETE FROM `fatura_detay` WHERE pk = $fatura_pk");
                      return $sonuc;
             }
             else {
                 return -1;
             }
         }

         /// guncelleme 
         function guncelle($fatura_pk,$musteri_fk,$odeme_turu, $fatura_tarih,
                                        $aciklama, $acik, $fatura_basim_tarihi, 
                                        $kdv_tutar, $toplam_tutar, $kdvsiz_toplam_tutar, 
                                        $vergi_daire_no, $vergi_no, $toplamdan_iskonto_tutari,
                                        $fiili_sevk_tarihi, $iskontadan_onceki_toplam, $fatura_no, $sirket_fk)
         {
                     if (isset ($this->bag)) {
                             $sonuc = $this->bag->exec("UPDATE `fatura_detay` SET 
                                                        `musteri_fk`='{$musteri_fk}',
                                                        `odeme_turu`='{$odeme_turu}',
                                                        `fatura_tarih`='{$fatura_tarih}',
                                                        `aciklama`='{$aciklama}',
                                                        `acik`='{$acik}',
                                                        `fatura_basim_tarihi`='{$fatura_basim_tarihi}',
                                                        `kdv_tutar`='{$kdv_tutar}',
                                                        `toplam_tutar`='{$toplam_tutar}',
                                                        `kdvsiz_toplam_tutar`='{$kdvsiz_toplam_tutar}',
                                                        `vergi_daire_no`='{$vergi_daire_no}',
                                                        `vergi_no`='{$vergi_no}',
                                                        `toplamdan_iskonto_tutari`='{$toplamdan_iskonto_tutari}',
                                                        `fiili_sevk_tarihi`='{$fiili_sevk_tarihi}',
                                                        `iskontadan_onceki_toplam`='{$iskontadan_onceki_toplam}',
                                                        `fatura_no`='{$fatura_no}',
                                                        `sirket_fk`='{$sirket_fk}'
                                                         WHERE pk = $fatura_pk"); 
                            return $sonuc;
                                                                                  
                        }
                     else {
                        return -1;
                     }                                                               
        }

         // fatura getirir
         function fatura_getir_by_id($fatura_pk){
              if (isset ($this->bag)) {
                      $sonuc = $this->bag->query("SELECT fd.*,md.musteri_unvan FROM `fatura_detay` AS fd 
                                                  INNER JOIN `musteri_detay` AS md on md.pk = fd.musteri_fk  
                                                  WHERE fd.pk = $fatura_pk");
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
          // dahaonra fetch edilecek şekilde veri döndürür
         function fatura_getir_by_id_obj($fatura_pk){
              if (isset ($this->bag)) {
                      $sonuc = $this->bag->query("SELECT * FROM `fatura_detay` WHERE pk = $fatura_pk");          
                     return $sonuc;
             }
             else {
                 return -1;
             } 
         }
         
         // sayfalama için belli sayıda fatura bilgisi çeker
         function fatura_getir_for_sayfa($sirket_pk,$baslangic,$count){
            if (isset ($this->bag)) {
                      $sonuc = $this->bag->query("SELECT * FROM `fatura_detay`
                                                  WHERE sirket_fk = '{$sirket_pk}'
                                                  ORDER BY pk DESC
                                                  LIMIT $baslangic,$count");
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
         
         // listeleme
         function listele($sirket_pk){
             if (isset ($this->bag)) {
                      $sonuc = $this->bag->query("SELECT * FROM `fatura_detay` WHERE sirket_fk = $sirket_pk");
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
          // listeleme 2 daha sonra fetch edilecek şekilde veri döndürür
         function listele2($sirket_pk){
             if (isset ($this->bag)) {
                      $sonuc = $this->bag->query("SELECT * FROM `fatura_detay` WHERE sirket_fk = $sirket_pk");
                      return $sonuc;
             }
             else {
                 return -1;
             }    
          }
            
    }
?>