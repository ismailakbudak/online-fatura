<?php

     require_once 'mySQL.php';
     class urunler extends mySQL {
               
           // tablo isminin tutuldugu değişken
           public $table;
           
           // yapılandırıcı metot
           function __construct()   {
                parent::__construct();
                $this->table = 'urunler';
           } 
           
           // ekleme metodu  
           public function ekle($grup_fk, $urun_kodu, $urun_ismi, $sinirsiz_stok, $kritik_seviye, $kdv_orani, $aciklama ){
              if(isset($this->bag)){
                     $sonuc = $this->bag->exec(" INSERT INTO $this->table 
                                                 (`grup_fk`, `urun_kodu`, `urun_ismi`, `sinirsiz_stok`, `kritik_seviye`, `kdv_orani`, `aciklama`) 
                                                 VALUES ('{$grup_fk}',
                                                 '{$urun_kodu}',
                                                 '{$urun_ismi}',
                                                 '{$sinirsiz_stok}',
                                                 '{$kritik_seviye}',
                                                 '{$kdv_orani}',
                                                 '{$aciklama}')");            
                     return $sonuc;
              }
              else {  return -1; }
           }
           
           // güncelleme metodu
           public function guncelle($urun_pk, $grup_fk, $urun_kodu, $urun_ismi, $sinirsiz_stok, $kritik_seviye, $kdv_orani, $aciklama ){
              if(isset($this->bag)){
                     $sonuc = $this->bag->exec("  UPDATE $this->table  SET
                                                 `grup_fk`= '{$grup_fk}',
                                                 `urun_kodu`= '{$urun_kodu}',
                                                 `urun_ismi`='{$urun_ismi}',
                                                 `sinirsiz_stok`= '{$sinirsiz_stok}',
                                                 `kritik_seviye`='{$kritik_seviye}',
                                                 `kdv_orani`= '{$kdv_orani}',
                                                 `aciklama`='{$aciklama}' 
                                                  WHERE  pk = '{$urun_pk}' ");
                     return $sonuc;
              }
              else {  return -1; }
           }
         
           // silme metodu  
           public function  sil($urun_pk) {
              if(isset($this->bag)){
                     $sonuc = $this->bag->exec(" DELETE FROM $this->table 
                                                 WHERE PK = {$urun_pk}");            
                     return $sonuc;
              }
              else {  return -1; }
           }
           
           // parametrede gelen değerdeki ürünleri döndürür  
           public function  urun_getir_sirket_pk($sirket_pk){
              if(isset($this->bag)){
                     $sonuc = $this->bag->query("  SELECT u.* , ug.sirket_fk FROM $this->table  as u 
                                                   INNER JOIN `urun_grup` as ug on ug.pk = u.grup_fk
                                                   WHERE ug.sirket_fk = '$sirket_pk'");            
                     if($sonuc){
                         return  $sonuc->fetchAll();
                     }
                     else {
                         return FALSE;
                     }
              }
              else {  return -1; }
           }    
          
          // sayfalama için belli sayıda veri döndürür
          function urun_getir_for_sayfa($sirket_pk,$baslangic,$count){
                 if(isset($this->bag)){
                     $sonuc = $this->bag->query("  SELECT u.* , ug.sirket_fk FROM $this->table  as u 
                                                   INNER JOIN `urun_grup` as ug on ug.pk = u.grup_fk
                                                   WHERE ug.sirket_fk = '{$sirket_pk}'
                                                   ORDER BY u.pk DESC
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
          
          // URUN İSMİ VE ŞİRKEETE GÖRE GETİRİR
          function urun_getir_sirket_pk_ve_isim($sirket_pk,$urun_isim){
          	 if(isset($this->bag)){
                     $sonuc = $this->bag->query("  SELECT u.* , ug.sirket_fk FROM $this->table  as u 
                                                   INNER JOIN `urun_grup` as ug on ug.pk = u.grup_fk
                                                   WHERE ug.sirket_fk = '$sirket_pk' AND u.urun_ismi like '{$urun_isim}%'");            
                     if($sonuc){
                         return  $sonuc->fetchAll();
                     }
                     else {
                         return FALSE;
                     }
              }
              else {  return -1; }
          }
             
           // parametrede gelen değerdeki ürünleri döndürür  
           public function  urun_getir_urun_pk($urun_pk){
              if(isset($this->bag)){
                     $sonuc = $this->bag->query(" SELECT * FROM $this->table 
                                                   WHERE pk = '$urun_pk'");            
                     if($sonuc){
                         return  $sonuc->fetch();
                     }
                     else {
                         return FALSE;
                     }
              }
              else {  return -1; }
           }   
              
           // parametrede gelen değerdeki ürünleri döndürür  
           public function  urun_getir_urunkodu($urun_kodu){
              if(isset($this->bag)){
                     $sonuc = $this->bag->query(" SELECT * FROM $this->table 
                                                   WHERE urun_kodu = '$urun_kodu'");            
                     if($sonuc){
                         return  $sonuc->fetch();
                     }
                     else {
                         return FALSE;
                     }
              }
              else {  return -1; }
           }    
               
               
    
               
               
    }
  ?>