<?php
     
     session_start();
     require_once 'my_class/kullanici_sirket.php';
     require_once 'include/function.php';
     
     // Session var mı yok mu kontrol ediliyor
     if(!isset($_SESSION['kullanici_ses'])){
        $url = 'giris.php';
		    echo "<script>
                   window.location = '{$url}';
	           </script>";
        exit();
     } 

     // 60 saniye içinde oturum kapatılır
     if ( $_SESSION['time'] < time() - (60)) {    
         $url= 'giris.php?msj=Uzun süre işlem yapmadığınız için oturum kapatıldı. Tekrar giriş yapınız.';
         echo "<script>
                    window.location = '{$url}';
	           </script>";
         exit();
     }

     // tekrar diğer sayfalara dönmesini engellemek için
     unset($_SESSION['sirket_pk']);   
     $_SESSION['time'] = time(); 
  ?>
  

<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <title>Kullanıcı Paneli</title>
     <!--   CSS  -->
     <link href="style/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="style/css/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" media="screen" />
     <!--   JScript  -->
     <script type="text/javascript" src="style/js/jquery.js"></script>
     <script type="text/javascript" src="style/js/jNice.js"></script>
     <script type="text/javascript" src="style/js/JScript_My.js"></script>  
     <script type="text/javascript" src="style/js/jquery-1.9.1.js"></script>
     <script type="text/javascript" src="style/js/jquery-ui.js"></script>
  </head>
  <body>
     <div id="wrapper">
          <div class="hatali"></div>  
            <h1>
               <a href="anasayfa.php?page=anasayfa">
                  <span>Fatura </span>
               </a>
            </h1>
            <ul id="mainNav">
               <li class="logout" style="width: 91px;"><a href="cikis.php">ÇIKIŞ</a></li>
            </ul>
            
            <script> var dizi = new Array('sirket'); </script>
            
            <div id='containerHolder'>
                <div id='container' style="background: #fff">
                      <h2 style="float:left; font-size:20px; margin-left: 120px;">
                          <a class='active' href='#'>Şirket Seçimi</a>
                     </h2>        
                     <div id='main' style="float:left; height: 450px; margin-left: 120px;">
                         <form action='sirket_secimi.php' onsubmit="return kontrol_dizi(dizi)" method="post" class='jNice' style="margin-top: 30px;">
                              <fieldset>
                                <p>
                                  <div> 
                                      <div class="kullanici_ekle_sag" style="width: 250px;" >İşlem Yapabileceğiniz Şirketler : </div>  
                                      <div class="myy" >
                                         <select name="sirket" class='sirket'>
                                            <option value="0">Şirket Seçiniz</option>
                                              <?php     
                                                   // sessiondaki kullanıcı pksı
                                                  $kullanici_pk = $_SESSION['kullanici_ses'];
                                                  
                                                  mesaj_ver($_GET['msj']);
                                                  
                                                  settype($kullanici_pk,'int');
                                                
                                                  $db = new kullanici_sirket();
                                                  $sirketler = $db->getir_by_kullanici($kullanici_pk);
                                                  
                                                  if ($sirketler) {
                                                        foreach ($sirketler as $row) {
                                                               echo " <option value='{$row['pk']}'>{$row['sirket_isim']}</option> ";
                                                         }
                                                  }
                                                       
                                                  else {
                                                      $msj = "Herhangi bir şirkete bakmaya yetkiniz yok ..";
                                                      $url= 'giris.php?msj='.$msj;
                                                      echo "<script>
                                                                 window.location = '{$url}';
                                              	        </script>";
                                              	  
                                                      exit();
                                                  }   
                                               ?>   
                                          </select> 
                                      </div>
                                  </div>
                               </p>
                               <!-- Onay butonu -->   
                               <div class='kullanici_ekle_satir'>
                                   <div class='kullanici_ekle_sag' > &nbsp  </div>
                                   <input  class='my_button'  type='submit' name='onay' value='Seçtim' />
                               </div>
                            </fieldset>
                         </form>
                      </div>
                     <div class='clear'></div>
              </div>
           </div>         
           <p id="footer" style="text-align:center">
               Tüm Hakları Saklıdır 
               <a target="_blank" href="http://ismailakbudak.com" >
               İsmail AKBUDAK. 
               </a>
          </p> 
       </div>
    </body>
  </html>


