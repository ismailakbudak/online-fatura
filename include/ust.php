<?php
     
     error_reporting(0);
     
     require '../include/function.php';        
     session_kontrol('../giris','../index');  
  
     require_once '../my_class/kullanici_sirket.php';
          
     $sirket_pk = $_SESSION['sirket_pk']; 
     $kullanici_pk = $_SESSION['kullanici_ses']; 
     $time = $_SESSION['time']; 
     // kullanıcının kullanıcı adı ve baktı ğı şirketin ismi çekiliyor
     $db = new kullanici_sirket(); 
     $kullanici = $db->kullanici_bilgileri_getir($kullanici_pk, $sirket_pk);
    
?>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <title>Kullanıcı Paneli</title>
     <!--   CSS  -->
     <link href="../style/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="../style/css/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" media="screen" />
     <!--   JScript  -->
     <script type="text/javascript" src="../style/js/jquery.js"></script>
     <script type="text/javascript" src="../style/js/jNice.js"></script>
     <script type="text/javascript" src="../style/js/JScript_My.js"></script>  
     <script type="text/javascript" src="../style/js/jquery-1.9.1.js"></script>
     <script type="text/javascript" src="../style/js/jquery-ui.js"></script>
 <!--   
     <script type="text/javascript" src="../style/js/jquery-ui-1.10.3.custom.js"></script>
  -->
      <style>
             .ui-resizable-se {
                 bottom: 17px;
              }
      </style>
      <script>
                $(function () {
                    $('#resizable').resizable({
                     handles: 'se'
                     });
                  });
      </script>
 <?php
 /*
     $deger = (10 * 60) + $time - time();
      echo "  <script>
              startclock('#mainInfo #time', $deger);
          </script> "; 
  */
 ?>
  </head>
  <body>
     <div id="wrapper">
        <div class="hatali"></div>
        <div class="hatali2"></div>  
        <h1>
            <a href="../anasayfa.php?page=anasayfa"></a>
        </h1>
        <ul id="mainNav">
            <li><a id="anasayfa"  href="../anasayfa.php">ANA SAYFA</a></li>
            <li><a id="faturalar"  href="../anasayfa.php?page=faturalar">FATURALAR</a></li>
            <li><a id="musteri"   href="../anasayfa.php?page=musteriler">MÜŞTERİLER</a></li>
            <li><a id="urunler"  href="../anasayfa.php?page=urunler">ÜRÜNLER</a></li>
            <li><a id="urun-gruplari" href="../anasayfa.php?page=urun-gruplari">ÜRÜN GRUPLARI</a></li>
            <li class="logout"><a href="../cikis.php">ÇIKIŞ</a></li>
            <li class="logout"><a href="../index.php">ŞİRKET DEĞİŞTİR</a></li>
        </ul> 
<?php
    
    mesaj_ver($_GET['msj']);           
    if ($kullanici) 
         echo mainInfo_dondur($kullanici['kullanici_adi'] , $kullanici['sirket_isim']); 
?>