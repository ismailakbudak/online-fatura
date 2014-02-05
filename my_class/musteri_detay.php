<?php    

     require_once 'mySQL.php';
    
     class musteri_detay extends mySQL {
               
            // yapılandırıcı metot
            function __construct()   {
                  parent::__construct();
                  $this->table = 'musteri_detay';
            }
            
            // ekleme metodu   
            public function ekle($sirket_fk, $musteri_kod  ,$musteri_unvan , $vergi_dairesi, $vergi_no, $eposta, $web, $aciklama){
                  if(isset($this->bag)){
                        $sonuc = $this->bag->exec(   " INSERT INTO $this->table 
                                                       (`sirket_fk`, `musteri_tabela`, `musteri_unvan`, 
                                                       `vergi_dairesi`, `vergi_no`, `web`, `eposta`, `aciklama`) 
                                                        VALUES ('$sirket_fk}','{$musteri_kod}','{$musteri_unvan}' ,
                                                        '{$vergi_dairesi}','{$vergi_no}','{$web}','{$eposta}','{$aciklama}' )");
                         if ($sonuc) {
                              return  $sonuc = $this->bag->lastInsertId();
                         }
                         else {
                             return FALSE;
                         } 
                  }
           	      else { return -1; }
            }
             
             // güncelleme metodu   
            public function guncelle($musteri_pk,$sirket_fk, $musteri_tabela  ,$musteri_unvan , $vergi_dairesi, $vergi_no, $eposta, $web, $aciklama){
                   if(isset($this->bag)){
                          $sonuc = $this->bag->exec(   "  UPDATE $this->table 
                                                          SET `sirket_fk`= '{$sirket_fk}',
                                                         `musteri_tabela`= '{$musteri_tabela}',
                                                         `musteri_unvan`= '{$musteri_unvan}',
                                                         `vergi_dairesi`= '{$vergi_dairesi}',
                                                         `vergi_no`= '{$vergi_no}',
                                                         `web`= '{$web}',
                                                         `eposta`= '{$eposta}',
                                                         `aciklama`= '{$aciklama}' 
                                                          WHERE pk = '{$musteri_pk}' ");
                          return $sonuc ; 
                   }
                   else { return -1; }
            }
            
            // iletişim bilgi güncelleme metodu   
            public function guncelle_iletisim($musteri_pk, $eposta, $web, $aciklama){
                   if(isset($this->bag)){
                          $sonuc = $this->bag->exec(   "  UPDATE $this->table 
                                                          SET 
                                                         `web`= '{$web}',
                                                         `eposta`= '{$eposta}',
                                                         `aciklama`= '{$aciklama}' 
                                                          WHERE pk = '{$musteri_pk}' ");
                          return $sonuc ; 
                   }
                   else { return -1; }
            } 
            
            //  Silme işlemini yapan metot
            public function sil( $pk){	
             	    if(isset($this->bag)){
             	         	$sonuc = $this->bag->exec("DELETE FROM $this->table  WHERE pk = '{$pk}'");
                         return $sonuc ;
                  }
           	      else { return -1; }
           }

            //  $where ve $where_value' ye göre müşteri çekilip geri döndürülüyor
            public function  musteri_getir($where,$where_value){
                	if (isset($this->bag)) {
                           $sonuc = $this->bag->query(" SELECT * FROM $this->table WHERE $where = '{$where_value}'");
                           if( $sonuc )
                           {
                             return $sonuc->fetch();
                           }
                           else {
                	            return false;
                           }
                   	}
                   	else { return -1; }
              }
              
             //  $where ve $where_value' ye göre müşteri çekilip geri döndürülüyor
             public function  musteri_getir2($pk){
                     if (isset($this->bag)) {
                            $sonuc = $this->bag->query(   " SELECT m.* , s.sirket_isim , s.pk as sirket_pk FROM $this->table as m
                                                            INNER JOIN `sirket_detay` as s ON s.pk = m.sirket_fk
                                                            WHERE m.pk = '{$pk}'");
                            if( $sonuc )
                            {
                              return $sonuc->fetch();
                            }
                            else {
                                 return false;
                            }
                     }
                     else { return -1; }
              }
              
              // sayfalama için belli gruplar şeklinde musteri çekilir
              function musteri_getir_for_sayfa($sirket_pk,$baslangic,$count){
                    if(isset($this->bag)){
           	              $sonuc = $this->bag->query("SELECT md.pk, sd.sirket_isim, md.musteri_tabela, md.musteri_unvan, 
           	                                          md.vergi_dairesi, md.vergi_no, md.web, md.eposta, md.aciklama
                                                      FROM $this->table AS md
                                                      INNER JOIN sirket_detay AS sd ON md.sirket_fk = sd.pk 
                                                      WHERE sd.pk = '{$sirket_pk}'
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
              
              //  musteri_detay tablosundaki verileri döndüren metot
              public function listele($sirket_pk){
           	       if(isset($this->bag)){
           	             $sonuc = $this->bag->query("SELECT md.pk, sd.sirket_isim, md.musteri_tabela, md.musteri_unvan, 
           	                                         md.vergi_dairesi, md.vergi_no, md.web, md.eposta, md.aciklama
                                                     FROM $this->table AS md
                                                     INNER JOIN sirket_detay AS sd ON md.sirket_fk = sd.pk 
                                                     WHERE sd.pk = '{$sirket_pk}' ");
           	             if ($sonuc) {	
           		                return $sonuc->fetchAll();
           		           }
           		           else {
           		           	return FALSE;
           		           } 
                   }
           	       else { return -1; }
               }
            


    }
 ?>