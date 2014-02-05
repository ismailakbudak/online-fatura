<?php

     require_once 'mySQL.php';
     class kullanicilar extends mySQL {
           
           // tablo isminin tutuldugu değişken
          public $table;
           
           // yapılandırıcı metot
          function __construct()   {
            	parent::__construct();
                $this->table = 'kullanicilar';
          }
      
          // ekleme metodu	
          public function ekle($ad,$soyad,$kullanici_adi,$kullanici_sifre,$kullanici_yetki_fk){
                if(isset($this->bag)){
                	   $sonuc = $this->bag->exec(	" INSERT INTO $this->table 
               	      			( `ad`, `soyad`, `kullanici_adi`, `kullanici_sifre`, `kullanici_yetki_fk`) 
               	      			VALUES ('{$ad}','{$soyad}','{$kullanici_adi}','{$kullanici_sifre}','{$kullanici_yetki_fk}') ");		 
               	        return $sonuc ;
               	}
         	    else { return -1; }
          }
         
          // silme metodu
          public function sil( $where_value){
               	if(isset($this->bag)){
                       $sonuc = $this->bag->exec("DELETE FROM $this->table WHERE pk = '{$where_value}'");
                       return $sonuc ;
                }
            	else { return -1; }
           }         
         
            // güncelleme metodu
            public function guncelle($kul_pk,$ad,$soyad,$kul_ad, $kul_sifre, $yetki){
         	     if(isset($this->bag)){
         	          $sonuc = $this->bag->exec("UPDATE $this->table SET 
                                                                  `ad`='{$ad}',
                                                                  `soyad`='{$soyad}',
                                                                  `kullanici_adi`='{$kul_ad}',
                                                                  `kullanici_sifre`='{$kul_sifre}',
                                                                  `kullanici_yetki_fk`='{$yetki}' 
                                                                   WHERE pk='{$kul_pk}'");                             
                                return $sonuc ;
                  }
         	     else { return -1; }
            }         
         
            // tablodaki verileri dizi şeklinde döndüren metot
            public function listele(){
         	     if(isset($this->bag)){
         	           $sonuc = $this->bag->query("SELECT k.pk, k.ad,k.soyad,k.kullanici_adi, y.yetkisi
         	                                       FROM  kullanicilar as k 
         	                                       INNER JOIN kullanici_yetki as y ON k.kullanici_yetki_fk = y.pk");
         	          return $sonuc ;
                                }
         	     else { return -1; }
            }

            // kisi sorgulama
            public	function kisi_sorgula($kul_ad,$kul_sifre,$yetki){
                 if(isset($this->bag)){
         	                $sonuc = $this->bag->query("SELECT * FROM  kullanicilar as k 
         	                                            INNER JOIN kullanici_yetki as y ON k.kullanici_yetki_fk = y.pk
                                                        WHERE k.kullanici_adi = '{$kul_ad}' 
                                                        AND k.kullanici_sifre = '{$kul_sifre}' 
                                                        AND y.yetkisi = '{$yetki}'");
         	                if ($sonuc) {	
         		                return $sonuc->fetch();
         		            }
         		            else {
         		            	return FALSE;
         		            } 
                   }
                   else { return -1; }
            }

            //  kullanıcı paneline giriş için kullanıcı kayıtlı mı değil mi kontrol eder
            public    function kisi_sorgula_for_giris($kul_ad,$kul_sifre){
                      if(isset($this->bag)){
                           $sonuc = $this->bag->query("SELECT * FROM  kullanicilar 
                                                        WHERE kullanici_adi = '{$kul_ad}' 
                                                        AND kullanici_sifre = '{$kul_sifre}' ");
                          if ($sonuc) {   
                              return $sonuc->fetch();
                          }
                          else {
                              return FALSE;
                          } 
                      }
                      else { return -1; }
            }
            
            // kullanıcı adının kontrol edildiği metot
            public function kullanici_adi_kontrol($kul_ad){
                	if(isset($this->bag)){
         	               $sonuc = $this->bag->query("SELECT * FROM  kullanicilar
                                                                    WHERE kullanici_adi = '{$kul_ad}'");
         	                if ($sonuc) {	
         		                return $sonuc->fetch();
         		            }
         		            else {
         		            	return FALSE;
         		            } 
                      }
                   	  else { return -1; }
            }

            // kullanıcı geri döndüren metot
            public function kullanici_getir($kul_pk){
                     	if(isset($this->bag)){
         	                       $sonuc = $this->bag->query("SELECT k.pk, k.ad,k.soyad,k.kullanici_adi, k.kullanici_sifre,
         	                                                    k.kullanici_yetki_fk, y.yetkisi FROM  
         	                                                    kullanicilar as k 
         	                                                    INNER JOIN kullanici_yetki as y ON k.kullanici_yetki_fk = y.pk
                                                                WHERE k.pk = '{$kul_pk}'");
         	                        if ($sonuc) {	
         		                        return $sonuc->fetch();
         		                    }
         		                    else {
         		                    	return FALSE;
         		                    } 
                        }
                    	else { return -1; }
             }
         


       }         
 ?>