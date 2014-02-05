<?php 
    
     require_once 'mySQL.php';

     class odeme_detay extends mySQL{
               
           // tablo ismi
           public $table;
          
           // constructor
           function __construct(){
                parent::__construct();
                $this->table = 'odeme_detay';
           } 
          
           // ekleme
           function ekle($odeme_tur){
               
               if (isset($this->bag)) {
                   
                   $sonuc = $this->bag->exec("INSERT INTO $this->table 
                                              (`odeme_tur`)
                                              VALUES('{$odeme_tur}')");
                   return $sonuc;
               }
               else 
                   return -1;
           }
          
           // listeleme
           function listele(){
               if (isset($this->bag)) {
                  
                   $sonuc = $this->bag->query("SELECT * FROM $this->table");
                   if ($sonuc) 
                       return $sonuc->fetchAll();
                   else 
                       return false;  
               }
               else 
                   return -1;
           }    
           
             
  

   } 
?>