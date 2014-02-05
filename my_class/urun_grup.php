<?php
       
       require_once 'mySQL.php';
       class urun_grup extends mySQL {
                  
              // tablo isminin tutuldugu değişken
              public $table;
              
              // yapılandırıcı metot
              function __construct()   {
                   parent::__construct();
                   $this->table = 'urun_grup';
              } 
              
              // ekleme metodu
              function ekle($sirket_fk , $grup_ismi){
                 if(isset($this->bag)){
                        /* Etkilenen satır sayısını  döndürür */
                        $sonuc = $this->bag->exec(" INSERT INTO $this->table 
                                                    ( `sirket_fk`, `grup_ismi`)  
                                                    VALUES ('{$sirket_fk}','{$grup_ismi}' )");            
                        return $sonuc;
                 }
                 else {  return -1; }
              }
              
               // güncelleme metodu
              function guncelle($grup_pk , $grup_ismi){
                 if(isset($this->bag)){
                        /* Etkilenen satır sayısını  döndürür */
                        $sonuc = $this->bag->exec(" UPDATE $this->table SET `grup_ismi`= '{$grup_ismi}'  
                                                    WHERE pk = '{$grup_pk}' ");            
                        return $sonuc;
                 }
                 else {  return -1; }
              }
              
               // silleme metodu
              function sil($grup_pk){
                 if(isset($this->bag)){
                        /* Etkilenen satır sayısını  döndürür */
                        $sonuc = $this->bag->exec(" DELETE FROM $this->table   
                                                    WHERE pk = '{$grup_pk}' ");            
                        return $sonuc;
                 }
                 else {  return -1; }
              }
              
              // şirkete ait grupları getirir
              function grup_getir_sirket_fk($sirket_fk){
                  if(isset($this->bag)) {
                        $sonuc = $this->bag->query(" SELECT * FROM $this->table 
                                                      WHERE sirket_fk = '$sirket_fk'");            
                        if($sonuc){
                            return  $sonuc->fetchAll();
                        }
                        else {
                            return FALSE;
                        }
                 }
                 else {  return -1; }
              }
           
              // pk ya  göre grubu getirir
              function grup_getir_grup_pk($grup_pk){
                  if(isset($this->bag)){
                        $sonuc = $this->bag->query(" SELECT * FROM $this->table 
                                                      WHERE pk = '$grup_pk'");            
                        if($sonuc){
                            return  $sonuc->fetch();
                        }
                        else {
                            return FALSE;
                        }
                 }
                 else {  return -1; }
              }
              // sayfalama için verileri grup grup çekiyor
              function grup_getir_for_sayfa($sirket_pk,$baslangic,$count){
                 if(isset($this->bag))
                 {
                        /* Etkilenen satır sayısını  döndürür */
                        $sonuc = $this->bag->query(" SELECT * FROM `urun_grup`
                                                     WHERE `sirket_fk` = '{$sirket_pk}'
                                                     ORDER BY `pk` DESC
                                                     LIMIT $baslangic,$count");            
                        if($sonuc){
                            return  $sonuc->fetchAll();
                        }
                        else {
                            return FALSE;
                        }
                 }
                 else {  return -1; }
              }
              
     

              
    }
   ?>