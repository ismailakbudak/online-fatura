 <?php
    
     require_once 'mySQL.php';
    
     class sirket_ayar extends mySQL {

        // ekleme metodu	
         public function ekle($sirket_pk,$kurus_ayar,$extra){
        	if(isset($this->bag)){
        		$sonuc = $this->bag->exec("INSERT INTO `sirket_ayar`
        			                       ( `sirket_fk`, `kurus_ayar`, `extra`) 
        			                       VALUES ( '{$sirket_pk}','{$kurus_ayar}','{$extra}')");
        	   return $sonuc ;
        	}
        	else { return -1; }
         }
         
          // güncelleme
         public function guncelle($pk,$kurus_ayar,$extra){
            if(isset($this->bag)){

                 $sonuc = $this->bag->query("UPDATE `sirket_ayar` SET 
                                            `kurus_ayar`= '{$kurus_ayar}',
                                            `extra`=  '{$extra}'
                                             WHERE pk = $pk");
                 return $sonuc; 
            }
            else { return -1; }
         }

         // şirket ayarlarını getiren metot
         public function ayar_getir_sirket($sirket_pk){
            if(isset($this->bag)){
                $sonuc = $this->bag->query("SELECT * FROM `sirket_ayar`
                                            WHERE sirket_fk =  $sirket_pk  ");
                if ($sonuc) 
                    return $sonuc->fetch();
                else
                    return FALSE;
            }
            else { return -1; }
         }


    } 
?>