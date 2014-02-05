 <?php 
     // sesssion kontrol
     require_once 'session_kontrol.php';
     require_once 'include/_ust.php';
     require_once 'my_class/kullanici_sirket.php';
     
     // mesaj varsa uyarı vermeyi sağlar
     mesaj_ver($_GET['msj']);
     
     // kullanıcının kullanıcı adı ve baktı ğı şirketin ismi çekiliyor
     $db = new kullanici_sirket(); 
     $kullanici = $db->kullanici_bilgileri_getir($kullanici_pk, $sirket_pk);
     
     if ($sonuc) 
         echo mainInfo_dondur($kullanici['kullanici_adi'] , $kullanici['sirket_isim']);    
     
    /* Session time*/
    /*
   $deger = (10 * 60) + $time - time();
   echo "  <script>
              startclock('#mainInfo #time', $deger);
          </script> ";  
    */
    
      // Hangi sayfanın istek edildiğine bakılıyor
     $page =$_GET['page'];
     
     if ($page == 'faturalar') 
          include  'fatura/in_faturalar.php';
     
     else if ($page == 'sirket') 
          include 'sirket/in_sirket.php';
     
     else if ($page == 'musteriler') 
          include 'musteri/in_musteriler.php';
     
     else if ($page == 'kodlar')    
         include 'musteri/in_kodlar.php';
      
    else if ($page == 'urunler') 
          include 'urun/in_urunler.php';
     
     else if ($page == 'urun-gruplari')    
         include 'urun_gruplari/in_urun-gruplari.php';      
                      
     else 
         include 'include/in_anasayfa.php';
     
     
      require_once 'include/_alt.php';
 ?>
   

