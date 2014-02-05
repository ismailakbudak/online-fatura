<?php
   
     require_once 'mySQL.php';
       
     class musteri_kod extends mySQL {
                
            //ekeleme              
            public function ekle($sirket_fk, $musteri_kod  , $aciklama , $extra ) {
               if(isset($this->bag)){
                      /* Etkilenen satır sayısını  döndürür */
                      $sonuc = $this->bag->exec(   " INSERT INTO `musteri_kod`(`sirket_fk`, `kod`, `aciklama`, `extra`) 
                                                      VALUES ('$sirket_fk}','{$musteri_kod}','{$aciklama}' , '{$extra}')");
                      return $sonuc ; 
               }
               else { return -1; }
            }
           
            // silme
            public function sil($kod_pk){
                 if(isset($this->bag)){
                      /* Etkilenen satır sayısını  döndürür */
                      $sonuc = $this->bag->exec(   " DELETE FROM `musteri_kod` WHERE pk = '{$kod_pk}'");
                      return $sonuc ; 
               }
               else { return -1; }
            }
           
            //güncelleme
            public function guncelle($kod_pk,$kod,$aciklama,$extra){
                if(isset($this->bag)){
                      /* Etkilenen satır sayısını  döndürür */
                      $sonuc = $this->bag->exec(   " UPDATE `musteri_kod` SET 
                                                            `kod`='{$kod}',
                                                            `aciklama`='{$aciklama}',
                                                            `extra`='{$extra}' 
                                                             WHERE pk = '{$kod_pk}'");
                      return $sonuc ; 
               }
               else { return -1; }
            }
                    
             // listeme       
             public function listele($sirket_pk){
               if(isset($this->bag)){
                     $sonuc = $this->bag->query("SELECT * FROM  `musteri_kod` WHERE `sirket_fk` = '{$sirket_pk}' ");
                   if ($sonuc) {   
                       return $sonuc->fetchAll();
                   }
                   else {
                       return FALSE;
                   } 
               }
               else { return -1; }
            }
            
            // sayfalama için gerekli grupları çeker
            function kod_getir_for_sayfa($sirket_pk,$baslangic,$count){
              if(isset($this->bag)){
                     $sonuc = $this->bag->query("SELECT * FROM  `musteri_kod`
                                                 WHERE `sirket_fk` = '{$sirket_pk}'
                                                 ORDER BY pk DESC
                                                 LIMIT $baslangic,$count");
                   if ($sonuc) {   
                       return $sonuc->fetchAll();
                   }
                   else {
                       return FALSE;
                   } 
               }
               else { return -1; }
             }
             
            // kod getirir
             public function kod_getir_by_pk($kod_pk){
               if(isset($this->bag)){
                     $sonuc = $this->bag->query("SELECT * FROM  `musteri_kod` WHERE pk = '{$kod_pk}' ");
                   if ($sonuc) {   
                       return $sonuc->fetch();
                   }
                   else {
                       return FALSE;
                   } 
               }
               else { return -1; }
           }        
                      
     

     }
  ?>