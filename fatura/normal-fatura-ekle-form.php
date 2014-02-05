<?php
  require '../my_class/fatura_detay.php';  
  require '../include/ust.php';
?>
<style type="text/css" media="screen">

#container #urun_secimi{ margin-left:0px; height:80px; width: 680px;}
#container #urun_secimi label {width:200px; float:left; font-weight:800; font-size:13px; text-align:right; padding-top: 6px; margin-bottom:10px; padding-right: 5px;padding-left: 5px; }
#container #urun_secimi .number {width:120px; float:left; font-weight:800; font-size:13px; padding:3px; margin-bottom: 5px;}

</style>                   
 <script> 
   $(function(){
     $( "#mainNav" ).find("#faturalar").addClass("active");
   });
   function ajax() {
        $.ajax({
            url: "ajax-musteriler.php?sirket_pk=<?php echo $sirket_pk ?>",
            success: function(ajaxcevap){ $('#musteriler').html(ajaxcevap).slideDown('slow'); },
            error: function() { ajax() } 
        });
        $.ajax({
            url: "ajax-odeme-detay.php",
            success: function(ajaxcevap2){$('#odeme').html(ajaxcevap2).slideDown('slow'); },
            error: function() { ajax() } 
        }); 
        $.ajax({
            url: "ajax-urun-ekle.php",
            success: function(ajaxcevap2){  $('#urun_ekleme').html(ajaxcevap2).slideDown('slow');},
            error: function() { ajax() } 
        });
        $.ajax({
            url: "ajax-urun-secimi-form.php",
            success: function(ajaxcevap2){  $('#urun_secimi').html(ajaxcevap2).slideDown('slow'); },
            error: function() { ajax() } 
        });
        $.ajax({
            url: "../radio-checkbox.php?page=ekle-form-fatura",
            success: function(ajaxcevap2){ $('#check').html(ajaxcevap2).slideDown('slow');},
            error: function() { ajax() } 
        });
         
 }
   
   $(function() {
         $( "#aciklama_ekle" ).hide();
         $( "#tik" ).on("click",function(){ $( "#aciklama_ekle" ).toggle('blind',600); }); 
          
         $( "#fatura_tarihi" ).datepicker();
         $( "#fatura_tarihi" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
         $( "#resizable2" ).resizable({ handles: 'se' });
         $( "#irsaliye_tarih" ).datepicker();
         $( "#irsaliye_tarih" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        
        /* Veri tabanına verileri ekleme işlemi yapıyor...**/ 
         $( "#onay" ).click(function() {   
         
          if(kontrsol_dizi_top(dizi)){ 
          
              var array = $( "#users" ).children('tbody').find('tr');
              if (array.length > 0) {
               
               var urunler_data ="";                
               for (var i=0; i < $(array).length; i++) {
                  var value = $(array[i]).find("td");
                  for (var j=0; j < value.length - 1; j++) { 
                     if (j != 6) {
                       urunler_data +=  $(value[j]).text() +  "é";    
                     }else{
                         urunler_data +=  $(value[j]).text();
                     }  
                  };
                  urunler_data += "||";
                }; 
                alert("yazılmadı");
                /* 
                 $.ajax({
                  type: "POST",
                  url: "ajax-ekle-islem.php?urunler_data="+urunler_data,
                  data: $('#form').serialize(),
                  success: function(ajaxcevap2){ 
                      
                      if (ajaxcevap2 == 1) {
                        
                          //formtemizle();
                          //myClicktop('.hatali','Ekleme başarılı bir şekilde yapıldı...','SONUC');
                          
                          window.location = '../anasayfa.php?page=faturalar&msj=Ekleme başarılı bir şekilde yapıldı...';
                      }
                      else{
                         $('#sonuc').html(ajaxcevap2).slideDown('slow');
                         $('#sonuc').hide();
                         myClicktop('.hatali','Ekleme işlemi yapılamadı...','SONUC');
                      } 
                  },
                  error : function() {
                           alert('Hata oluştu..');
                  } 
                 });
                 */     
              }
              else{
                 myClicktop('.hatali','Faturaya ürün eklemediniz...','UYARI');
               
              }    
          }
          
          function formtemizle() {
              
              $( "#users tbody" ).children().remove();
              $("#kdv_tutar").val("0.00");  
              $("#toplam_tutar").val("0.00");
              $("#kdvsiz_toplam_tutar").val("0.00");  
              $("#toplamdan_iskonta_tutari").val("0.00");
              $("#iskontadan_onceki_toplam").val("0.00");  
              $("#fatura_no").val("");
              $("#vergi_daire_no").val("");   
              $("#vergi_no").val("");   
              $("#fatura_basim_tarihi").val("");   
              $("#fiili_sevk_tarihi").val("");   
              $("#fatura_tarihi").val("");   
              $("#resizable2").val("");
              $("#musteri_fk").val("").text("");   
              $("#odeme_detay").val("").text("");    
          }
         })
    });
                        
    /* Bu dizi kontroller çin ****************************************/
    var dizi = new Array('fatura_no','musteri_fk','fatura_tarihi');   
</script> 
<div id="deneme"></div>
 <div id='containerHolder'>
       <div id='container' style='background: #fff; '  > 
                <h2 class='me'>
                   <a href='../anasayfa.php?page=faturalar'>FATURALAR</a>
                   &raquo;
                   <a class='active' href='#'>Normal Fatura Ekle</a>
                </h2>
                <div id='main2' style="float: left; " >                
                     <form id="form" method="post" class='jNice'>                 
                       
                        <div class='kullanici_ekle_satir'>
                            <div class="satir_bol">
                              <div class='kullanici_ekle_sag' > Fatura Tipi :</div>
                              <div id='check' style ='float:left; text-align: right; font-size:14px; ' ></div>
                            </div>
                             <div class="satir_bol">
                                <div class='kullanici_ekle_sag'  style="padding-top: 3px;"> Fatura No : </div>
                                <input id="fatura_no" name="fatura_no" type='text' placeholder="Fatura No"  />
                             </div>
                       </div>
                       
                        <div class='my' style="margin-top: 2px;" > 
                             <div class="satir_bol">
                                 <div class='kullanici_ekle_sag' > Müşteri :</div>  
                                 <div class='myy' id="musteriler"> <!--- AJAX ile müşteriler geliyo -----></div>
                              </div>
                              <div class="satir_bol" >
                                 <div class='kullanici_ekle_sag' > Ödeme Türü :</div>
                                 <div class='myy' id="odeme"> <!--- AJAX ile bilgileri geliyor -----></div>
                             </div>
                       </div>
                       
                       <div class='kullanici_ekle_satir'>
                            <div class="satir_bol">
                                <div class='kullanici_ekle_sag' style=" padding-top: 3px;" > Fatura Tarihi :  </div>
                                <input  style="width: 230px;" id="fatura_tarihi" name="fatura_tarihi" placeholder="Tarih" />
                             </div>
                             <div class="satir_bol"> 
                               <div class='kullanici_ekle_sag'  style=" padding-top: 3px;" > İrsaliye No :  </div>
                               <input style="width: 230px;"  id="irsaliye_no" name="irsaliye_no" placeholder="İrsaliye No giriniz " />                        
                              </div>
                              
                       </div>             
                         <div class="kullanici_ekle_satir">
                               <div class="satir_bol">
                                  <div class='kullanici_ekle_sag'  style=" padding-top: 3px;" >  İrsaliye Tarihi :  </div>
                                  <input style="width: 230px;" id="irsaliye_tarih" name="irsaliye_tarih" placeholder="Tarih" />
                               </div>
                               <div class="satir_bol">
                                    <h3 style="padding-top: 0px; font-size: 14px; font-weight: 200; margin-top: 7px;">
                                        Faturaya Acıklama Eklemek için
                                        <a id="tik" href="#" style="text-decoration: none; color: #C66653; "> Tıklayınız</a> </h3>  
                               </div>
                         </div>   
                       
                        <div id="aciklama_ekle" class='kullanici_ekle_satir' style='height:30px'>
                           <div class='kullanici_ekle_sag' > Açıklama :</div>
                           <textarea id='resizable2' name='aciklama' placeholder='Açıklama' style='height:30px; float:left; width:675px;' rows='5' cols='20'></textarea>                    
                        </div>
                        
                        <div id="urun_ekleme">      <!--- JQuery dolduruyor-------> </div>                            
                        <fieldset id="urun_secimi" style="float: left; margin-bottom: 10px;" >    <!--- JQuery dolduruyor-------> </fieldset>
                        
                        <!---- Onay Butonu ----------------------------------->
                        <div style='float:left;  height:30px;'>
                                 <div style="width: 300px; float: left; " > &nbsp  </div>
                                 <input id="create-user" style="width: 120px; height: 30px; margin-right: 20px " type="button" value="Ürün Ekle" />         
                                 <input id="onay"  style="width: 150px; height: 30px; margin-left: 20px; " type="button" value="Fatura Ekle" />
                                 <div style="width: 300px; float:right; " > &nbsp  </div> 
                        </div>    
               
           
             </form>  
           </div>
           <div class='clear'></div> 
           <br/>
           &nbsp;
           &nbsp;
           &nbsp;         
    </div>    
</div>

<div id="sonuc" >
      
</div>
      
<script>
       ajax();
</script>
<?php
        require '../include/_alt.php';
?>