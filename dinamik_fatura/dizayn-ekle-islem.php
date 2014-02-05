<?php
   
   error_reporting(0);
   session_start();
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
   
   $sirket_fk = $_SESSION['sirket_pk'];
   $veri = $_GET['veri'];
   $height   = $_POST['height']; 
   $width  = $_POST['width'];
   $dizayn_adi = $_POST['dizayn_adi'];
   $fatura_tur_fk = $_POST['fatura_tur'];
   $uzunluk = $_POST['uzunluk'];
   
   if( $sirket_fk && $veri && $width && $height && $dizayn_adi && $fatura_tur_fk && $uzunluk){
        
       $elements = parse_et($veri);
       if($uzunluk == 2){
          $width = $width * 37.79;
          $height = $height * 37.79;
       }

       $sonuc = $bag->exec("INSERT INTO `fatura_position`(`sirket_fk`, `fatura_tur_fk`, `dizayn_adi`, `width`, `height` ) 
                            VALUES ('{$sirket_fk}','{$fatura_tur_fk}','{$dizayn_adi}','{$width}','{$height}' ) "); 
       if($sonuc){

            $fatura_position_fk = $bag->lastInsertId();
            if($fatura_position_fk){
                 
                 if( ekle_elements($bag,$elements,$fatura_position_fk) ) {
                    // Succesfull
                    $bag->commit(); 
                    $mesaj = "Ekleme işlemi başarılı..";
                    echo "1";
                    
                }
                 else{
                     // Unsuccesfull 
                     $bag->rollback();
                     $mesaj = "İşlem Başarısız..  Fatura elemanları eklenirken hata oluştu...";
                     echo "<script> mesaj('.hatali','{$mesaj}','SONUÇ'); </script>";
                 }                 
            }
            else{
                // Unsucesfull 
                $bag->rollback();
                $mesaj = "İşlem Başarısız.. Son eklenen verinin bilgilerinde hata oluştu..";
                echo "<script> mesaj('.hatali','{$mesaj}','SONUÇ'); </script>";            
            }     
        }
        else{
          // Mistake
          $bag->rollback();
          $mesaj = "İşlem Başarısız.. Fatura verileri eklenirken sorun oluştu.. Aynı ismi kullanmadığınıza dikkat edin...";
          echo "<script> mesaj('.hatali','{$mesaj}','SONUÇ'); </script>";
       }
     }
     else{
        // Mistake Some Data are missed
          $mesaj = "İşlem Başarısız..  Bazı veriler eksik...";
          echo "<script> mesaj('.hatali','{$mesaj}','SONUÇ'); </script>";
     }
     
     function ekle_elements($bag , $elements, $fatura_position_fk){
          
          for ($i=0; $i < count($elements); $i++) { 
              
              $element_fk =  $elements[$i]['id'];
              $left = $elements[$i]['left'];
              $top = $elements[$i]['top'];
              $sonuc =  $bag->exec(" INSERT INTO `fatura_position_xy`( `fatura_position_fk`, `element_fk`, `left`, `top`) 
                                     VALUES ( '{$fatura_position_fk}','{$element_fk}','{$left}','{$top}' )   ");
               if ($sonuc) {
                 // Succesfull
               }
               else{
                  // Unsuccesfull
                  return false; 
               }
          }
          return true;
     }

     function parse_et($veri){
         $elements = array();
         $str = explode("/", $veri);
         for ($i=0; $i < count($str); $i++) { 
            $str2 = explode("*", $str[$i]);
              $elements[$i] =  array('id' => $str2[0] ,'left' => $str2[1], 'top' => $str2[2] );
         }
       return $elements;
     }

   
?>