<?php
    require_once '../include/ust.php';
    require_once '../my_class/urun_grup.php';  
 ?>  
  
<script> 
   function ajax() {
        $.ajax({
            url: "../radio-checkbox.php?page=ekle-form",
            success: function(ajaxcevap2){ 
                $('#check').html(ajaxcevap2).slideDown('slow');
            } 
        }); 
      } 
     $(function(){
       $( "#mainNav" ).find("#urunler").addClass("active");
     });
     var dizi = new Array('grup_fk','urun_kodu','urun_ismi','kdv_orani' );
 </script>
  
   <div id='containerHolder'>
       <div id='container' style='background: #fff; height: 500px;'> 
                <h2 class='me'>
                   <a href='../anasayfa.php?page=urunler'>ÜRÜNLER</a>
                   &raquo;
                   <a class='active' href='#'>Ekle</a>
                </h2>               
                <div id='main' class='me' >
                    <form onsubmit="return kontrol_dizi(dizi)" action='ekle-islem.php' method="post" class='jNice'>
                       <div class='my' > 
                           <div class='kullanici_ekle_sag' > Ürün Grupları :</div>  
                           <div class='myy'>
                              <select  name='grup_fk' class='grup_fk' >
                                 <option value='0' > Ürün Grubu Seçiniz</option>
                                    <?php         
                                             $db = new urun_grup();
                                             $grup_isimleri = $db->grup_getir_sirket_fk($sirket_pk);
                                              if ($grup_isimleri) {
                                                  foreach ($grup_isimleri as $grup) {
                                                        echo "  <option value='{$grup['pk']}' > {$grup['grup_ismi']} </option> ";      
                                                  }
                                              }
                                              else 
                                                    echo "  <option value='0' > Şirkete Ait Grup Yok </option> ";                
                                    ?>                              
                              </select>
                           </div>
                       </div>   
                       <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Ürün Kodu :</div>
                            <input name='urun_kodu' id='urun_kodu' type='text'  placeholder='Ürün Kodu '  />
                       </div>
                       <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Ürün İsmi :</div>
                            <input name='urun_ismi' id='urun_ismi' type='text'  placeholder='Ürün ismi'  />
                       </div>
                       <div class='kullanici_ekle_satir'>
                              <div class='kullanici_ekle_sag' > Stok Miktarı :</div>
                              <div id='check' style ='float:left; font-size:16px; ' ></div>
                       </div>
                       <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Kritik Seviye :</div>
                            <input name='kritik_seviye' id='kritik_seviye' type='number'  placeholder='Kritik Seviye'  />
                       </div>
                       <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Kdv Oranı % :</div>
                            <input name='kdv_orani' id='kdv_orani' type='number'  placeholder='Kdv Oranı'  />
                       </div>
                       <div class='kullanici_ekle_satir' style='height:50px'>
                          <div class='kullanici_ekle_sag' > Açıklama :</div>
                         <textarea id='resizable' name='aciklama' style='height:50px; float:left; width:300px;'  placeholder='Açıklama' rows='5' cols='20'></textarea>                    
                       </div>
                       <!-- Onay Butonu -->
                       <div class='kullanici_ekle_satir' style='height:40px;'>
                           <div class='kullanici_ekle_sag' > &nbsp  </div>
                           <input  class='my_button' type='submit' name='onay' value='Ürünü Ekle' />
                       </div>
                  </form>
               </div>   
              <div class='clear'></div>
       </div>
</div>  
   
<script>   ajax();   </script>
<?php   require_once '../include/_alt.php';   ?>








