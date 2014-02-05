<?php

     // Gerekli dosyaların yüklenmesi yüklenemezse hata sayfasına yönlendirilir 
     require_once 'mySQL.php';
     class adres extends mySQL {
      	
         // tablo isminin tutuldugu değişken
         public $table;
      
         // yapılandırıcı metot
         function __construct()   {
     	        parent::__construct();
              $this->table = 'adres';
         }
     
         // ekleme metodu	
         public function ekle($adres,$baslik,$aciklama ){
           	if(isset($this->bag)){
        		     $sonuc = $this->bag->exec(" INSERT INTO $this->table 
        	                                      (`adres`, `baslik`, `aciklama`) 
        	                                      VALUES ('{$adres}','{$baslik}','{$aciklama}')");			  
        		    if ($sonuc) {
        			      return	$sonuc = $this->bag->lastInsertId();
        			  }
        			  else {
        				     return FALSE;
        		 	  }
        	  }
        	  else {	return -1; }
         }

         // güncelleme metodu 
         public function guncelle($pk,$adres,$aciklama ){
              if(isset($this->bag)){
                     $sonuc = $this->bag->exec(" UPDATE $this->table SET 
                                                    `adres`= '{$adres}',
                                                    `aciklama`='{$aciklama}'
                                                     WHERE pk = '{$pk}'");            
                    return $sonuc;
              }
              else {  return -1; }
         }
      
         // silme metodu 
         public function sil($pk ){
              if(isset($this->bag)){
                     $sonuc = $this->bag->exec(" DELETE FROM $this->table WHERE pk = '{$pk}'");            
                     return $sonuc;
              }
              else {  return -1; }
         }
         
         // baslığa göre adres getirir 
         public function adres_getir($baslik){
               if(isset($this->bag)){
           	         $sonuc = $this->bag->query(" SELECT * FROM $this->table 
           	                                          WHERE baslik = '{$baslik}'");		  
           	       	  if($sonuc)
           	       		{
           	       			return $sonuc->fetch();
           	       		}
           	       		else {
           	       			return false;
           	       		}	
           	   }
       	       else { return -1; }
         }
         
        // tek deger dondurur
        public function adres_getir2($id){
              if(isset($this->bag)){
                     $sonuc = $this->bag->query("SELECT a.*, am.musteri_fk  FROM $this->table as a
                                                 inner join `adres_musteri` as am on am.adres_fk = a.pk 
                                                  WHERE a.pk = '{$id}'");          
                      if($sonuc)
                      {
                          return $sonuc->fetch();
                      }
                      else {
                          return false;
                      }   
              }
              else { return -1; }
        }
             
        //  musteri ye ait olan adresleri döndürür
        public function musteri_adresleri($musteri_pk){
        	    if(isset($this->bag) && settype($musteri_pk,'int')){
                     $sonuc = $this->bag->query("SELECT  a.pk , a.baslik ,a.aciklama , a.adres, am.musteri_fk FROM adres as a
                                                 INNER JOIN adres_musteri as am ON a.pk = am.adres_fk 
                                                 WHERE am.musteri_fk = {$musteri_pk} ");
    	   	        if( $sonuc)
    	   	        {
    	   	        	return $sonuc->fetchAll();
    	   	        }
                  else {
    	                    return false;
                  }
    	        }
    	        else { return -1; }
        }
        
        // müşterinin ilk adresini getirir
        public function musterinin_ilk_adresi($musteri_pk){
                  if(isset($this->bag)){
       	     	         $sonuc = $this->bag->query("SELECT  a.pk , a.baslik ,a.aciklama , a.adres, am.musteri_fk FROM adres as a
                                                   INNER JOIN adres_musteri as am ON a.pk = am.adres_fk 
                                                   WHERE am.musteri_fk = {$musteri_pk} LIMIT 1 ");
       		             if( $sonuc){
       	  	               	return $sonuc->fetch();
       	  	           }
                       else {
       	                     return false;
       	              }
                 }
       	         else { return -1; }
         }
    }
?>