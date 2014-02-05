<?php

     require_once 'mySQL.php';
     class kullanici_sirket extends mySQL {

           // tablo isminin tutuldugu değişken
           public $table;
            
            // yapılandırıcı metot
            function __construct()   {
                  parent::__construct();
                 $this->table = 'kullanici_sirket';
            }
            
            // ekleme metodu 
            public function ekle($kullanici_fk,$sirket_fk ){
                 if(isset($this->bag))
                 {
                        /* Etkilenen satır sayısını  döndürür */
                        $sonuc = $this->bag->exec(" INSERT INTO $this->table 
                                                    (`kullanici_fk`, `sirket_fk`) 
                                                    VALUES ($kullanici_fk , $sirket_fk ) ");            
                        return $sonuc;
                 }
                 else {  return -1; }
            }
            
            //  Silme işlemini yapan metot
            public function sil( $pk){     
                  if(isset($this->bag)){
                            $sonuc = $this->bag->exec("DELETE FROM $this->table WHERE pk = '{$pk}'");
                            return $sonuc ;
                  }
                  else { return -1; }
            }
            
            //  güncelleme metodu
            public function guncelle($update, $update_value , $pk ){
                  if(isset($this->bag)){
                      $sonuc = $this->bag->exec("UPDATE $this->table 
                                                SET $update='{$update_value}' 
                                                WHERE pk='{$pk}'");
                      return $sonuc ;
                  }
                 else { return -1; }
            }
        
            //  kullanici_fk ve sirket_fk ya göre olan verileri döndürür
            public function getir($kullanici_fk, $sirket_fk){
                if(isset($this->bag)){
                     $sonuc = $this->bag->query(" SELECT * FROM $this->table
                                                  WHERE kullanici_fk = $kullanici_fk and sirket_fk = $sirket_fk");
                     return $sonuc; 
                 }
                 else {  return -1; }
            }
            
            //  pk ya göre olan veriyi döndürür
            public function getir2($pk){
                 if(isset($this->bag)){
                     $sonuc = $this->bag->query(" SELECT * FROM $this->table  WHERE pk = $pk ");
                     return $sonuc; 
                  }
                  else {  return -1; }
            }
            
            //  kullanıcı_fk ya göre olan Şirketleri döndürür
            public function getir_by_kullanici($kullanici_pk){
                   if(isset($this->bag)){
                          $sonuc = $this->bag->query(" SELECT s.* FROM $this->table as ks  
                                                       INNER JOIN sirket_detay as s on s.pk = ks.sirket_fk   
                                                      WHERE kullanici_fk = $kullanici_pk");
                          if ($sonuc) {   
                               return $sonuc->fetchAll();
                           }
                           else {
                               return FALSE;
                           } 
                   }
                   else {  return -1; }
            }
            
           // kullanicinin ve şirketin fk sına göre olan degeri döndüren metot
           public function kullanici_bilgileri_getir($kullanici_pk , $sirket_pk){
                   if(isset($this->bag)){
                        $sonuc = $this->bag->query(" SELECT ks.pk, k.kullanici_adi, s.sirket_isim 
                                                     FROM $this->table as ks
                                                     inner join kullanicilar as k on k.pk = ks.kullanici_fk
                                                     inner join sirket_detay as s on s.pk = ks.sirket_fk
                                                     where  k.pk = {$kullanici_pk} and s.pk = {$sirket_pk}
                                                     ");
                         if ($sonuc) {   
                             return $sonuc->fetch();
                         }
                         else {
                             return FALSE;
                         } 
                     }
                    else {  return -1; }
           }
            
            // listeleme yapan metot
           public function listele(){
                    if(isset($this->bag)){
                         $sonuc = $this->bag->query(" SELECT ks.pk, k.kullanici_adi, s.sirket_isim 
                                                      FROM $this->table as ks
                                                      inner join kullanicilar as k on k.pk = ks.kullanici_fk
                                                      inner join sirket_detay as s on s.pk = ks.sirket_fk");
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