<?php
    
    // session kontrolleri yapan sayfa
    require_once '../include/ust.php';  
    require_once '../my_class/musteri_detay.php'; 
    require_once '../my_class/adres.php'; 
    
     $musteri_pk = $_GET['pk'];
   
     if ( !$musteri_pk ){
          $mesaj = 'Müşteri bilgileri eksik geldi..';
          redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
     }
     
     $db = new musteri_detay();   
     $musteri = $db->musteri_getir2($musteri_pk);
     
     if (!$musteri){ 
        $mesaj = "Müşteri bilgileri eksik geldiği için işlem yapılamıyor..";
        redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);  
     }
     
     $db = new adres();
     $adres = $db->musterinin_ilk_adresi($musteri_pk);
    
 ?>  
<script type="text/javascript">
   $(function(){
     $( "#mainNav" ).find("#musteri").addClass("active");
  });
</script>
   <div id='containerHolder'>
       <div id='container' style='height: auto;'> 
               <div id='sidebar'>
                    <ul class='sideNav'>
                        <li><a href='adres-ekle-form.php?musteri_pk=<?php echo $musteri_pk ?>'>İletişim Bilgisi Ekle </a></li>
                        <li><a href='adres-sil-form.php?musteri_pk=<?php echo $musteri_pk ?>'>Adres & Tel Sil </a></li>
                         <li><a href='adres-guncelle-form.php?musteri_pk=<?php echo $musteri_pk ?>'>Adres & Tel Güncelle </a></li>
                    </ul>
                </div>    
              
                <h2 >
                   <a href='../anasayfa.php?page=musteriler'>MÜŞTERİLER</a>
                   &raquo;
                   <a class='active' href='#'>Detay</a>
                </h2>
               
                <div id='main' >
                      <h3 style=' font-size:16px;'>  
                        Şu anda işlem yaptığınız müşterinin Ünvanı : 
                        <b style='color:#C66653'>
              <?php          echo strtoupper($musteri['musteri_unvan']); ?>
                        </b>
                    </h3>
                    <form  class='jNice'>
                         
                         <div class='my' style="margin-top: 2px;" > 
                             <div class='kullanici_ekle_sag' > Müşteri Kodu  :</div>
                              <input value='<?php echo $musteri['musteri_tabela'] ?>' readonly type='text' />
                        </div>
          
                         <div class='kullanici_ekle_satir'>
                              <div class='kullanici_ekle_sag' > Müşteri Unvan :</div>
                              <input value='<?php echo $musteri['musteri_unvan'] ?>' readonly name='musteri_unvan' id='musteri_unvan' placeholder='Müşteri Unvan' type='text' />
                        </div>  
   
                         <div class='kullanici_ekle_satir'>
                             <div class='kullanici_ekle_sag' > Vergi Dairesi Adı :</div>
                             <input value='<?php echo $musteri['vergi_dairesi'] ?>' readonly id='vergi_dairesi' type='text'  placeholder='Vergi Dairesi Adı ' name='vergi_dairesi' />
                         </div>
      
                         <div class='kullanici_ekle_satir'>
                             <div class='kullanici_ekle_sag' > Vergi No :</div>
                             <input value='<?php echo $musteri['vergi_no'] ?>' readonly id='vergi_no' type='number'  placeholder='Vergi no ' name='vergi_no' />
                         </div>
                         
                        <div class='kullanici_ekle_satir' style='height:70px'>
                          <div class='kullanici_ekle_sag' > Adres :</div>
                          <textarea id='resizable' readonly  style='height:70px; float:left; width:300px;' rows='5' cols='20'><?=$adres['adres']?></textarea>                    
                        </div>
                        
                        
                         <div class='kullanici_ekle_satir'>
                           <div class='kullanici_ekle_sag' > Müşteri Eposta :</div>
                          <input  value="<?=$musteri['eposta']?>" readonly id='eposta' type='email'  placeholder='Opsiyonel Müşteri Eposta Adresi ' name='eposta' />
                        </div>
       
                        <div class='kullanici_ekle_satir'>
                          <div class='kullanici_ekle_sag' > Müşteri Web Adresi:</div>
                          <input  value="<?=$musteri['web']?>" id='web' readonly type='text'  placeholder=' Opsiyonel Müşteri Web Adresi' name='web' />
                        </div>
                        
                        <div class='kullanici_ekle_satir' style='height:50px'>
                          <div class='kullanici_ekle_sag' > Açıklama :</div>
                          <textarea id='resizable' name='aciklama' readonly placeholder=' Acıklama' style='height:50px; float:left; width:300px;' rows='5' cols='20'><?=$musteri['aciklama']?></textarea>                    
                        </div>     
                                        
                  </form>
               </div>   
              <div class='clear'></div>
       </div>
</div>  
  
   
<?php   require_once '../include/_alt.php';   ?>








