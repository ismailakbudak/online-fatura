<?php
    require_once 'mySQL.php';
 
    class fatura_position extends mySQL {
         
         // Ekleme Metodu
         public function ekle($sirket_fk,$fatura_tur_fk,$dizayn_adi,$width,$height)
         {
          	 if (isset ($this->bag)) {
         	       $sonuc = $this->bag->exec("INSERT INTO `fatura_position`(`sirket_fk`, `fatura_tur_fk`, `dizayn_adi`, `width`, `height` ) 
                                            VALUES ('{$sirket_fk}','{$fatura_tur_fk}','{$dizayn_adi}','{$width}','{$height}' ) ");
                 if($sonuc){
                    return  $this->bag->lastInsertId();
                 }
                 else{
                    return false;
                 }
         	    }
              else { return -1; } 
         }
         
          // Turleri Getiren Metot
         public function dizayn_getir($pk){
                   if(isset($this->bag)){
                          $sonuc = $this->bag->query("SELECT * FROM `fatura_position` WHERE `pk`= $pk ");
                          if ($sonuc) {   
                               return $sonuc->fetch();
                           }
                           else {
                               return FALSE;
                           } 
                   }
                   else {  return -1; }
            }

         // Turleri Getiren Metot
         public function sirket_dizaynlarini_getir($sirket_fk){
                   if(isset($this->bag)){
                          $sonuc = $this->bag->query("SELECT * FROM `fatura_position` WHERE `sirket_fk`= $sirket_fk ");
                          if ($sonuc) {   
                               return $sonuc->fetchAll();
                           }
                           else {
                               return FALSE;
                           } 
                   }
                   else {  return -1; }
            }
            
      
    }

 ?>