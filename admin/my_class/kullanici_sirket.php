<?php

/* 
 *  Gerekli dosyaların yüklenmesi yüklenemezse hata sayfasına yönlendirilir
 */
 $sonuc = include_once 'mySQL.php';
 if (!$sonuc) {
     return false;
 } 
   
/**
 *  kullanici_sirket tablosunda işlem yapan sınıf
 */
 class kullanici_sirket extends mySQL {


  // tablo isminin tutuldugu değişken
 public $table;
 
 // yapılandırıcı metot
 function __construct()   {
    parent::__construct();
    $this->table = 'kullanici_sirket';
 }
 
/**
  * ekleme metodu   
  */ 
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
    /**
   *  Silme işlemini yapan metot
   */
 public function sil( $pk){     
    if(isset($this->bag)){
              $sonuc = $this->bag->exec("DELETE FROM $this->table WHERE pk = '{$pk}'");
              return $sonuc ;
    }
    else { return -1; }
}
 /**
  *  güncelleme metodu
  */
 public function guncelle($update, $update_value , $pk ){
    if(isset($this->bag)){
       $sonuc = $this->bag->exec("UPDATE $this->table 
                                  SET $update='{$update_value}' 
                                  WHERE pk='{$pk}'");
        return $sonuc ;
    }
    else { return -1; }
}


/**
 *  kullanici_fk ve sirket_fk ya göre olan verileri döndürür
 */
 public function getir($kullanici_fk, $sirket_fk){
    if(isset($this->bag)){
       $sonuc = $this->bag->query(" SELECT * FROM $this->table
                                    WHERE kullanici_fk = $kullanici_fk and sirket_fk = $sirket_fk");
       return $sonuc; 
    }
   else {  return -1; }
 }
 
 /**
 *  pk ya göre olan veriyi döndürür
 */
 public function getir2($pk){
    if(isset($this->bag)){
       $sonuc = $this->bag->query(" SELECT * FROM $this->table  WHERE pk = $pk ");
       
       return $sonuc; 
    }
   else {  return -1; }
 }
 
 // sayfalama için
 function kullanici_sirketleri_getir_for_sayfa($baslangic,$count){
 	 if(isset($this->bag)){
        $sonuc = $this->bag->query("SELECT ks.pk, k.kullanici_adi, s.sirket_isim 
                                    FROM $this->table as ks
                                    inner join kullanicilar as k on k.pk = ks.kullanici_fk
                                    inner join sirket_detay as s on s.pk = ks.sirket_fk 
                                    ORDER BY pk DESC
                                    LIMIT $baslangic,$count ");                  
        if($sonuc){
            return $sonuc->fetchAll();
        }
        else {
            return false;
        }
    }
    else { return -1;}
 	
 }
 
 /**
  * listeleme yapan metot
  */
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