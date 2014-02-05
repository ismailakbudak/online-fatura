<?php 

     require_once 'mySQL.php';
     class kullanici_yetki extends mySQL{
           
            // tablo isminin tutuldugu değişken
            public $table;
             
             // Yapılandırıcı metot
            function __construct()   {
                	parent::__construct();
                    $this->table = 'kullanici_yetki';
            }
           
            // ekleme metodu	
            public function ekle($yetkisi){
               	if(isset($this->bag)){
               		$sonuc = $this->bag->exec("INSERT INTO $this->table 
               	                             ( yetkisi ) VALUES('{$yetkisi}')");
               	   return $sonuc ;
               	}
               	else { return -1; }
            }
           
            // silme metodu
            public function sil( $where_value){	
             	if(isset($this->bag)){
                   $sonuc = $this->bag->exec("DELETE FROM $this->table 
                                               WHERE pk = '{$where_value}'");
                   return $sonuc ;
                }
           	    else { return -1; }
           }
           
            // güncelleme metodu
            public function guncelle($update, $update_value, $where_value  ){
             	if(isset($this->bag)){
             	   $sonuc = $this->bag->exec("UPDATE $this->table
             	                              SET $update='{$update_value}' 
             	                              WHERE pk='{$where_value}'");
                     return $sonuc ;
                 }
             	else { return -1; }
           }
           
            // tablodaki verileri dizi şeklinde döndüren metot
            public function listele(){
           	    if(isset($this->bag)){
               
               	         $sonuc = $this->bag->query("SELECT * from $this->table");
               	         return $sonuc ;
                }
           	    else { return -1; }
           }
           
   
   }
  ?>