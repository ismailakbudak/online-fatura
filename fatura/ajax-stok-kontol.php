<?php
    error_reporting(0);
   require_once '../my_class/stok.php';
   require_once '../my_class/urunler.php'; 
   $urun_kodu = $_GET['urun_kodu'];
   $miktar = $_GET['miktar'];
    
    if (!$urun_kodu || !$miktar) {
        echo "0&Stok kontrolünde hata oluştu. Ürün ekleyemezsiniz..";
    }
    else {
        $db= new urunler();
        $urun = $db->urun_getir_urunkodu($urun_kodu);
      
        if($urun){
          if ( $urun['sinirsiz_stok'] == "1" ) {
              echo "1&Bu üründen sınırsız stokta bulunmakta.";
          }
          else if ($urun['sinirsiz_stok'] == "0") {
               $db = new stok();
               $stoklar = $db->stok_kontrol($urun_kodu);
              
               if ($stoklar) {
                   $stok = array();
                   foreach ($stoklar as $row) {
                       $stok[] = array('islem'=>$row['islem'],'miktar'=>$row['miktar']); 
                   }
                   // stoka eklenen
                   $al = 0;   
                   //stoktan cıkan
                    $sat =0;
                   
                   if (count($stok) == 2){
                       if ($stok[0]['islem'] == 0) {
                          $sat = $stok[0]['miktar'];
                          $al = $stok[1]['miktar']; 
                       }
                       else{
                       	  $sat = $stok[1]['miktar'];
                          $al = $stok[0]['miktar'];
                       }
                    }
                    elseif (count($stok) == 1) {
                       if ($stok[0]['islem'] == 0) {
                          $sat = $stok[0]['miktar'];
                          $al = 0; 
                       }
                       else{
                          $sat = 0;
                          $al = $stok[0]['miktar'];
                       }
                     }
                     else {
                         echo "0&Ürün stok kontrolünde hata oluştu. Ekleme yapılamıyor.";
                     }
                     
                     $sonuc = $al- $sat;
                     $sonuc2 =  $al- ($sat + $miktar);  
                     if ($sonuc2 > 0) {
                         if ($sonuc2 < $urun['kritik_seviye'] ) {
                             echo "1& Bu işlem ile ürün miktarı kritik seviyenin altına düştü. Güncel stok : {$sonuc } " . 
                                  "   Yeni stok  : {$sonuc2}  " ; 
                         }
                         else {
                              echo "1& Güncel stok : {$sonuc } " . 
                                  "    Yeni stok  : {$sonuc2}" ;
                         }         
                     }
                     else{
                         echo "2& Stok eksilere düştü güncel stok : {$sonuc } " . 
                             "   işlem yapılırsa stok : {$sonuc2}  olacak. Onaylıyor musunuz? " ;
                     }
                           
                 }   
                 else {
                      echo "2&Ürün stoklarda yok ve işlem yapılırsa ürün için toplam stok : -" . $miktar ."  olacak. Onaylıyor musunuz?";
                 }   
          }
          else {
              echo "0&Ürün stok kontrolünde hata oluştu. Ekleme yapılamıyor.";
          } 
        }
        else {
            echo "0&Ürün stok kontrolünde hata oluştu. Ekleme yapılamıyor.";
        }
    }
    
?>