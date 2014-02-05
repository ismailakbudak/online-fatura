<?php
 
    require_once 'mySQL.php';
    class adres_musteri extends mySQL {
  	
         // tablo isminin tutuldugu değişken
        public $table;
        
        // yapılandırıcı metot
        function __construct()   {
            	parent::__construct();
              $this->table = 'adres_musteri';
        }
        
         // ekleme metodu	
        public function ekle($adres_fk,$musteri_fk ){
       	      if(isset($this->bag)){
       	      	   $sonuc = $this->bag->exec(" INSERT INTO $this->table 
       	                                         ( `adres_fk`, `musteri_fk`) 
       	                                         VALUES ('{$adres_fk}','{$musteri_fk}')");				  
       	      	    return $sonuc;		 
       	      }
       	      else {
       	      	return -1;
       	      }
         }
                
         // silme metodu  
         public function sil($adres_fk ){
              if(isset($this->bag)){
                     $sonuc = $this->bag->exec(" DELETE FROM $this->table WHERE adres_fk = '{$adres_fk}'");            
                     return $sonuc;
              }
              else {  return -1; }
         }       
    }
?>