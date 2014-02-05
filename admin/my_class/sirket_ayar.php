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
        



    } 
?>