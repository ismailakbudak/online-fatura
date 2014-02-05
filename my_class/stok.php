
<?php
  
        require_once 'mySQL.php';
 
        class stok extends mySQL {
                       
                   // tablo isminin tutuldugu değişken
                   public $table;
                   
                   // yapılandırıcı metot
                   function __construct()   {
                        parent::__construct();
                        $this->table = 'stok';
                   } 
                  
                   // ekleme metodu  
                   public function ekle($sirket_fk,$urun_fk,$kullanici_fk,$musteri_fk,$urun_adet,$adet_birim,$birim_fiyat,$indirim,$islem,$tarih){
                        if(isset($this->bag)){
                               $sonuc = $this->bag->exec(" INSERT INTO $this->table 
                                                          (`sirket_fk`, `urun_fk`, `kullanici_fk`, `musteri_fk`, `urun_adet`, 
                                                          `adet_birim`, `birim_fiyat`, `indirim`, `islem`, `tarih`) 
                                                           VALUES ('{$sirket_fk}',
                                                           '{$urun_fk}',
                                                           '{$kullanici_fk}',
                                                           '{$musteri_fk}',
                                                           '{$urun_adet}',
                                                           '{$adet_birim}',
                                                           '{$birim_fiyat}',
                                                           '{$indirim}',
                                                           '{$islem}',
                                                           '{$tarih}')");            
                               return $sonuc;
                        }
                        else {  return -1; }
                   }
                   
                   
                   // stok miktarı için
                   function stok_kontrol($urun_kodu){
                         if(isset($this->bag)){
                             $sonuc = $this->bag->query("  SELECT  islem , Count(islem) as count, Sum(urun_adet) as miktar FROM `stok` as s
                                                           inner join urunler as u on u.pk = s.urun_fk
                                                           WHERE u.urun_kodu = '{$urun_kodu}'  
                                                           GROUP BY islem ");
                             if ($sonuc) {
                                 return  $sonuc->fetchAll();
                             }
                             else{
                                 return false;
                             }
                         }
                         else{ return -1; }
                   }

                   
                   
       }
   ?>