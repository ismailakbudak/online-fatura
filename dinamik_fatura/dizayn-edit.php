<?php

    error_reporting(0);    
    require '../include/function.php';        
    session_kontrol('../giris','../index');  
 
    require "../my_class/fatura_tur.php";
    require "../my_class/fatura_position.php";     
    require "../my_class/kullanici_sirket.php";
    require "../my_class/element.php";
    require "../my_class/fatura_position_xy.php";
          
     $sirket_pk = $_SESSION['sirket_pk']; 
     $kullanici_pk = $_SESSION['kullanici_ses']; 
     $id = $_GET['id']; // seçilen fatura_position id
         
     // kullanıcının kullanıcı adı ve baktı ğı şirketin ismi çekiliyor
     $db = new kullanici_sirket(); 
     $kullanici = $db->kullanici_bilgileri_getir($kullanici_pk, $sirket_pk);
     
     if($id && $id != -1){
              
              // Fatura position tablosundan veriler çekiliyor
              $db = new fatura_position();
              $fatura_position = $db->dizayn_getir($id);
              if(!$fatura_position)
                 redirect('dizayn-form.php?msj=Fatura position bilgileri çekilemedi..');
              
              $db = new fatura_position_xy(); 
              $fatura_position_xy = $db->eleman_xy_getir($id); 
              if(!$fatura_position_xy)
                 redirect('dizayn-form.php?msj=Fatura position bilgileri çekilemedi..');
     }

?>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <title>Kullanıcı Paneli</title>
     <!--   CSS  -->
     <link href="../style/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="../style/css/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="../style/dinamik/css.css" rel="stylesheet" type="text/css" media="screen" />
  </head>
  <body>
     <div id="wrapper">
        <div class="hatali"></div>
        <div class="hatali2"></div> 
        <h1> <a href="../anasayfa.php?page=anasayfa"></a> </h1>
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
       if ($kullanici) 
            echo mainInfo_dondur($kullanici['kullanici_adi'] , $kullanici['sirket_isim']);
       else
       	   redirect('dizayn-form.php?msj=Kullanıcı bilgileri çekilemedi..');
                
   ?>
  <div id='containerHolder' style='height:auto; padding-bottom:10px; ' >
       <div id='container' style='height: auto; padding:10px; background: #fff; width:auto; ' > 
         <div id = "sonuc"></div> 
         <div id="yazilar">
           <div id="basliklar-ust" >
                <h2 class="ui-widget-header" >Kayıtlı Fatura Dizaynları</h2>
                <select id="kayitli_dizayn"  >
                   <?php
                        $db = new fatura_position();
                        $fatura_dizaynlari = $db->sirket_dizaynlarini_getir($sirket_pk);
                         if ($fatura_dizaynlari) {
                             foreach ($fatura_dizaynlari as $dizayn){ 
                                 if( $dizayn['pk'] == $id)
                                     echo "  <option value='{$dizayn['pk']}' selected > {$dizayn['dizayn_adi']} </option> ";
                                 else
                                   echo "  <option value='{$dizayn['pk']}' > {$dizayn['dizayn_adi']} </option> ";
                              }
                              if(!$id)
                              	  echo "  <option value='-1' selected > Dizayn seçiniz..</option> ";
                              
                         }
                         else 
                             echo "  <option val = '-1'>Kayıtlı Yok </option> ";   
                   ?>
                </select>
           </div>

           <h2 class="ui-widget-header">Fatura içerikleri</h2>
           <div id="basliklar">
               <ul class="elementler">
                  <?php 
                        $db = new element();
                        $elementler = $db->element_getir();
                        if ($elementler) {
                             foreach ($elementler as $element){
                                   $is_exist = false;
                                   foreach ($fatura_position_xy as $xy) {
                                      if($xy['element_fk'] == $element['pk'] ) {	 
                                      	$is_exist = true;
                                      	 break;
                                      }
                                   }
                                   if(!$is_exist)
                                        echo "<li><div class='element' data-id='{$element['pk']}'> {$element['isim']} <a  class='ui-icon ui-icon-plusthick' title='Ekle' ></a> </div></li>";      
                                    
                            }
                        }                  
                  ?>
               </ul>
           </div>
         </div>

         <div id="ust_bar">
             <div id="yazPozisyon">
                 <form id="form">
                         <div id="page_info" >
                            <label > Genişilik : </label>
                            <?php  
                               echo  "<input id='width' name='width' value='{$fatura_position['width']}' class='yaz' type='text' placeholder='Sayı giriniz..' />";
                            ?>
                            <input id="width-arttir" type="button" value="+"  class="ui-widget-button" style=""/>
                            <input id="width-azalt" type="button" value="-"  class="ui-widget-button" style=""/>
                            <label style= "margin-left:10px;" > Yükseklik : </label>
                            <?php
                              echo "<input id='height' name='height'  value='{$fatura_position['height']}' type='text'  placeholder='Sayı giriniz..' class='yaz' />";
                            ?>
                            <input id="heigth-arttir" type="button" value="+"  class="ui-widget-button" />
                            <input id="heigth-azalt" type="button" value="-"  class="ui-widget-button" />
                            <select id="uzunluk" name="uzunluk" class="uzunluk">
                                <option value="1" >Pixel</option>
                                <option value="2" >Santi Metre</option>
                            </select>
                         </div>
                         <div id="kayit_info" >     
                              <input id="update" type="button" value="Güncelle"  class="ui-widget-button" />
                              <label >Fatura Türleri :</label>
                              <select id="fatura_tur" name="fatura_tur" >
                                  <?php 
                                         $db = new fatura_tur();
                                         $fatura_turleri = $db->getir_turleri();
                                          if ($fatura_turleri) {
                                              foreach ($fatura_turleri as $tur){
                                                    if( $tur['pk'] == $fatura_position['fatura_tur_fk'] )
                                                       echo "  <option value='{$tur['pk']}' selected > {$tur['tur_adi']} </option> "; 
                                                    else 
                                                       echo "  <option value='{$tur['pk']}' > {$tur['tur_adi']} </option> "; 
                                              }
                                          }
                                          else 
                                              echo "  <option value='-1' > Fatura Turleri Yok </option> ";        
                                  ?> 
                               </select>
                               <label > Dizayn Adı: </label>
                               <?php 
                                    echo "<input id='dizayn_adi' name='dizayn_adi' value='{$fatura_position['dizayn_adi']}' style='padding:2px;' type='text' placeholder='Dizayn Adı' />";
                                ?>
                          </div>
                   </form>
                   <div id="element_info" >
                      <label > Soldan : </label> 
                      <input id="left" class="yaz" type="text" placeholder="Sayı" />
                      <label > Yukarıdan : </label>
                      <input id="top" class="yaz" type="text"  placeholder="Sayı" />
                      <label id="element-name" > </label> 
                      <label id="hata-mesaj"> </label>
                   </div> 
             </div>
          </div> 
          <div id="sayfa" style="padding:10px;" >
          	<?php 
                 foreach ($fatura_position_xy as $xy) {
                    echo	"<div class='element' data-id='{$xy['element_fk']}'
                             data-left='{$xy['left']}' data-top='{$xy['top']}'      
                            > {$xy['isim']}  <a  class='ui-icon ui-icon-minusthick' title='Çıkar' ></a></div>";
                 }
          	?>
          </div>
          <div class='clear'></div> 
        </div>
          <p id="footer" style="text-align:center"> Tüm Hakları Saklıdır <a target="_blank" href="http://ismailakbudak.com" > İsmail AKBUDAK </a> </p> 
        </div>
      </div>

     <script type="text/javascript" src="../style/js/jNice.js"></script>
     <script type="text/javascript" src="../style/js/JScript_My.js"></script>  
     <script type="text/javascript" src="../style/js/jquery-1.9.1.js"></script>
     <script type="text/javascript" src="../style/js/jquery-ui.js"></script>
     <script type="text/javascript" src="../style/dinamik/javascript-edit.js"></script>
     <script>
         $(function(){
             
             $( '#update' ).on('click',function(){
                     var array = $("#sayfa").find(".element"), 
                    pos_base = $( "#sayfa" ).position(),
                    positionLeft, 
                    positionTop,
                    veri = ""; 
                if( array.length > 0 ){
                    if ($('#dizayn_adi').val() != '' ) {
                          for (var i = array.length - 1; i > 0; i--) {
                               positionLeft =  ($(array[i]).offset().left - pos_base.left).toFixed(0);
                               positionTop =  ($(array[i]).offset().top - pos_base.top ).toFixed(0);
                               veri +=  $(array[i]).data('id') + "*" + positionLeft + "*" + positionTop + "/" ;
                          }
                          positionLeft =  ($(array[0]).offset().left - pos_base.left).toFixed(0);
                          positionTop =  ($(array[0]).offset().top - pos_base.top ).toFixed(0);
                          veri +=  $(array[0]).data('id') + "*" + positionLeft + "*" + positionTop ;
                          
                           $.ajax({
                                   type: "POST",
                                   url: "dizayn-edit-islem.php?veri="+ veri +"&pk="+ <?php echo $id; ?> ,
                                   data: $('#form').serialize(),
                                   success: function(ajaxcevap){ 

                                         if (ajaxcevap == 1) 
                                            window.location = 'dizayn-edit.php?msj=Güncelleme işlemi başarılı bir şekilde yapıldı...&id='+ <?php echo $id; ?> ;
                                         else
                                             $('#sonuc').html(ajaxcevap).slideDown('slow');
                                          
                                   },
                                   error : function() {
                                          mesaj('.hatali', 'Hata oluştu işlem yapılamadı', 'UYARI');
                                   } 
                            });
                         }
                         else {
                            mesaj('.hatali', 'Dizayn ismi girmediniz..', 'UYARI');
                            return ;
                         }
                  }
                  else {
                    mesaj('.hatali','Hiç eleman eklemediniz...','SONUÇ');
                    return false; 
                  }
             });  
         });
      </script>
      <?php
          if($_GET['msj']){
              echo "<script> mesaj('.hatali','{$_GET['msj']}','SONUÇ'); </script>";
          }  
      ?>
   </body>
  </html>