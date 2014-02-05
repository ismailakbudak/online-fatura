<?php
    require_once '../include/ust.php';
    require_once '../my_class/musteri_detay.php';  
    
     $musteri_pk = $_GET['pk'];
     if (!$musteri_pk){
          $mesaj = 'Müşteri bilgileri eksik geldi..';
          redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
     }
     
     $db = new musteri_detay();
     $musteri = $db->musteri_getir2($musteri_pk);
     if (!$musteri) {
         $mesaj = 'Müşteri bilgileri çekilemedi...';
         redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
     }
     
 ?>  
<script>
   $(function(){
       $( "#mainNav" ).find("#musteri").addClass("active");
   });
   function ajax() {
      $.ajax({
            type: "POST",
            url: "ajax-musteri-kodu.php?data=<?php echo $musteri['musteri_tabela']; ?> ",
            data: $('#form').serialize(),
            success: function(ajaxcevap2){ 
                $('#musteri_kod_div').html(ajaxcevap2).slideDown('slow');
            },
            error : function() {
              ajax();
            } 
        }); 
  }   
 </script>

<div id='containerHolder'>
    <div id='container' style='background: #fff;'> 
        <h2 class='me'>
            <a href='../anasayfa.php?page=musteriler'>MÜŞTERİLER</a>
            &raquo;
           <a class='active' href='#'>Güncelle</a>
        </h2>
         <script>
             var dizi = new Array('musteri_kod','musteri_unvan','vergi_dairesi','vergi_no');
         </script>
     
        <div id='main'class="me">
            <form id="form" onsubmit='return kontrol_musteri(dizi)' action='guncelle-islem.php?pk=<?php echo $musteri_pk ?>' method='post' class='jNice'> 
   
                 <div class='my' style="margin-top: 2px;" > 
                      <div class='kullanici_ekle_sag' > Müşteri Kodu  :</div>
                      <div class='myy' id="musteri_kod_div"> <!--- AJAX ile bilgileri geliyor -----></div>
               </div>
          
               <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Müşteri Unvan :</div>
                  <input value='<?php echo $musteri['musteri_unvan'] ?>' name='musteri_unvan' id='musteri_unvan' placeholder='Müşteri Unvan' type='text' />
                </div>  
   
                <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Vergi Dairesi Adı :</div>
                  <input value='<?php echo $musteri['vergi_dairesi'] ?>' id='vergi_dairesi' type='text'  placeholder='Vergi Dairesi Adı ' name='vergi_dairesi' />
                </div>
      
             <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Vergi No :</div>
                  <input value='<?php echo $musteri['vergi_no'] ?>' id='vergi_no' type='number'  placeholder='Vergi no ' name='vergi_no' />
                </div>
     
              <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Müşteri Eposta :</div>
                  <input value='<?php echo $musteri['eposta'] ?>' id='eposta' type='email'  placeholder='Opsiyonel Müşteri Eposta Adresi ' name='eposta' />
                </div>
       
              <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Müşteri Web Adresi:</div>
                  <input value='<?php echo $musteri['web'] ?>' id='web' type='text'  placeholder=' Opsiyonel Müşteri Web Adresi' name='web' />
                </div>
     
                <div class='kullanici_ekle_satir' style='height:50px'>
                  <div class='kullanici_ekle_sag' > Açıklama :</div>
                  <textarea id='resizable' name='aciklama' placeholder=' Acıklama' style='height:50px; float:left; width:300px;' rows='5' cols='20'><?php echo $musteri['aciklama'] ?></textarea>                    
                </div> 

                 <div class='kullanici_ekle_satir' style='height:40px;'>
                        <div class='kullanici_ekle_sag' > &nbsp  </div>
                        <input  class='my_button' type='submit' name='onay' value='Müşteri Güncelle' />
                 </div>
                 
                 
                 <div class='kullanici_ekle_satir' style='height:40px;'>
                    <h3 style="text-align: left; float: left;"> Adres Güncellemek için 
                     <?php   echo "  <a href='adres-guncelle-form.php?musteri_pk={$musteri_pk}' class='view' >Tıklayınız.</a> ";  ?> 
                 </h3>
                 </div>
                 <br>
                 <br>
                  
              </form>
                 
                &nbsp;
            </div>   
           <div class='clear'></div>
       </div>
</div>     
 <script>
       ajax();
</script>
  
<?php   require_once '../include/_alt.php';   ?>








