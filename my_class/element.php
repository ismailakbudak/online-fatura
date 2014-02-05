<?php
    require_once 'mySQL.php';
 
    class element extends mySQL {

         // Elementleri Getiren Metot
         public function element_getir(){
                   if(isset($this->bag)){
                          $sonuc = $this->bag->query(" SELECT * FROM `element` ");
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