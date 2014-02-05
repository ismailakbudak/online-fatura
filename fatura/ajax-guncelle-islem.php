<?php
    error_reporting(0);
    session_start();
    require '../my_class/fatura_detay.php';
    require '../my_class/fatura_urun.php';
    require '../my_class/urunler.php';
    require '../my_class/stok.php';
    require '../my_class/musteri_detay.php';
    require '../config/sql.php';
    
   try	
   { 
      $bag = new PDO($DSN,$hesap,$sifre);
      $bag->exec("SET NAMES utf8");
   }
   catch(PDOException $ex)
   {
    	unset($bag);
   }
   $bag->beginTransaction();
     
     // stok için
    $kullanici_fk = $_SESSION['kullanici_ses'];
    /* Fatura urun için*/
    $urunler_data = $_GET['urunler_data'];
          
    // fatura detay için  
    $sirket_fk = $_SESSION['sirket_pk'];
    
    $fatura_pk = $_GET['fatura_pk'];
    
    //olümcül veriler
    if (!$kullanici_fk || !$sirket_fk || !$urunler_data || !$fatura_pk) {
         echo "<script> myClicktop('.hatali','Gerekli oturum bilgileri eksik geldiği için güncelleme işlemi yapılamıyor..','UYARI') </script>";
         exit;
    }
    
      // post verileri
    $acik = $_POST['fatura_tipi'][0]; // 1 açık 0 kapalı   
    $fatura_no   = $_POST['fatura_no']; 
    $musteri_fk  = $_POST['musteri_fk'];
    $odeme_turu = $_POST['odeme_detay'];
    
    
    $db_musteri = new musteri_detay();
    $musteri = $db_musteri->musteri_getir2($musteri_fk);
    if ($musteri) {
        $vergi_daire_no  =  $musteri['vergi_dairesi'];
        $vergi_no    =  $musteri['vergi_no'];   
    }
  
    $fatura_tarih =$_POST['fatura_tarihi'];
    $fatura_basim_tarihi =$_POST['fatura_basim_tarihi'];
    $fiili_sevk_tarihi = $_POST['fiili_sevk_tarihi'];
  
    // zorunlu olmayan hazır geliyo veriler
    $aciklama   =$_POST['aciklama'];
    $kdv_tutar =$_POST['kdv_tutar'];
    $toplam_tutar = $_POST['toplam_tutar'];
    $kdvsiz_toplam_tutar = $_POST['kdvsiz_toplam_tutar'];
    $toplamdan_iskonto_tutari = $_POST['toplamdan_iskonta_tutari'];
    $iskontadan_onceki_toplam = $_POST['iskontadan_onceki_toplam']; 
    
    if ( !$fatura_no || !$musteri_fk ||  !$vergi_daire_no || !$vergi_no ||
        !$fatura_tarih || !$fatura_basim_tarihi || !$fiili_sevk_tarihi || !$kdv_tutar || 
        !$toplam_tutar || !$kdvsiz_toplam_tutar || !$toplamdan_iskonto_tutari || !$iskontadan_onceki_toplam) {
        echo "<script> myClicktop('.hatali','Fatura bilgileri eksik geldiği için güncelleme işlemi yapılamıyor..','UYARI') </script>";
        exit;
    }
    
          // Fatura urun için eklemek için 
    if ($urunler_data) {   // başarılı ise 1 dönecek
                // veri tabnı sınıfları               
                $db_fatura_urun = new fatura_urun();
                $db_urunler = new urunler();
                $db_stok = new stok();
                
                $fatura_detay_fk = $fatura_pk;
                 
                 // eklenecek verileri
                 $urunler_dizi = parse_et($urunler_data);
                 
                 // update edilecekler
                 $urunler_dizi_update = array();
                 // silinecek veriler
                 $fatura_urunleri_ekli = $db_fatura_urun->fatura_urun_getir_by_fatura_detay_fk($fatura_detay_fk);
               
                 if ($fatura_urunleri_ekli || count($fatura_urunleri_ekli) == 0) {
                     
                      foreach ($fatura_urunleri_ekli as $key => $ekli ) {
                          
                           foreach ($urunler_dizi as $key2 => $value2) {
                                
                               if (strcmp( $ekli['pk'] ,$value2['fatura_urun_pk'])  == 0 ) {
                               
                                  $urunler_dizi_update[] = $urunler_dizi[$key2];
                                   
                                  unset($fatura_urunleri_ekli[$key]);
                                  unset($urunler_dizi[$key2]);   
                             }
                          }
                       }
                      
                      // güncelle  
                      if ( count($urunler_dizi_update) > 0 ) 
                         guncelle($bag,$urunler_dizi_update , $fatura_detay_fk , $sirket_fk , $kullanici_fk, $musteri_fk);
		      		 
                      // Ekle     
                      if ( count($urunler_dizi) > 0) 
                           ekle($bag,$urunler_dizi , $fatura_detay_fk,$sirket_fk,$kullanici_fk,$musteri_fk);
                      
		     // sil      
                      if ( count($fatura_urunleri_ekli) > 0) 
                           sil( $bag, $fatura_urunleri_ekli , $fatura_detay_fk,$sirket_fk,$kullanici_fk,$musteri_fk);
                                  
                        $db = new fatura_detay();
                        $satir_sayisi = $bag->exec("UPDATE `fatura_detay` SET 
                                                `musteri_fk`='{$musteri_fk}',
                                                `odeme_turu`='{$odeme_turu}',
                                                `fatura_tarih`='{$fatura_tarih}',
                                                `aciklama`='{$aciklama}',
                                                `acik`='{$acik}',
                                                `fatura_basim_tarihi`='{$fatura_basim_tarihi}',
                                                `kdv_tutar`='{$kdv_tutar}',
                                                `toplam_tutar`='{$toplam_tutar}',
                                                `kdvsiz_toplam_tutar`='{$kdvsiz_toplam_tutar}',
                                                `vergi_daire_no`='{$vergi_daire_no}',
                                                `vergi_no`='{$vergi_no}',
                                                `toplamdan_iskonto_tutari`='{$toplamdan_iskonto_tutari}',
                                                `fiili_sevk_tarihi`='{$fiili_sevk_tarihi}',
                                                `iskontadan_onceki_toplam`='{$iskontadan_onceki_toplam}',
                                                `fatura_no`='{$fatura_no}',
                                                `sirket_fk`='{$sirket_fk}'
                                                 WHERE pk = $fatura_pk"); 
						
		        if ($satir_sayisi || $satir_sayisi == 0) {
                             $bag->commit();
			     $mesaj = " Fatura güncelleme işlemi başarılı. ";
                        }
                        else{
			     $bag->rollback();
                             $mesaj = "Güncelleme yapılamadı..";
                        }
                        echo "<script> denemeDialog('{$mesaj}'); </script>";
                        exit; 
                  }
                 else {
                     echo "<script> denemeDialog('Faturaya ekli ürünler çekilemedi..'); </script>";
                 }    
    }
    
     enset($bag);
     
     
     //silme metodu
     function sil ($bag,$fatura_urunleri_ekli , $fatura_detay_fk,$sirket_fk,$kullanici_fk,$musteri_fk) {
         
         $db_fatura_urun = new fatura_urun();
         $db_stok = new stok();
 
         foreach ($fatura_urunleri_ekli as $urun) {
            
               $urun_kodu  = $urun['urun_kodu'];
               $urun_adi =  $urun['urun_adi'];
                     
               $miktar = $urun['miktar'];
               $birim_fiyati = $urun['birim_fiyati']; 
               $miktar_birim = $urun['miktar_birimi'];
               $iskonto_tutari = $urun['iskonto_tutari'];
               $tutar =  $urun['tutar'];
               $fatura_urun_pk = $urun['pk'];
			   
               // ekli olan urunun bilgilerini getirir 
               $fatura_urun_ekli = $db_fatura_urun->fatura_urun_getir_by_id($fatura_urun_pk);
	           
               if ($fatura_urun_ekli) {
            
                      $fark =  $fatura_urun_ekli['miktar'];
                      $fatura_urun_pk = $fatura_urun_ekli['pk'];
                      $islem = 1;
                      $sonuc = $db_fatura_urun->sil( $fatura_urun_pk);     
		     if( $sonuc ){
                                $satir += 1;
                                $urun_fk = $fatura_urun_ekli['urun_fk'];
                                $urun_adet = $fark;
                                $adet_birim = $fatura_urun_ekli['miktar_birim'];
                                $birim_fiyat = $urun['birim_fiyati'];
                                $indirim = $urun['iskonto_tutari'];
                                $tarih = date("Y-m-d"); // Geçerli sistem tarihini almak için   
                                $sonuc = $bag->exec(" INSERT INTO  `stok`
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
				if($sonuc){
				   // başarılı
				}
				else{
				   // başarısız
				    $bag->rollback();
                                    $mesaj = "Stok tablosuna ürün eklenirken hata oluştu..";
                                    echo "<script> denemeDialog('{$mesaj}'); </script>";
                                    exit;
				}
                       }
                       else {
			     $bag->rollback();
	                     $mesaj = "Fatura ürün silme işlemi başarısız! ";
                             echo "<script> denemeDialog('{$mesaj}'); </script>";
                             exit;
                        }             
                }
                else {
		    $bag->rollback();
               	    $mesaj = $urun_kodu. " Kodlu ürünün bilgileri çekilemedi!";
	            echo "<script> denemeDialog('{$mesaj}'); </script>";
                    exit;
              }
         } // foreeach sonu  
     }
     // ekleme fonksiyonu
     function ekle($bag,$urunler_dizi , $fatura_detay_fk ,$sirket_fk,  $kullanici_fk, $musteri_fk  ){
               // veri tabnı sınıfları               
                $db_fatura_urun = new fatura_urun();
                $db_urunler = new urunler();
                $db_stok = new stok();
               
                // ekleme sonucları             
                $eklenen_satir_sayisi_fatura_urun = 0;
                $eklenen_satir_sayisi_stok = 0;
                
       foreach ($urunler_dizi as $urun) {        
                    //   $urun['kdv_orani'] 
                     // fatura_urun tablosuna eklenecek veriler for içinde   
                     $urun_kodu  = $urun['urun_kodu'];
                     $urun_adi =  $urun['urun_adi'];
                     $miktar = $urun['miktar'];
                     $birim_fiyati = $urun['birim_fiyati']; 
                     $miktar_birim = $urun['miktar_birimi'];
                     $iskonto_tutari = $urun['iskonto_tutari'];
                     $tutar =  $urun['tutar'];
                     
                     $fatura_urun_satir = $bag->exec("INSERT INTO `fatura_urun`
	                                              ( `fatura_detay_fk`, `urun_kodu`, `urun_adi`, 
	                                                `miktar`, `birim_fiyati`, `miktar_birim`, 
	                                                `iskonto_tutari`, `tutar`) 
	                                               VALUES ( '{$fatura_detay_fk}' , '{$urun_kodu}' , '{$urun_adi}' , 
                                                                '{$miktar}' , '{$birim_fiyati}' , '{$miktar_birim}' , 
                                                                 '{$iskonto_tutari}' , '{$tutar}' )");
                     
                     if ($fatura_urun_satir) {
                         $eklenen_satir_sayisi_fatura_urun += 1;
                      }
                      else {
			  $bag->rollback();
			  $mesaj = "Fatura ürün tablosuna eklemede sorun cıktı..";
                          echo "<script> denemeDialog('{$mesaj}'); </script>";
                          exit;
		      }
                      $gelen_urun = $db_urunler->urun_getir_urunkodu($urun_kodu);
                      // urun gelmezse
                      if ($gelen_urun) {
                               // $sirket_fk  //var  
                                $urun_fk = $gelen_urun['pk'];
                                // $kullanici_fk //var 
                                // $musteri_fk  //var
                                $urun_adet = $urun['miktar'];
                                $adet_birim = $urun['miktar_birimi'];
                                $birim_fiyat = $urun['birim_fiyati'];
                                $indirim = $urun['iskonto_tutari'];
                                $islem = 0;
                                $tarih = date("Y-m-d"); // Geçerli sistem tarihini almak için 
                                
                                $stok_satir = $bag->exec(" INSERT INTO  `stok`
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
                       
                                if ($stok_satir) {
                                     $eklenen_satir_sayisi_stok += 1;
                                }
                                else {
			             $bag->rollback();
			             $mesaj = "Stok tablosuna eklemede sorun cıktı..";
                                     echo "<script> denemeDialog('{$mesaj}'); </script>";
                                     exit;
                                }               
                        }
                        else {
                            
			     $bag->rollback();
			     $mesaj = "Ürün bilgileri çekilirken sorun cıktı..";
                             echo "<script> denemeDialog('{$mesaj}'); </script>";
                             exit;
                         }
                 }// foreeach sonu eklemeler yapıldı  
      }
     // güncelleme fonksiyonu
     function guncelle($bag,$urunler_dizi_update , $fatura_detay_fk ,$sirket_fk,  $kullanici_fk, $musteri_fk  ) {
          
           $db_fatura_urun = new fatura_urun();
           $db_stok = new stok();
           $mesaj = "";
           $satir = 0 ;
           $satir_stok = 0;
           
           foreach ($urunler_dizi_update as $urun) { 
                     
               $urun_kodu  = $urun['urun_kodu'];
               $urun_adi =  $urun['urun_adi'];
                     
               $miktar = $urun['miktar'];
               $birim_fiyati = $urun['birim_fiyati']; 
               $miktar_birim = $urun['miktar_birimi'];
               $iskonto_tutari = $urun['iskonto_tutari'];
               $tutar =  $urun['tutar'];
               $fatura_urun_pk =  $urun['fatura_urun_pk'];
               
               // ekli olan urunun bilgilerini getirir 
               $fatura_urun_ekli = $db_fatura_urun->fatura_urun_getir_by_id($fatura_urun_pk);
               if ($fatura_urun_ekli) {
                      
                      $fark =  $miktar - $fatura_urun_ekli['miktar'];
                      $fatura_urun_pk = $fatura_urun_ekli['pk'];
               
                      $islem = 0;
                      if ($fark == 0) { // miktar değişmedi stok işlem yok
                        
                      }  
                      elseif ($fark > 0) { // mikar artti stoga işlem = 0 olarak fark ekle 
                         $islem = 0;
                      }
                      else { // mikar artti stoga işlem = 1 olarak fark ekle
                        $fark = $fark * -1;
                        $islem = 1; 
                      }
                      $sonuc = $bag->exec("UPDATE `fatura_urun` SET 
                                           `fatura_detay_fk`='{$fatura_detay_fk}',
                                           `urun_kodu`='{$urun_kodu}',
                                           `urun_adi`='{$urun_adi}',
                                           `miktar`='{$miktar}',
                                           `birim_fiyati`='{$birim_fiyati}',
                                           `miktar_birim`='{$miktar_birim}',
                                           `iskonto_tutari`='{$iskonto_tutari}',
                                           `tutar`='{$tutar}'
                                           WHERE pk = $fatura_urun_pk");
                      if ($sonuc || $sonuc == 0) {
                          $satir += 1;
                      }
                      else {
			    $bag->rollback();
			    $mesaj = "Fatura ürünleri tablosunu güncellemede hata oluştu..";
	                    echo "<script> denemeDialog('{$mesaj}'); </script>";
                            exit;	       
	               }
                      if ($fark != 0) { 
                                $urun_fk = $fatura_urun_ekli['urun_fk'];
                                $urun_adet = $fark;
                                $adet_birim = $urun['miktar_birimi'];
                                $birim_fiyat = $urun['birim_fiyati'];
                                $indirim = $urun['iskonto_tutari'];
                                $tarih = date("Y-m-d"); // Geçerli sistem tarihini almak için   
                                $sonuc = $bag->exec(" INSERT INTO `stok` 
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
                            if ($sonuc) {
                                $satir_stok += 1;
                            }
			   else {
			          // stoka ekleem yapılamadı
			          $bag->rollback();
				  $mesaj = " Stok tablosuna ekleme yapılamadı!.	";
                                  echo "<script> denemeDialog('{$mesaj}'); </script>";
                                  exit;
     			}
                      }                             
               }
               else{
	             // ürün bilgileri çekilemedi
	               $bag->rollback();
		       $mesaj = $urun_kodu. " Kodlu ürünün bilgileri çekilemedi!";
	               echo "<script> denemeDialog('{$mesaj}'); </script>";
                       exit;
               }
       }
     
} // function  
     
       // gelendiziyi parçalayıp geri döndürüyor
     function parse_et($urunler_data)
     {
         $urunler_dizi = array();
         $urunler = explode("||",$urunler_data);
         for ($i=0; $i < count($urunler) -1 ; $i++) {
                
                     $data =  explode("é",$urunler[$i]);
                     $urun_kodu = $data[0];
                     $urun_adi = $data[1];
                     $miktar = $data[2];
                     $birim_fiyati = $data[3];
                     $miktar_birimi = $data[4];
                     $iskonto_tutari = $data[5];
                     $kdv_orani = $data[6];
                     $fatura_urun_pk = $data[7];
                     $number = ($birim_fiyati * $miktar * $kdv_orani / 100) + ($birim_fiyati * $miktar) -$iskonto_tutari;
                     $tutar = money_format('%.2n', $number);
              
                    // tük lirası olur number_format($number, 2, ',', '.');
              
                     $urunler_dizi[$i] =  array('urun_kodu' => $urun_kodu,
                                        'urun_adi' => $urun_adi,
                                        'miktar' => $miktar,
                                        'birim_fiyati' => $birim_fiyati,
                                        'miktar_birimi' => $miktar_birimi,
                                        'iskonto_tutari' => $iskonto_tutari,
                                        'kdv_orani'=> $kdv_orani,
                                        'tutar'=> $tutar,
                                        'fatura_urun_pk'=> $fatura_urun_pk );
      }// for sonu
      return $urunler_dizi;
  }
     


 
?>