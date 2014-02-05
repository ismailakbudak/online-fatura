<?php
      session_start();
      require '../include/function.php';
      require '../my_class/fatura_detay.php';
      require '../my_class/fatura_urun.php';
      require '../my_class/urunler.php';
      require '../my_class/stok.php';
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

      $db_fatura_urun = new fatura_urun();
      $db_fatura_detay = new fatura_detay();
   
    
      $fatura_pk = $_GET['pk'];      
      $fatura_detay = $db_fatura_detay->fatura_getir_by_id($fatura_pk);
      $fatura_urunleri_ekli = $db_fatura_urun->fatura_urun_getir_by_fatura_detay_fk($fatura_pk);
      if( !$fatura_pk || !$fatura_detay)
          redirect('../anasayfa.php?page=faturalar&msj=Fatura bilgileri eksik geldi..');    
      
      $kullanici_fk = $_SESSION['kullanici_ses'];
      $sirket_fk = $_SESSION['sirket_pk'];
      $musteri_fk = $fatura_detay['musteri_fk'];
      
      // silme işlemleri yapılıyor
      sil ($bag, $fatura_urunleri_ekli , $fatura_pk, $sirket_fk, $kullanici_fk, $musteri_fk);
      
      $satir_sayisi = $bag->exec("DELETE FROM `fatura_detay` WHERE pk = $fatura_pk");
      if($satir_sayisi > 0){
         $mesaj = "Fatura başarılı bir şekilde silindi..";
         $bag->commit();
      }
      else {
         $mesaj = "Silme işlemi başarısız..";
         $bag->rollBack();
      }
      
     redirect('../anasayfa.php?page=faturalar&msj='.$mesaj);

     
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
				    $bag->rollBack();
                                    redirect('../anasayfa.php?page=faturalar&msj=Stok tablosuna eklemede sorun çıktı..');    
                                    exit;
				}
                       }
                       else {
			     $bag->rollback();
	                     $mesaj = "Fatura ürün silme işlemi başarısız! ";
                             redirect('../anasayfa.php?page=faturalar&msj=' . $mesaj);    
                             exit;
                        }             
                }
                else {
		    $bag->rollBack();
               	    $mesaj = $urun_kodu. " Kodlu ürünün bilgileri çekilemedi!";
                    redirect('../anasayfa.php?page=faturalar&msj=' . $mesaj);    
                    exit;
              }
         } // foreeach sonu  
     }

?>