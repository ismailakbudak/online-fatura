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
            url: "ajax-urun-secimi-form.php",
            success: function(ajaxcevap){ $('#urun_secimi').html(ajaxcevap).slideDown('slow'); },
            error : function() { ajax(); } 
        });
         $.ajax({
            url: "ajax-faturalar.php",
            success: function(ajaxcevap){ $('#fatura').html(ajaxcevap).slideDown('slow'); },
            error : function() { ajax(); } 
        });
   }
  $(function(){
  	        
  	     $( "#aciklama_ekle" ).hide();
         $( "#tik" ).on("click",function(){ $( "#aciklama_ekle" ).toggle('blind',600); }); 
          
         $( "#irsaliye_tarih" ).datepicker();
         $( "#irsaliye_tarih" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
         $( "#resizable2" ).resizable({ handles: 'se' });
         $( "#fiili_sevk_tarihi" ).datepicker();
         $( "#fiili_sevk_tarihi" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
           
         $( "#onay" ).click(function() {   
         
              if(kontrol_dizi_top(dizi)){ 
                     alert("daha yazılmadı");
               }
         
          });
  });                 
    /* Bu dizi kontroller çin ****************************************/
    var dizi = new Array();   
</script> 
<div id="deneme"></div>
 <div id='containerHolder'>
       <div id='container' style='background: #fff; '  > 
                <h2 class='me'>
                   <a href='../anasayfa.php?page=faturalar'>FATURALAR</a>
                   &raquo;
                   <a class='active' href='#'>İrsaliye Faturası Ekle</a>
                </h2>
                <div id='main2' style="float: left; " >                
                     <form id="form" method="post" class='jNice'>                 
                        
                         <div class='my' style="margin-top: 2px;" > 
                             <div class="satir_bol">
                                 <div class='kullanici_ekle_sag' > Faturalar :</div>  
                                 <div class='myy' id="fatura"> <!--- AJAX ile fatura urunleri geliyo -----></div>
                             </div>
                          </div>
                       
                       <div class='kullanici_ekle_satir'>
                            <div class="satir_bol">
                                <div class='kullanici_ekle_sag' style=" padding-top: 3px;" > Düzenlenme Tarihi :  </div>
                                <input  style="width: 230px;" id="irsaliye_tarih" name="irsaliye_tarih" placeholder="Tarih" />
                             </div>
                             <div class="satir_bol"> 
                               <div class='kullanici_ekle_sag'  style=" padding-top: 3px;" > Düzenlenme Saati :  </div>
                               <input style="width: 230px;" value="<?php echo (Date("H") + 1) .":". Date("i:s");  ?>"  id="duzenlenme_saat" name="duzenlenme_saat" placeholder="İrsaliye Düzenleme Saati " />                        
                              </div>
                              
                       </div>             
                         <div class="kullanici_ekle_satir">
                               <div class="satir_bol">
                                  <div class='kullanici_ekle_sag'  style=" padding-top: 3px;" > Fiili Sevk Tarihi :  </div>
                                  <input style="width: 230px;" id="fiili_sevk_tarihi" name="fiili_sevk_tarihi" placeholder="Tarih" />
                               </div>
                               <div class="satir_bol">
                                    <h3 style="padding-top: 0px; font-size: 14px; font-weight: 200; margin-top: 7px;">
                                        İrsaliye Faturasına Açıklama Eklemek için
                                        <a id="tik" href="#" style="text-decoration: none; color: #C66653; "> Tıklayınız</a> </h3>  
                               </div>
                         </div>   
                       
                        <div id="aciklama_ekle" class='kullanici_ekle_satir' style='height:30px'>
                           <div class='kullanici_ekle_sag' > Açıklama :</div>
                           <textarea id='resizable2' name='aciklama' placeholder='Açıklama' style='height:30px; float:left; width:675px;' rows='5' cols='20'></textarea>                    
                        </div>
                        
                        <div id="urun_ekleme">      <!--- JQuery dolduruyor-------> </div>
                                                    
                        <fieldset id="urun_secimi" style="float:left; margin-top: 0px; " >    <!--- JQuery dolduruyor-------> </fieldset>
                        
                        
                        <!---- Onay Butonu ----------------------------------->
                        <div style='float:left;  height:30px; margin-top: 20px;'>
                                 <div style="width: 300px; float: left; " > &nbsp  </div>
                                 <input id="onay"  style="width: 150px; height: 30px; margin-right: 20px; " type="button" value="İrsaliye Faturası Ekle" />
                                 <input style="width: 150px; height: 30px; margin-right: 20px; " type="submit" value="Geri Al" /> 
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
<script>
       ajax();
</script>

<?php 
     require '../include/_alt.php';
?>