<?php 

    require_once 'mySQL.php';
 
    class fatura_position_xy extends mySQL {
        
        // fatura_position id sine göre eleamanları döndürür
        function eleman_xy_getir($id){
              if(isset($this->bag)){
                          $sonuc = $this->bag->query("SELECT `fp`.*, `e`.`isim`, `e`.`database_name` 
                          	                          FROM `fatura_position_xy` AS `fp`
                                                      INNER JOIN `element` AS `e` 
                                                      ON `fp`.`element_fk` = `e`.`pk`
                                                      WHERE `fp`.`fatura_position_fk` = $id ");
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