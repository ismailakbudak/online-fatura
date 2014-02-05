
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
   
   /*
   $s1 = $bag->exec("delete from okul where pk = 1");
   $s2 = $bag->exec("delete from okul where pk = 2");
     
    if( $s1 == false) or ($s2 == false) ){
        $bag->rollback();
        echo "hatalı işlem ve geri alındı";
     }
     else{
        $bag->commit();
        echo "islem başarılı";
    }
    */
    // stok için
    $kullanici_fk = $_SESSION['kullanici_ses'];
    /* Fatura urun için*/
    $urunler_data = $_GET['urunler_data'];
          
    // fatura detay için  
    $sirket_fk = $_SESSION['sirket_pk'];
    
    //olümcül veriler
    if (!$kullanici_fk || !$sirket_fk || !$urunler_data) {
         echo "<script> myClicktop('.hatali','Gerekli oturum bilgileri eksik geldiği için ekleme işlemi yapılamıyor..','UYARI') </script>";
         exit;
    }
   
   // post verileri
    $acik = $_POST['fatura_tipi'][0]; // 1 açık 0 kapalı   
    $fatura_no   = $_POST['fatura_no']; 
    $musteri_fk  = $_POST['musteri_fk'];
    $odeme_turu = $_POST['odeme_detay']; 
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
    
    $db_musteri = new musteri_detay();
    $musteri = $db_musteri->musteri_getir2($musteri_fk);
    if ($musteri) {
        $vergi_daire_no  =  $musteri['vergi_dairesi'];
        $vergi_no    =  $musteri['vergi_no'];   
    }
    
    if ( !$sirket_fk || !$kullanici_fk || !$fatura_no || !$musteri_fk || !$vergi_daire_no || !$vergi_no ||
        !$fatura_tarih || !$fatura_basim_tarihi || !$fiili_sevk_tarihi || !$kdv_tutar || 
        !$toplam_tutar || !$kdvsiz_toplam_tutar || !$toplamdan_iskonto_tutari || !$iskontadan_onceki_toplam) {
        echo "<script> myClicktop('.hatali','Fatura bilgileri eksik geldiği için ekleme işlemi yapılamıyor..','UYARI') </script>";
        exit();
    }
    
     // veri tabanına ekleme kısmı
     $db = new fatura_detay();
     $db = new fatura_detay();
     $fatura_pk = $db->ekle($musteri_fk,$odeme_turu, $fatura_tarih,
                            $aciklama, $acik, $fatura_basim_tarihi, 
                            $kdv_tutar, $toplam_tutar, $kdvsiz_toplam_tutar, 
                            $vergi_daire_no, $vergi_no, $toplamdan_iskonto_tutari,
                            $fiili_sevk_tarihi, $iskontadan_onceki_toplam, $fatura_no, $sirket_fk);
     if ($fatura_pk) {
        // Fatura urun için eklemek için 
        if ($urunler_data) {  
                // veri tabnı sınıfları               
                $db_fatura_urun = new fatura_urun();
                $db_urunler = new urunler();
                $db_stok = new stok();
                // urun verileri
                $urunler_dizi = parse_et($urunler_data);
                
                ekle( $bag, $urunler_dizi, $fatura_pk ,$sirket_fk ,$kullanici_fk ,$musteri_fk);
                // ekleme işlemi başarılı
                $bag->commit();
                echo "1";
                exit();
                
        }// urun_data var mı kontrol ediliyor
        else {
              //hata
              $bag->rollback();
              echo "<script> myClicktop('.hatali','Ürünlerin bilgileri eksik işlem yapılamıyor..','UYARI') </script>";
              exit();
        }
         
    }// fatura detay eklenmiş mi kontrol ediyor
    else {
          $bag->rollback(); 
          echo "<script> myClicktop('.hatali','Fatura eklenemedi','UYARI') </script>";
          exit();
    }
    
    // ekleme fonksiyonu
    function ekle($bag,$urunler_dizi , $fatura_detay_fk ,$sirket_fk,  $kullanici_fk, $musteri_fk  ){
        // veri tabnı sınıfları               
        $db_fatura_urun = new fatura_urun();
        $db_urunler = new urunler();
        $db_stok = new stok();
        
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
                          echo "<script> myClicktop('.hatali','{$mesaj}','UYARI'); </script>";
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
                                     echo "<script> myClicktop('.hatali','{$mesaj}','UYARI'); </script>";
                                     exit;
                                }               
                        }
                        else {
                            
			     $bag->rollback();
			     $mesaj = "Ürün bilgileri çekilirken sorun cıktı..";
                             echo "<script> myClicktop('.hatali','{$mesaj}','UYARI'); </script>";
                             exit;
                         }
        }// foreeach sonu eklemeler yapıldı  
      }
    
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
                                        'tutar'=> $tutar );
      }// for sonu
      return $urunler_dizi;
   } 
  
  
?>