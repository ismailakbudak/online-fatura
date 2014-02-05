<?php
     require '../my_class/adres.php';
     require '../my_class/adres_musteri.php';    
     require '../my_class/musteri_detay.php';  
     require '../include/ust.php';
    
     $musteri_pk = $_GET['musteri_pk'];
    
     $db = new musteri_detay();   
     $musteri = $db->musteri_getir2($musteri_pk);
     
     if (!$musteri){ 
         $mesaj = 'Müşteri bilgileri eksik geldiği için adres ekleme yapılamıyor..';
         redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
      }
?>
<style>
     #main3 .jNice {float: left; margin-left: 110px; width: 300px; }
     #main3 .jNice .kullanici_ekle_satir{ width:280px; background-color: #F0F8FF;  height:40px; text-align: center; margin-top:2px; margin-right:8px; margin-left:8px; padding:4px;  }
     #main3 .jNice  input,textarea {width: 280px; float: left; color:#C66653; /* hafif kırmızı*/}
     #main3 .jNice input:focus , textarea:focus{ border: 2px solid #b3b3b3; background-color: #F5DEB3;  font-weight:800; color:black; }       
     #main3 .jNice .my{ width:280px; height:40px;  background-color: #F0F8FF; text-align:left;  margin-left:8px;  margin-top:2px;  margin-right:8px; padding:4px; }
     #main3 .jNice .myy{ width:auto; float:left; }
</style>
<script> 
       var dizi = new Array('resizable3','baslik');
       $(function () {
          $( "#mainNav" ).find("#musteri").addClass("active");
          $('#resizable2').resizable({
              handles: 'se'
           });
          
          $('#resizable3').resizable({
              handles: 'se'
           });
       });
</script> 
 <div id='containerHolder'>
       <div id='container' style='background: #fff;'> 
                <h2 class='me'>
                   <a href='../anasayfa.php?page=musteriler'>MÜŞTERİLER</a>
                   &raquo;
                   <a href='../musteri/detay.php?pk=<?php echo $musteri_pk; ?>'>Detay</a>
                   &raquo;
                   <a class='active' href='#'>İletişim Bilgisi Ekle</a>
                </h2>
                <div id='main' class='me' >
                        <h3 style=' font-size:16px;'>  
                          Bu adres ve telefon bilgileri 
                          <b style='color:#C66653'>
                          <?php          echo strtoupper($musteri['musteri_unvan']); ?>
                          </b>
                           ünvanlı müşteriye eklenecek..
                         </h3>
                         <form method="post" action="iletisim-bilgi-guncelle.php?musteri_pk=<?php echo $musteri_pk; ?>" class="jNice" >
                            <div class='kullanici_ekle_satir'>
                           <div class='kullanici_ekle_sag' > Müşteri Eposta :</div>
                          <input value="<?=$musteri['eposta']?>" id='eposta' type='email'  placeholder='Opsiyonel Müşteri Eposta Adresi ' name='eposta' />
                        </div>
       
                        <div class='kullanici_ekle_satir'>
                          <div class='kullanici_ekle_sag' > Müşteri Web Adresi:</div>
                          <input  value="<?=$musteri['web']?>" id='web' type='text'  placeholder=' Opsiyonel Müşteri Web Adresi' name='web' />
                        </div>
     
                        <div class='kullanici_ekle_satir' style='height:50px'>
                          <div class='kullanici_ekle_sag' > Açıklama :</div>
                          <textarea id='resizable' name='aciklama' placeholder=' Acıklama' style='height:50px; float:left; width:300px;' rows='5' cols='20'><?=$musteri['aciklama']?></textarea>                    
                        </div> 
                         
                        <div class='kullanici_ekle_satir' style='height:40px;'>
                          <div class='kullanici_ekle_sag' > &nbsp  </div>
                          <input  type='submit' name='onay'  value='Bilgileri Güncelle' />
                        </div>
                       </form> 
               </div>
                
                <div id="main3" style="text-align: right;"  >
                    <form onsubmit="return kontrol_dizi(dizi)" action='adres-ekle-islem.php?musteri_pk=<?php echo $musteri_pk; ?>' method="post" class='jNice'>
       
                        <div class='kullanici_ekle_satir'>
                           <input id='baslik' placeholder='Adres Başlığı Giriniz' name='baslik' type='text' />                    
                        </div>
             
                        <div class='kullanici_ekle_satir' style='height:40px'>
                            <textarea id='resizable3' name='adres' placeholder='Adres Giriniz' style='height:40px; float:left; width:280px;' rows='5' cols='20'></textarea>                    
                        </div>
              
                        <div class='kullanici_ekle_satir' style='height:40px'>
                           <textarea id='resizable2' name='aciklama' placeholder='Açıklama' style='height:40px; float:left; width:280px;' rows='5' cols='18'></textarea>                    
                        </div>
              
                               <!---- Onay Butonu -------------------------------------->
                       <div class='kullanici_ekle_satir' style='height:40px;'>
                       	  <div style="margin-left: 55px;"> 
                             <input  class='my_button' type='submit' name='onay' value='Adresi Ekle' />
                          </div>
                       </div>
                  </form>
               </div>  
                <script>
                   var dizi2 = new Array('tel','adresler');
               </script> 
               <div id="main3" >
                    <form onsubmit='return kontrol_musteri(dizi2);' action='tel-ekle-islem.php?musteri_pk=<?php echo $musteri_pk; ?>' method='post' class='jNice'> 
                      
                       <div class='my' > 
                             <div class='myy'>
                                 <select  name='adresler' class='adresler' >
                                     <option value='0' > Adres Seçiniz</option>
 <?php  
     // adres bilgileri çekilecek olan müşteri
    $db = new adres();
    $adresler = $db->musteri_adresleri($musteri_pk);

    if ($adresler) {
                         foreach ($adresler as $row) { 
                               echo "<option value='{$row['pk']}'> {$row['baslik']} </option>";
                          }
    }
 ?>
                                </select>
                             </div>  
                     </div>  
                    
                     <div class='kullanici_ekle_satir'>
                           <input id='tel' name='tel' placeholder='Telefon Numarası Giriniz'  type='number'   />                    
                     </div>
                
                     <div class='kullanici_ekle_satir'>
                           <input id='fax' name='fax' placeholder='Opsiyonel fax numarası'  type='number'   />                    
                     </div>
                
                      <div class='kullanici_ekle_satir' style='text-align: right;  height:40px;'  >
                         <div style="margin-left: 50px;"> 
                            <input type='submit' name='onay' value='Adrese Telefon Ekle' />
                         </div>
                      </div>
                  </form>
               </div>
              <div class='clear'></div>
       </div>
       <br>

</div>  
   

       
<?php       
      require_once '../include/_alt.php';      
?>