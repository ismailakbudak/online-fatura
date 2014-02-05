<?php
   
   session_start();
// Include the main TCPDF library (search for installation path).
   require_once '../config/sql.php';
   require_once ('../PDF/tcpdf_include.php');
     $mesaj = "";
   $fatura_pk = $_GET['fatura_pk']; 
   $pk =  $_GET['pk'];

   if (!$fatura_pk){
          $mesaj = 'Fatura bilgileri eksik geldi..';
          redirect('../fatura/detay.php?pk='.$fatura_pk.'&msj='.$mesaj);
   }
     
   try  
   { 
      $bag = new PDO($DSN,$hesap,$sifre);
      $bag->exec("SET NAMES utf8");
   
      $fatura = confirm_fetch( $bag->query("SELECT fd.*,md.musteri_unvan FROM `fatura_detay` AS fd 
                                          INNER JOIN `musteri_detay` AS md on md.pk = fd.musteri_fk  
                                          WHERE fd.pk = $fatura_pk"));
   if ( !$fatura ) 
        $mesaj = "Müşteri bilgileri eksik geldiği için işlem yapılamıyor..";
     
   $musteri_pk = $fatura['musteri_fk'];
   $musteri_adresi = confirm_fetch( $bag->query("SELECT  a.pk , a.baslik ,a.aciklama , a.adres, am.musteri_fk FROM adres as a
                                                      INNER JOIN adres_musteri as am ON a.pk = am.adres_fk 
                                                      WHERE am.musteri_fk = {$musteri_pk} LIMIT 1 ") );
  
   if ( !$musteri_adresi ) 
        $mesaj = "Müşteri adres bilgileri eksik geldiği için işlem yapılamıyor..";
    
   $fatura_detay_fk = $fatura['pk'];
   $urunler = confirm_fetch_all($bag->query(" SELECT f.* , u.kdv_orani FROM `fatura_urun` as f 
                                            INNER JOIN `urunler` as u ON u.urun_kodu = f.urun_kodu 
                                            WHERE fatura_detay_fk = $fatura_detay_fk"));
    
    $fatura_position =  confirm_fetch( $bag->query("SELECT * FROM `fatura_position` WHERE  `pk` = $pk"));
 
    $fatura_position_xy = confirm_fetch_all($bag->query("SELECT `fp`.*, `e`.`isim`, `e`.`database_name` FROM `fatura_position_xy` AS `fp`
                                                         INNER JOIN `element` AS `e` ON `fp`.`element_fk` = `e`.`pk`
                                                         WHERE `fp`.`fatura_position_fk` = '{$fatura_position['pk']}' "));
   if ( !$urunler ) 
        $mesaj = "Faturaya ait ürün bilgileri eksik geldiği için işlem yapılamıyor..";
          
     if ($mesaj != "") 
         redirect('../fatura/detay.php?pk='.$fatura_pk.'&msj='.$mesaj);     
     
   }
   catch(PDOException $ex){
         unset($this->bag);
   }

   // create new PDF document
   $pagelayout = array( ($fatura_position['width'] / 96) * 25.4, ($fatura_position['height'] / 96) * 25.4 );

   $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pagelayout, true, 'UTF-8', false);
   
   // set document information
   $pdf->SetCreator(PDF_CREATOR);
   $pdf->SetAuthor('İsmail AKBUDAK');
   $pdf->SetTitle('Fatura');
   $pdf->SetSubject('Fatura Projesi');
   $pdf->SetKeywords('İsmail AKBUDAK, Fatura');
   
   // remove default header/footer
   $pdf->setPrintHeader(false);
   $pdf->setPrintFooter(false);
   
   // set default monospaced font
   $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
   
   // set margins
   $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
   
   // set auto page breaks
   $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
   
   // set image scale factor
   $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
   
   // set some language-dependent strings (optional)
   if (@file_exists(dirname(__FILE__).'../PDF/lang/eng.php')) {
   	require_once(dirname(__FILE__).'../PDF/lang/eng.php');
   	$pdf->setLanguageArray($l);
   }
   
   $pdf->SetFont('dejavusans', '', 10, '', true);
   
   // Add a page
   // This method has several options, check the source code documentation for more information.
   $pdf->AddPage();

    // en başa yazdırcak
    $pdf->SetFillColor(211 ,211, 211); // Gri->128 128 128 - 211 211 211 // mavi- 240 ,255 ,255
/*       
    //$pdf->Rect(4, 40 , 96, 43 ,'F');
    $pdf->setXY(10,45);
    $pdf->Cell(14,4, $fatura['musteri_unvan'] , 0,1,'L');
    
    $pdf->setXY(60,45);
    $pdf->Cell(14,4, $fatura_position['pk'] .'-'. $fatura_position['width'] .'-'. $fatura_position['height'] 
                        .'-'. $fatura_position['dizayn_adi']  , 0,1,'L');
 */  
     $pdf->setXY(20,25);
     $pdf->Cell(14,4, count($fatura_position_xy) , 0,1,'L');

    foreach ($fatura_position_xy as $val) {
        
        $pdf->setXY( ($val['left'] / 96) * 25.4, ($val['top'] / 96) * 25.4 );
        $pdf->Cell(0,0,  $val['database_name']  , 0,1,'L');

    }
/*
    $add = $musteri_adresi['adres'];
    if(!strlen($add) < 54){
      
      $adres_alt = explode("\n", $musteri_adresi['adres']);
      $vektor_y = 50;
      foreach ($adres_alt as $val) {
         $pdf->setXY(10,$vektor_y);
	       $pdf->Cell(14,4,bosluk_sil($val), 0,1,'L');
	       $vektor_y += 5;
	    }
    }
    else{
       $pdf->setXY(10,50);
       $pdf->Cell(14,4,$add, 0,1,'L');
    }
    
    
  //  $pdf->Rect(140, 65 , 65, 10 ,'F');
    $pdf->setXY(180,67);
    $newDate = date("d-m-Y", strtotime($fatura['fatura_tarih']));
    $pdf->Cell(20,5, $newDate, 0,1,'L');
    
  //  $pdf->Rect(140, 75 , 65, 10 ,'F');
    $pdf->setXY(180,77);
    $pdf->Cell(20,5, $fatura['fatura_basim_tarihi'], 0,1,'L');
    
    
  //  $pdf->Rect(140, 85 , 65, 10 ,'F');
    $pdf->setXY(180,87);
    $newDate = date("d-m-Y", strtotime($fatura['fiili_sevk_tarihi']));
    $pdf->Cell(20,5, $newDate, 0,1,'L');
    
    
    
  //  $pdf->Rect(4, 86 , 96, 10 ,'F');
    $pdf->setXY(10,89);
    $pdf->Cell(20,5, $fatura['vergi_daire_no'], 0,1,'L');
    $pdf->setXY(62,89);  
    $pdf->Cell(20,5, $fatura['vergi_no'], 0,1,'L');
*/    
   /*
    $pdf->setXY(40,103);
    $pdf->Rect(4, 99 , 96, 13 ,'F');  
    $pdf->Cell(80,5,trsuz('Malın Cinsi'), 0,1,'L');
    $pdf->Rect(4, 115 , 96, 85 ,'F');
    
    $pdf->setXY(107,103);
    $pdf->Rect(103, 99 , 19, 13 ,'F');  
    $pdf->Cell(80,5,trsuz('Birim'), 0,1,'L');
    $pdf->Rect(103, 115 , 19, 85 ,'F');
    
    $pdf->setXY(129,103);
    $pdf->Rect(125, 99 , 19, 13 ,'F');  
    $pdf->Cell(80,5,trsuz('Miktar'), 0,1,'L');
    $pdf->Rect(125, 115 , 19, 85 ,'F');  
    
    $pdf->setXY(150,103);
    $pdf->Rect(147, 99 , 25, 13 ,'F');  
    $pdf->Cell(80,5, trsuz('Birim Fiyatı'), 0,1,'L');
    $pdf->Rect(147, 115 , 25, 85 ,'F');  
    
    $pdf->setXY(183,103);
    $pdf->Rect(175, 99 , 30, 13 ,'F');  
    $pdf->Cell(80,5, trsuz('Tutar'), 0,1,'L');
    $pdf->Rect(175, 115 , 30, 85 ,'F');  
  */
/*  
  
	$vektor_y = 118;
 
	foreach ($urunler as $urun) {
        $pdf->setXY( 10 , $vektor_y);
        $pdf->Cell(80,5, $urun['urun_adi'], 0,1,'L');
        
       $pdf->setXY(107,$vektor_y);
        $pdf->Cell(80,5, $urun['miktar_birim'], 0,1,'L');
         
        $pdf->setXY(129,$vektor_y);
        $pdf->Cell(80,5, $urun['miktar'], 0,1,'L');
        
        $pdf->setXY(150,$vektor_y);
        $pdf->Cell(80,5, $urun['birim_fiyati'], 0,1,'L');
        
        $pdf->setXY(120,$vektor_y);
        $pdf->Cell(80,5, number_format($urun['tutar'], 2, ',', ' '), 0,1,'R');
       
	    $vektor_y += 6;
	}
     
    $kdvsiz_top = number_format($fatura['kdvsiz_toplam_tutar'], 2, ',', ' ');
	$kdv = number_format($fatura['kdv_tutar'], 2, ',', ' ');
	$top = number_format($fatura['toplam_tutar'], 2, ',', ' ');
    $kdv_orani = kdv_orani_dondur($urun['urun_kodu'] , $bag);
   
    $pdf->Line(130, 202, 205, 202);
    $pdf->setXY(130,202);
    $pdf->Cell(80,5, "TOPLAM              ", 0,1,'L');
    $pdf->setXY(120,202);             
    $pdf->Cell(80,5, $kdvsiz_top, 0,1,'R');
   
    $pdf->setXY(130,209);
    $pdf->Cell(80,5, "%{$kdv_orani} KDV    ", 0,1,'L');
    $pdf->setXY(120,209);             
    $pdf->Cell(80,5, $kdv, 0,1,'R');
    $pdf->Line(130, 214, 205, 214);
     
    $pdf->setXY(130,216);
    $pdf->Cell(80,5, "GENEL TOPLAM ", 0,1,'L');
    $pdf->setXY(120,216);             
    $pdf->Cell(80,5, $top, 0,1,'R');
    $pdf->Line(130, 221, 205, 221);
    $pdf->Line(130, 222, 205, 222);
      
    
    $sayilar = explode(".",$fatura['toplam_tutar']);
    
    if(strlen($sayilar[1]) == 1 )
      $sayilar[1] = $sayilar[1] . "0";

    $yazi = "Yalnız/ ". sayiyi_yazi_yap($sayilar[0]) ."T.L." . sayiyi_yazi_yap($sayilar[1]) .'KURUŞ' ; 
    $pdf->setXY(10,209);
    $pdf->Cell(80,5, $yazi, 0,1,'L');
*/
    $isim = date("d-m-Y") ."--Fatura-no:". $fatura['fatura_no']; // pdf ismi
    $pdf->Output("$isim.pdf","I");

    unset($bag); 
?>




<?php
 // url değikebinde gelen değere göre yönlendirme yapar
function redirect($url='anasayfa.php'){
       
         echo "<script>
                  window.location = '{$url}';
	      </script>";
        exit();
}

function kdv_orani_dondur($urun_kodu , $bag){
	$urun = confirm_fetch( $bag->query("SELECT * FROM urunler WHERE urun_kodu = '{$urun_kodu}'"));
	
	if ($urun) {
	    return $urun['kdv_orani'];
	}
	else {
        $mesaj = "Ürün bilgileri çekilemediği için işlem yapılamıyor..";
	    redirect('../fatura/detay.php?pk='.$fatura_pk.'&msj='.$mesaj);  
     }
	 
}


// gelen sitringi türlçe yapar
 function bosluk_sil($str){
     $str=  preg_replace('/(?:(?:\r\n|\r|\n)\s*)/sim', "", $str);
     return $str;
  }

  // sonuc varsa fetch yapıp döndürür
  function confirm_fetch($sonuc){
        if ($sonuc) {
             return $sonuc->fetch();
        }
        else {
             return false;
        }
  }
  // sonuc varsa fetchAll() yapıp döndürür
  function confirm_fetch_all($sonuc){
        if ($sonuc) {
             return $sonuc->fetchAll();
        }
        else {
             return false;
        }
  }


/*sayiyi okuup yazı yapan metot*/

function sayiyi_yazi_yap($sayi){

settype($sayi , 'int');
$oku = "";
$bin_yaz = false;
while( strlen($sayi) > 0 && strlen($sayi) < 8 && $sayi != 0){ 

if(strlen($sayi) == 1){ 
    $oku .= rakam($sayi , 'rakam');
    $sayi = 0;
}
elseif(strlen($sayi) == 2){
    $oku .= sayi(floor($sayi/10));
    $sayi = $sayi%10;
    
}

elseif(strlen($sayi) == 3){ 
    $oku .= rakam(floor($sayi/100) ,"yuz") . "yüz";
    $sayi = $sayi%100;
}

elseif(strlen($sayi) == 4){
    if($bin_yaz && floor($sayi/1000) == 1){
        $oku .= "birbin";
        $bin_yaz = false;
    }
    else{
        $oku .= rakam(floor($sayi/1000) ,"bin") . "bin";
    }
    $sayi = $sayi%1000;
}

elseif(strlen($sayi) == 5){
    $val = $sayi%10000;
    if( floor($val/1000) == 0){
        $oku .= sayi(floor($sayi/10000)) . "bin";
    }
    else{
        $bin_yaz = true;
        $oku .= sayi(floor($sayi/10000)) ;        
    }
   $sayi = $sayi%10000;
}

elseif(strlen($sayi) == 6){ 
   $val = $sayi%100000;
   $ln = strlen($val);
   if($ln <= 3){
     $oku .= rakam(floor($sayi/100000) ,"yuz") . "yüzbin";
   }
   else{
      $bin_yaz = true;
      $oku .= rakam(floor($sayi/100000) ,"yuz") . "yüz";
   }
   $sayi = $sayi%100000;
}

elseif(strlen($sayi) == 7){ 
    $oku .= rakam(floor($sayi/1000000) ,"rakam") . "milyon";
    $sayi = $sayi%1000000;
}
 
 
}
if($oku == ""){
   $oku = "Okuyamadım :(";
}

  return $oku;



}

function rakam($rak, $rakam ){
    if($rak == 1){
        if($rakam == "rakam"){
           return "bir";
        }
        elseif($rakam == "yuz"){
            return "";
        }
        elseif($rakam == "bin"){
            return "";
        }   
    }
    elseif($rak == 2){
        return "iki";
    }
    
    elseif($rak == 3){
        return "üç";
    }
    
    elseif($rak == 4){
        return "dört";
    }
    
    elseif($rak == 5){
        return "beş";
    }
    
    elseif($rak == 6){
        return "altı";
    }
    
    elseif($rak == 7){
        return "yedi";
    }
    
    elseif($rak == 8){
        return "sekiz";
    }
    
    elseif($rak == 9){
        return "dokuz";
    }
    
    return "";
}


function sayi($sayi){
    if($sayi == 1){
        return "on";
    }
    
    elseif($sayi == 2){
        return "yirmi";
    }
    
    elseif($sayi == 3){
        return "otuz";
    }
    
    elseif($sayi == 4){
        return "kırk";
    }
    
    elseif($sayi == 5){
        return "elli";
    }
    
    elseif($sayi == 6){
        return "altmış";
    }
    
    elseif($sayi == 7){
        return "yetmiş";
    }
    
    elseif($sayi == 8){
        return "seksen";
    }
    
    elseif($sayi == 9){
        return "doksan";
    }
    
    return "";
}

?>
