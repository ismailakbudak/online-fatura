<?php

     require_once 'mySQL.php';

     class telefon extends mySQL {
           	
          // tablo isminin tutuldugu değişken
          public $table;
          
          // yapılandırıcı metot
          function __construct()   {
             	 parent::__construct();
               $this->table = 'telefon';
          }
          
          // ekleme metodu	
          public function ekle($adres_fk,$telefon,$faks ){
         	     if(isset($this->bag)){
                     $sonuc = $this->bag->exec(" INSERT INTO $this->table 
         	                                        (`adres_fk`, `telefon`, `faks`) 
         	                                        VALUES ('{$adres_fk}','{$telefon}','{$faks}')");
         	     	return $sonuc;			 
         	     }
         	     else  { return -1; }
          }
               
          // silme metodu   
          public function sil($adres_pk ){
               if(isset($this->bag)){
                    $sonuc = $this->bag->exec("DELETE FROM  $this->table 
                                               WHERE  adres_fk = {$adres_pk}");
                    return $sonuc;           
               }
               else  { return -1; }
          }
         
          // silme metodu   idye göre siler
          public function  sil_by_id($pk ){
               if(isset($this->bag)){
                    $sonuc = $this->bag->exec("DELETE FROM  $this->table 
                                               WHERE  pk = {$pk}");
                                                   
                    return $sonuc;           
                }
                else  { return -1; }
          }
           
          // güncelleme metodu   
          public function guncelle($pk,$telefon,$faks ){
                if(isset($this->bag)){
                     $sonuc = $this->bag->exec("UPDATE  $this->table SET 
                                                 `telefon`='{$telefon}',
                                                 `faks`= '{$faks}' 
                                                  WHERE  pk = {$pk}");
                      return $sonuc;           
                }
                else  { return -1; }
          }
          
           // telefon bilgilerini getiren  metod
          public function getir($adres_fk ){
                if(isset($this->bag)){
                      $sonuc = $this->bag->query(" SELECT * FROM  $this->table 
                                                   WHERE adres_fk = {$adres_fk}");
                      if($sonuc){
                          return $sonuc->fetchAll();
                      }
                      else {
                           return false;
                      }             
                }
                else  { return -1; }
          }
         
          // telefon bilgilerini ve musteri pk sını  getiren  metod
          public function getir_2($pk ){
                if(isset($this->bag)){
                    $sonuc = $this->bag->query(" SELECT t.*, am.musteri_fk  FROM $this->table as t 
                                                 inner join adres_musteri as am on am.adres_fk = t.adres_fk
                                                 WHERE t.pk =  {$pk}");
                     if($sonuc){
                          return $sonuc->fetch();
                      }
                      else {
                           return false;
                      }             
                }
                else  { return -1; }
          }
         
          
          
   }
?>