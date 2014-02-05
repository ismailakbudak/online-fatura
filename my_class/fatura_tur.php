<?php
    require_once 'mySQL.php';
 
    class fatura_tur extends mySQL {
         
         // Ekleme Metodu
         public function ekle($tur_adi)
         {
          	 if (isset ($this->bag)) {
         	       $sonuc = $this->bag->exec("INSERT INTO `fatura_tur` (`tur_adi`) VALUES ( '{$tur_adi}')");
                  return $sonuc;
         	    }
              else { return -1; } 
         }

         // Turleri Getiren Metot
         public function getir_turleri(){
                   if(isset($this->bag)){
                          $sonuc = $this->bag->query(" SELECT * FROM `fatura_tur` ");
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