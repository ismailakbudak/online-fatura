
<?php
      error_reporting(0);
      require '../my_class/fatura_detay.php';
      require '../include/ust.php';
     
      $fatura_pk = $_GET['pk'];
      if (!$fatura_pk) 
         redirect('../anasayfa.php?page=faturalar&msj=Fatura bilgileri eksik geldi..');
      
     $db = new fatura_detay();
     $fatura = $db->fatura_getir_by_id($fatura_pk);
    
     if (!$fatura) 
         redirect('../anasayfa.php?page=faturalar&msj=Fatura bilgileri veritabanından çekilemedi..');
     
?>
<style type="text/css" media="screen">
#form .kullanici_ekle_satir { margin-bottom: 0px; height: 10px; margin-top: 0px; padding: 0px;}
#form .kullanici_ekle_satir .kullanici_ekle_sag{margin-bottom: 0px; height: 7px; margin-top: 0px; padding: 0px;}
#form .kullanici_ekle_satir input { width: 330px;  padding: 3px; margin-top:0px; }
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
            url: "ajax-musteriler.php?sirket_pk=<?php echo $sirket_pk."&musteri_fk=".$fatura['musteri_fk']; ?>",
            success: function(ajaxcevap){ $('#musteriler').html(ajaxcevap).slideDown('slow'); },
            error : function() { ajax() }        
        });
        $.ajax({
            url: "../radio-checkbox.php?page=ekle-form-fatura&acik=<?php echo $fatura['acik']; ?>",
            success: function(ajaxcevap2){ $('#check').html(ajaxcevap2).slideDown('slow'); }, 
            error : function() { ajax() }        
        });
        $.ajax({
            url: "ajax-odeme-detay.php?data=<?php echo $fatura['odeme_turu']; ?>",
            success: function(ajaxcevap2){ $('#odeme').html(ajaxcevap2).slideDown('slow');},
            error : function() { ajax() }        
        });
       
        $.ajax({
            url: "ajax-urun-ekle.php?fatura_pk=<?php echo $fatura_pk; ?>",
            success: function(ajaxcevap2){ $('#urun_ekleme').html(ajaxcevap2).slideDown('slow'); },
            error : function() { ajax() }        
        });
         $.ajax({
            url: "ajax-urun-secimi-form.php",
            success: function(ajaxcevap2){ $('#urun_secimi').html(ajaxcevap2).slideDown('slow'); },
            error : function() { ajax() }        
        });
     }
   
    $(function(){  
         var val1 = $( "#fatura_tarihi" ).val(),
             val2 = $( "#fatura_basim_tarihi" ).val(),  
             val3 = $( "#fiili_sevk_tarihi" ).val(); 
      
         $( "#fatura_tarihi" ).datepicker();
         $( "#fatura_tarihi" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
         $( "#resizable2" ).resizable({ handles: 'se' });
         $( "#fiili_sevk_tarihi" ).datepicker();
         $( "#fiili_sevk_tarihi" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
         
         $( "#fatura_tarihi" ).val(val1);
         $( "#fatura_basim_tarihi" ).val(val2);  
         $( "#fiili_sevk_tarihi" ).val(val3);    
         
         $("#onay").click(function(){
            if(true){ // kontrol_dizi_top(dizi)
                        
                  var array = $( "#users" ).children('tbody').find('tr');
                  if (array.length > 0) {
               
                     var urunler_data ="";                
                     for (var i=0; i < $(array).length; i++) {
                          var value = $(array[i]).find("td");
                          for (var j=0; j < value.length - 1; j++) { 
                           
                            if (j != 7) {
                               urunler_data +=  $(value[j]).text() +  "é";    
                            }else{
                               urunler_data +=  $(value[j]).text();
                            }  
                           };
                           urunler_data += "||";
                      };  
                
                      $.ajax({
                        type: "POST",
                        url: "ajax-guncelle-islem.php?urunler_data="+urunler_data+"&fatura_pk=<?php echo $fatura_pk; ?>",
                        data: $('#form').serialize(),
                        success: function(ajaxcevap2){
                             $('#sonuc').html(ajaxcevap2).slideDown('slow');
                             $('#sonuc').hide();
                         },
                         error : function() { alert('Hata oluştu..'); } 
                       });
              }
              else{
                 myClicktop('.hatali','Faturada ürün yok...','UYARI');
             }
          }
        });  
     });
     
     function denemeDialog( mesaj ){
         $('#deneme').dialog({
                         modal: true,
                         show: 'blind',  
                         hide: 'blind',
                         height: 150,
                         width:250,
                         speed: 'slow',
                         title:  'GÜNCELLEME',
                         draggable: false,
                         buttons: {
                              "Tamam": function() {
                                   $( this ).dialog( "close" );           
                               }
                         },
                         close: function() {
                         	//location.reload();
                         }  
                }).text(mesaj);
          $("#deneme").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
     }
     
  /* Bu dizi kontroller çin ****************************************/
    var dizi = new Array('fatura_no','musteri_fk','odeme_detay','vergi_daire_no','vergi_no','fatura_tarihi','fatura_basim_tarihi','fiili_sevk_tarihi');   
</script> 
<div id="deneme"></div>
 <div id='containerHolder'>
       <div id='container' style='background: #fff; '  > 
                <h2 class='me'>
                   <a href='../anasayfa.php?page=faturalar'>FATURALAR</a>
                   &raquo;
                   <a class='active' href='#'>İrsaliyeli Fatura Güncelle</a>
                </h2>
                <div id='main2'  >                
                     <form id="form" method="post" class='jNice' style=" font-size: 12px;">
                       
                        <div class='kullanici_ekle_satir'>
                              <div class="satir_bol">
                                  <div class='kullanici_ekle_sag' > Fatura Tipi :</div>
                                  <div  id='check' style ='float:left; padding-top:3px; text-align: right;  font-size:14px; ' ></div>
                             </div>
                              <div class="satir_bol">
                                   <div class='kullanici_ekle_sag' style="padding-top:5px;"  > Fatura No : </div>
                                   <input style="padding:1px;" id="fatura_no" value="<?php echo $fatura['fatura_no']; ?>" name="fatura_no" type='text' placeholder="Fatura No"  />
                              </div>
                        </div>
                        
                        <div class='my' style="margin-top: 2px;" >
                              <div class="satir_bol">
                                  <div class='kullanici_ekle_sag' > Müşteri :</div>  
                                  <div class='myy' id="musteriler"> <!--- AJAX ile müşteriler geliyo -----></div>
                              </div>
                              <div class="satir_bol">
                                  <div class='kullanici_ekle_sag' > Ödeme Türü :</div>
                                  <div class='myy' id="odeme"> <!--- AJAX ile bilgileri geliyor -----></div>
                              </div>
                        </div>
                        <div class='kullanici_ekle_satir'>
                             <div class="satir_bol" style="width: 250px; float: left">
                                  <div class='kullanici_ekle_sag' style="padding-top:3px;" > Fiili Sevk Tarihi :  </div>
                                  <input style="padding:1px; width:90px;"  id="fiili_sevk_tarihi" value="<?php echo $fatura['fiili_sevk_tarihi']; ?>" name="fiili_sevk_tarihi" size="30" type="text" placeholder="Fiili Sevk Tarihi"  />
                             </div>
                             <div class="satir_bol" style="width: 300px; float: left">
                                <div class='kullanici_ekle_sag' style="padding-top:3px; width: 200px" > Fatura Düzenlenme Tarihi :  </div>
                                <input style="padding:1px; width:90px;"  id="fatura_tarihi" value="<?php echo $fatura['fatura_tarih']; ?>" name="fatura_tarihi" size="30" type="text" placeholder="Fatura Tarihi" />   
                              </div>
                              <div class="satir_bol" style=" float: left; width: 300px;">
                                <div class='kullanici_ekle_sag' style="padding-top:3px; width: 200px" > Fatura Düzenlenme Saati :  </div>
                               <input style="padding:1px; width:90px;"  id="fatura_basim_tarihi" value="<?php echo $fatura['fatura_basim_tarihi']; ?>" name="fatura_basim_tarihi" size="30" type="text" placeholder="Fatura Basim Tarihi"  />
                             </div>
                        </div>
                      
                       <div class="kullanici_ekle_satir" style=" height: 35px;">
                                <div class='kullanici_ekle_sag' style="padding-top:5px;" > Açıklama :</div>
                                <textarea id='resizable2' name='aciklama' placeholder='Açıklama' style='height:35px; float:left; width:680px;' rows='5' cols='20'><?php echo $fatura['aciklama']; ?></textarea>                   
                        </div>
                  
                        <div id="urun_ekleme">      <!--- JQuery dolduruyor-------> </div>                            
                        <fieldset id="urun_secimi" style="float:left; margin-top: 0px; " >    <!--- JQuery dolduruyor-------> </fieldset>
                        
                            <!---- Onay Butonu -------------------------------------->
                      <div style='float:left;  height:30px; margin-top: 15px;'>
                                 <div style="width: 200px; float: left; " > &nbsp  </div>
                                   <input id="create-user" style="width: 120px; height: 30px; margin-right: 20px " type="button" value="Ürün Ekle" />         
                                   <input id="onay"  style="width: 150px; height: 30px; margin-left: 20px; margin-right: 20px; " type="button"  value="Fatura Güncelle"  />
                                   <input style="width: 150px; height: 30px; margin-left: 30px; " type="submit"  value="Geri Al"  />
                                 <div style="width: 200px; float:right; " > &nbsp  </div> 
                        </div> 
             </form>  
           </div>
           <div class='clear'></div>
           <br>
           <br>
    </div>    
</div>

<div id="sonuc" style="margin: 0px;">
      
</div>

<script>
       ajax();
</script>

<?php
    require '../include/_alt.php';
?>