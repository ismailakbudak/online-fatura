<?php

//  sessionını kontrol eder eğer session varsa sayfaya yönlendirme yapmaz yok ise $url de gelen yere yönlendirir
function session_kontrol($url,$url_sir){
      session_start();
      if(!isset($_SESSION['kullanici_ses'])){
              $mesaj='Lütfen giriş yapınız..';
	          $url = $url.'.php?msj='.$mesaj;
              echo "<script>
                      window.location = '{$url}';
	                </script>";
	          exit;
      }
     if (!isset($_SESSION['sirket_pk'])) {
          $mesaj='Lütfen şirket seçiniz..';
          $url =$url_sir .'.php?msj='.$mesaj;
	       echo "<script>
                        window.location = '{$url}';
	             </script>";
	      exit;
     }
     /*
     if ( $_SESSION['time'] < time() - (10 * 60 )) {
         $url = $url_sir.'.php?msj=Uzun süre işlem yapmadığınız için oturum kapatıldı. Tekrar giriş yapınız..';
	     echo "<script>
                  window.location = '{$url}'
	           </script>";
	      exit();
     }
     */
     $_SESSION['time'] = time();
}
 // url değikebinde gelen değere göre yönlendirme yapar
function redirect($url='anasayfa.php'){
       
         echo "<script>
                  window.location = '{$url}';
	      </script>";
        exit();
}
 //  mesaj varsa gösterir
function mesaj_ver($msj=''){
    if ($msj != null && strcmp($msj, '') != 0) {
	echo "<script> myClick('.hatali','{$msj}','UYARI'); </script>";
    }
}
// kullancı adı ve şirket ismini gösterir
function mainInfo_dondur($kullanici_adi,$sirket_isim){
    $info = " <div id='mainInfo'>
                  <p > 
                     Sayın : <b> $kullanici_adi </b> işlem yaptığınız Şirket : <b> $sirket_isim </b>   
                 </p>
                 <p id='time' ></p> 
            </div>";
     return $info;                  
}
// gelen sitringi türlçe yapar
 function trsuz($str){
     $str=mb_convert_encoding($str, "ISO-8859-9","UTF-8");
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
$dondur = "";
if($oku == ""){
   $dondur = "Okuyamadım :(";
}
else{
   $dondur = "Yalnız/ ". $oku ."T.L. dir";
}
       return $dondur;
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









