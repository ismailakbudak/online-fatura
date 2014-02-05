<?php

     require_once 'mySQL.php';

     class sirket_detay extends mySQL {
            	
            // tablo isminin tutuldugu değişken
            public $table;
           	
            // yapılandırıcı metot
            function __construct()   {
                	parent::__construct();
                 $this->table = 'sirket_detay';
            }
            
            // ekleme metodu	
            public function ekle($sirket_isim,$vergi_dairesi,$vergi_no,$eposta,$web,$aciklama){
           	       if(isset($this->bag)){
           	              $sonuc = $this->bag->exec(	" INSERT INTO $this->table 
           	                                        (`sirket_isim`, `vergi_dairesi`, `vergi_no`, `web`, `eposta`, `aciklama`) 
           	                                          VALUES ('{$sirket_isim}','{$vergi_dairesi}','{$vergi_no}','{$web}','{$eposta}','{$aciklama}')");
           	       	   return $sonuc ;
           	       }
                  else { return -1; }
            }
            
            //Silme işlemini yapan metot
            public function sil( $pk){		
                	if(isset($this->bag)){
                			  $sonuc = $this->bag->exec("DELETE FROM $this->table WHERE pk = '{$pk}'");
                            return $sonuc ;
                  }
                  else { return -1; }
           }
            
             // Güncelleme yapan metot
            public function guncelle($pk,$sirket_isim,$vergi_dairesi,$vergi_no,$web,$eposta,$aciklama){
           	    if(isset($this->bag)){
           	          $sonuc = $this->bag->exec("UPDATE $this->table  SET 
           	                                   `sirket_isim`='{$sirket_isim}',
           	                                   `vergi_dairesi`='{$vergi_dairesi}',
           	                                   `vergi_no`='{$vergi_no}',
           	                                   `web`='{$web}',
           	                                   `eposta`='{$eposta}',
           	                                   `aciklama`='{$aciklama}' 
           	                                    WHERE pk='{$pk}'");
                      return $sonuc ;
           		
                }	
                 else { return -1; }
           }
            
            //tablodaki verileri dizi şeklinde döndüren metot
            public function listele(){
           	        if(isset($this->bag)){
           	              $sonuc = $this->bag->query("SELECT * FROM $this->table");
           	              return $sonuc ;		
                       }
           	        else {  return -1; }
            }
            
            // sirket getiren metot
            public function sirket_getir($pk_sirket){
               if(isset($this->bag)){
                   $sonuc = $this->bag->query("SELECT * FROM  $this->table
                                                  WHERE pk = '{$pk_sirket}'");
           	        if($sonuc){
           	    		    return $sonuc->fetch();
           		      }
           	      	else {
           			        return false;
           		      }
                }
              	else { return -1;}
            }
           
            // sirket ismine göre şirketleri getiren metot
            public function sirket_getir_by_isim($sirket_isim){
               if(isset($this->bag)){
                   $sonuc = $this->bag->query("SELECT * FROM  $this->table
                                                  WHERE sirket_isim = '{$sirket_isim}'");                  
                   if($sonuc){
                       return $sonuc->fetch();
                   }
                   else {
                       return false;
                   }
               }
               else { return -1;}
            }
            

            
            
    }
 ?>