 <?php
      require_once '../include/ust.php';
 ?>  
  <script>    
    function ajax() {
        $.ajax({
            url: "ajax-urunler.php?sirket_pk=<?php echo $sirket_pk ?>",
            success: function(ajaxcevap){  $('#urun').html(ajaxcevap).slideDown('slow'); },
            error : function() {  ajax() } 
        });
        $.ajax({
            url: "ajax-musteriler.php?sirket_pk=<?php echo $sirket_pk ?>",
            success: function(ajaxcevap){ $('#musteriler').html(ajaxcevap).slideDown('slow'); },
            error : function() { ajax() } 
        }); 
    }

    $(function(){
       // İnteger ve double değerler girilmesini sağlamak için
       function spinyap(id) {
           $( id ).spinner({
                step: 0.01,
                numberFormat: "n"
            });
           $( id ).change(function(){
              if( isNaN($(this).val()) == true ){
                    myClick('.hatali','Lütfen sayı giriniz..','UYARI');   
                   $(this).val(''); 
              }
            }); 
       }
       $( "#mainNav" ).find("#urunler").addClass("active");
       spinyap("#urun_adet");
       spinyap("#birim_fiyat");
       spinyap("#indirim");
    });
    // veri kontrolü için
    var dizi = new Array('urun_fk','musteri_fk','urun_adet','adet_birim','birim_fiyat'); 

 </script>                     
 
 <style>
      #urun_adet { padding: 2px; width:400px; float:left;  margin:0px;  height:22px;}
      #birim_fiyat { padding: 2px; width:400px; float:left;  margin:0px;  height:22px;}
      #indirim { padding: 2px; width:400px; float:left;  margin:0px;  height:22px;}
 </style>
   
   <div id='containerHolder'>
       <div id='container' style='background: #fff; height: 500px;'>              
                <h2 class='me'>
                   <a href='../anasayfa.php?page=urunler'>ÜRÜNLER</a>
                   &raquo;
                   <a class='active' href='#'>Ürün Stok'u Ekle</a>
                </h2>
                <div id='main' class='me' >
                    <form id='form' onsubmit="return kontrol_dizi(dizi)" action='stok-ekle-islem.php' method="post" class='jNice'>
                        <div class='my' > 
                             <div class='kullanici_ekle_sag' > Ürünler :</div>  
                             <div class='myy' id="urun" >
                             <!--- AJAX ile ürünlerler geliyo -->
                             </div> 
                        </div>
                        <div class='my' style="margin-top: 2px;" > 
                               <div class='kullanici_ekle_sag' > Müşteriler :</div>  
                               <div class='myy' id="musteriler">
                               <!-- AJAX ile müşteriler geliyo -->                                
                               </div>
                        </div>
                        <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Ürün Adedi :</div>
                            <div style=" float:left; width: 330px;">
                               <input style=" float:left;  width: 330px;" name='urun_adet' id='urun_adet' placeholder='Ürün adedi giriniz'/>
                            </div>
                        </div>
                        <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Adet Birimi :</div>
                            <input style="width: 330px;" name='adet_birim' id='adet_birim' type='text'  placeholder='Adet birimi' style="width: 300px;" />
                        </div>
                        <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Birim Fiyatı  :</div>
                            <div style=" float:left;  width: 330px;">
                                <input style=" float:left;  width: 330px;" id="birim_fiyat" name='birim_fiyat'  placeholder='Birim fiyatı giriniz' style="width: 300px;"  />
                             </div>
                        </div>
                        <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > İndirim Tutarı  :</div>
                            <div style=" float:left; margin: 0px; padding-left: 0px; width: 330px;">
                               <input id="indirim" name='indirim' style=" width: 330px;"  placeholder='Toplam indirim tutarını giriniz' >
                           </div>
                        </div>
                        <div class='kullanici_ekle_satir' style='height:40px;'>
                           <div class='kullanici_ekle_sag' > &nbsp  </div>
                           <input  class='my_button' type='submit' name='onay' value='Stoklara Ekle' />
                         </div>
                  </form>
               </div>   
              <div class='clear'></div>
       </div>
 </div> 
<script>  ajax(); </script>
<?php   require_once '../include/_alt.php';   ?>








