<!--------------------------------------------------------->                       
      <style>
        
       #main { font-size: 70%; }
        fieldset { padding:0; border:0; margin-top:25px; }
        div#dialog-form .satir input{ padding: 4px; margin:0px; width: 200px; height:22px;}
        div#dialog-form .satir{ text-align: left; float: left; margin:10px; width: %90;}
        div#dialog-form .satir label{ text-align: right; padding-top:4px; float: left; width: 110px; margin-right: 10px;}
       
        div#dialog-form-edit .satir input{ padding: 4px; margin:0px; width: 200px; height:22px;}
        div#dialog-form-edit .satir{ text-align: left; float: left; margin:10px; width: %90;}
        div#dialog-form-edit .satir label{ text-align: right; padding-top:4px; float: left; width: 110px; margin-right: 10px;}
        
        
        div#users-contain { width: 250px; margin: 0px 0; }
        div#users-contain table { margin: 1em 1em; border-collapse: collapse; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px;  font-size:12px;  text-align: center; }
        .ui-dialog .ui-state-error {  }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }

/* Combo boxa ait*/
  .custom-combobox {
    position: relative;
    display: inline-block;
    height:22px;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    /* support: IE7 */
    *height: 1.7em;
    *top: 0.1em;
  }
  .custom-combobox-input {
    margin: 0;
    width: 170px;
  }
    </style>
    <script>
    $(function() {
       
      var urun_pk2 = $( "#urun_pk2" ),
            urun_adi2 = $( "#urun_pk2" ),
            miktar2 = $( "#miktar2" ),
            max_miktar = $( "#max_miktar" ),
            allFields2 = $( [] ).add( miktar2 ),
            tips = $( ".validateTips" );
            
      function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
                setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }
       function checkIsEmpty(id){
            if ( id.val() == "" || id.val() == "0" ) {
                id.addClass( "ui-state-error" );
                updateTips( "Boş geçilemez..");
                return false;
            } else {
                return true;
            }
        }
        
       function checkValue(id){
          if( isNaN(id.val()) == true  || id.val() == ""){ 
                id.addClass( "ui-state-error" );
                updateTips( "Lütfen sayı giriniz.." );
                return false;
            } else {
                return true;
            }
        }  
        /* kdv ve bilgilerini hesaplama*/
        function hesapla() {
              var kdv_tutar=0, 
                       toplam_tutar =0, 
                       kdvsiz_toplam_tutar=0, 
                       toplamdan_iskonta_tutari=0,
                       iskontadan_onceki_toplam = 0;
                   
                   var array = $( "#users" ).children('tbody').find('tr');
                   for (var i=0; i < $(array).length; i++) { 
                          
                          var value = $(array[i]).find("td");
                         
                         var miktar = parseInt ($(value[2]).text());
                         var birim_fiyati = parseFloat ( $(value[3]).text());
                         var iskonta = parseFloat ($(value[5]).text());
                         var kdv = parseFloat ($(value[6]).text());
                          
                          kdv_tutar += miktar * kdv * birim_fiyati / 100;
                          toplam_tutar += (miktar * birim_fiyati )+ (miktar * kdv * birim_fiyati / 100 ) - iskonta ;
                          kdvsiz_toplam_tutar += (miktar * birim_fiyati ) - iskonta ;
                          toplamdan_iskonta_tutari += iskonta;
                          iskontadan_onceki_toplam += (miktar * birim_fiyati )+ (miktar * kdv * birim_fiyati / 100 ) ;
                     }
                     
                    var hassasiyet =  parseInt($( "#hassasiyet").val());
                   
                    $("#kdv_tutar").val(kdv_tutar.toFixed (hassasiyet) );  
                    $("#toplam_tutar").val(toplam_tutar.toFixed (hassasiyet) );
                    $("#kdvsiz_toplam_tutar").val(kdvsiz_toplam_tutar.toFixed (hassasiyet) );  
                    $("#toplamdan_iskonta_tutari").val(toplamdan_iskonta_tutari.toFixed (hassasiyet) );
                    $("#iskontadan_onceki_toplam").val(iskontadan_onceki_toplam.toFixed (hassasiyet) );  
         }
       
         function checkValue_Range(miktar){
         	  
               value_var = $( "#max_miktar" ).val();
               alert("Miktar " + miktar + " value : " + value_var);
               if (miktar > 0 && miktar < parseInt(value_var)) {
                    alert("true");
                     return true;
               }
               else{
                     miktar2.addClass( "ui-state-error" );
                    updateTips( "Girilen sayı ürün miktarı ile uyuşmamakta.." );
                    return false;
                }
          }
       /* İnteger ve double değerler girilmesini sağlamak için*/
       function spinyap(id) {
       $( id ).spinner({
            step: 0.01,
            numberFormat: "n"
        });
       }
  
         $( "#dialog-form-edit" ).dialog({
            
            autoOpen: false,
            height: 300,
            width: 415,
            modal: true,
            resizable: false,
            speed: 'slow',
            position: {
                        my: "center top", 
                        at: "center top",
                        of: window},
            buttons: {
                   "Tamam " : function() {
                     
                     var bValid = true;
                         allFields2.removeClass( "ui-state-error" );                   
                         bValid = bValid && checkValue(miktar2);
                         bValid = bValid && checkValue_Range(miktar2.val());
                 
                         if (bValid) {
                            //  var array = click.children();
                            //  $(array[2]).text(miktar2.val() ); 
                               
                             var value_var = $( "#max_miktar" ).val(),
                                 urun_pk = $( "#urun_pk2" ).val(),
                                 array = $( "#users" ).children('tbody').find('tr');
                                 for (var i=0; i < $(array).length; i++) {
                                    var value = $(array[i]).find("td");
                                    if ( urun_pk == $(value[0]).text() && $(value[2]).text() == value_var  ) {    
                                        $(value[2]).text(miktar2.val() );
                                     };      
                                }
                              
                             $(this).dialog("close");
                         } 
                   },
                   "Kapat " : function() {
                      $(this).dialog("close");
                   }
            },
            close: function () {
               allFields2.val("").removeClass( "ui-state-error" );
               tips.text('Tüm alanlar doldurulmalı..');
               $(this).dialog("close");
               hesapla();
            }           
        });
        
        var click;       
        // güncelleme işlemi
        $( "#users" ).find('tbody').on('click', '#edit',function(event) { 
             event.preventDefault();
             $( "#dialog-form-edit" ).dialog( "open" );
              click =  $(this).closest('tr');
              var array = click.children();
                 
              miktar2 = $( "#miktar2" );
              max_miktar = $( "#max_miktar" );
              
              urun_adi2.val (  $(array[0]).text()  );
              miktar2.val (  $(array[2]).text()   );
              max_miktar.val( $(array[2]).text() );
        });
         
        /* Silme işlemi*/    
        $( "#users" ).find('tbody').on('click', '#delete',function() { 
               var de = $(this).closest('tr').find('#kod').text();
               $(this).closest('tr').remove().slideUp('slow');
               hesapla(); 
        });    
  
        $( "#hassasiyet" ).on("change",function() {
           //alert( $(this).val() );
           hesapla();
         });
   
        hesapla();  
       spinyap("#miktar");
       spinyap("#birim_fiyati");
       spinyap("#iskonta_tutari");
    
    });
    
  </script>
<!----------------------------------------------->
 <div id="dialog-form-edit" title="Ürün Ekleme">
    <form class="ui-widget">
       <fieldset>           
         <p class="validateTips">Tüm alanlar girilmelidir.</p>
         <div class="satir">
           <label for="name"  >Ürünler Kodu:</label>
            <input id="urun_pk2" name="urun_pk2" readonly="readonly" tabindex="0" id="miktar" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
        </div>
        <div class="satir">
            <label for="name">Max Miktar :</label>
            <input id="max_miktar" name="max_miktar" tabindex="0" readonly="readonly"  style="width: 230px;" class="text ui-widget-content ui-corner-all" />
        </div>
        <div class="satir">
            <label for="name">Miktar :</label>
            <input name="miktar2" tabindex="0" id="miktar2" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
        </div>
       </fieldset>
    </form>
</div>
 <!---     <h2 class="me" style="margin-left: 0px; margin-top: 0px; padding-top: 0px; width: 725px" > Ekli Ürünler</h2>
  -->
      <div id="users-contain" class="ui-widget" style="padding: 0px;" >         
           
             <table id="users" style="float:left; width: 900px; margin-left: 8px; margin-right: 8px; " class="ui-widget ui-widget-content">
                 <thead>
                    <tr class="ui-widget-header ">
                        <th id='kod'>Ürün Kodu</th>
                        <th>Ürün Adı</th>
                        <th>Miktarı </th> 
                        <th>Birim Fiyatı</th>
                        <th>Miktar Birimi</th>
                        <th>İndirim Tutarı</th>
                        <th>KDV Oranı</th>
                        <th>Veritabanı Kodu</th>
                        <th>işlem</th>
                    </tr>
                 </thead>
                 <tbody>
<?php
  error_reporting(0);
  $fatura_pk = $_GET['fatura_pk'];
  if ($fatura_pk) {
      require '../my_class/fatura_urun.php';
      $db = new fatura_urun();
      $fatura_urunleri = $db->fatura_urun_getir_by_fatura_detay_fk($fatura_pk);
      if ($fatura_urunleri) {
          foreach ($fatura_urunleri as $fatura_urun) {
              echo "  <tr>
                            <td id='kod' >{$fatura_urun['urun_kodu']}</td>
                            <td>{$fatura_urun['urun_adi']}</td>
                            <td>{$fatura_urun['miktar']}</td>
                            <td>{$fatura_urun['birim_fiyati']}</td>
                            <td>{$fatura_urun['miktar_birim']}</td>
                            <td>{$fatura_urun['iskonto_tutari']}</td>
                            <td>{$fatura_urun['kdv_orani']}</td>
                            <td>{$fatura_urun['pk']}</td>
                            <td > 
                               <button id='edit' class='ui-icon ui-icon-pencil' style='float:left; margin-left:0px; ' ></button> 
                                <button id='delete' class='ui-icon ui-icon-trash' style='float:left; margin-left:10px;' ></button> 
                            </td> 
                        </tr>  ";
          }           
      }
  }  
?>                      
                 </tbody>
            </table>       
       </div>
       