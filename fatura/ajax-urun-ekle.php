                   
<style> 
         
            #main { font-size: 70%; }
            fieldset { padding:0; border:0; margin-top:25px; }
            div#dialog-form .satir input{ padding: 4px; margin:0px; width: 200px; height:22px;}
            div#dialog-form .satir{ text-align: left; float: left; margin:10px; width: %90;}
            div#dialog-form .satir label{ text-align: right; padding-top:4px; float: left; width: 115px; margin-right: 10px;}
           
            div#dialog-form-edit .satir input{ padding: 4px; margin:0px; width: 200px; height:22px;}
            div#dialog-form-edit .satir{ text-align: left; float: left; margin:10px; width: %90;}
            div#dialog-form-edit .satir label{ text-align: right; padding-top:4px; float: left; width: 115px; margin-right: 10px;}
            
            
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
        var urun_pk = $( "#urun_pk" ),
            urun_adi = $( "#urun_pk" ),
            miktar = $( "#miktar" ),
            birim_fiyati = $( "#birim_fiyati" ),
            miktar_birimi = $("#miktar_birimi"),
            iskonta_tutari = $("#iskonta_tutari"), 
            allFields = $( [] ).add( miktar ).add( birim_fiyati ).add( miktar_birimi ).add( iskonta_tutari ),
            tips = $( ".validateTips" );

        function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
                setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }
        function checkCombo(urun_pk){
            if ( urun_pk.val() == "" || urun_pk.val() == "0" ) {
                urun_pk.addClass( "ui-state-error" );
                updateTips( "Ürün seçmediniz..");
                return false;
            } else {
                return true;
            }
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
        function checkKod(urun_pk){
            /*
             var array = $( "#users" ).children('tbody').find('tr');
             for (var i=0; i < $(array).length; i++) { 
                  var value = $(array[i]).find("td");
                  if ( urun_pk.val() == $(value[0]).text()  ) {    
                      updateTips( "Bu ürünü daha önce eklediniz.." );
                      return false;
                  };      
             }*/
             return true;
        }
        function ekle(son) {
          var bValid = true;
                    allFields.removeClass( "ui-state-error" );                   
                    bValid = bValid && checkCombo(urun_pk);
                    bValid = bValid && checkValue(miktar);
                    bValid = bValid && checkValue(birim_fiyati);
                    bValid = bValid && checkIsEmpty(miktar_birimi);
                    bValid = bValid && checkKod(urun_pk);
                    bValid = bValid && checkValue(iskonta_tutari); 
                    bValid = bValid && son;
                    if ( bValid ) {
                        function getir(kdv) {
                            
                            var iskonto = 0;
                            // düz iskonto
                            if( $( "#iskonto_turu" ).val() == 0 ){ 
                                iskonto =  parseFloat (iskonta_tutari.val()); 
                               // alert("iskonto 1 : " + iskonto);
                             } 
                            else{ 
                                iskonto = parseFloat( iskonta_tutari.val()) * parseFloat(miktar.val()) * parseFloat(birim_fiyati.val())  / 100;   
                             }
                            
                            value = "<tr>" +
                            "<td id='kod' >" + urun_pk.val() + "</td>" +
                            "<td>" + urun_adi.children(':selected').text() +  "</td>" +
                            "<td>" + miktar.val() + "</td>" +
                            "<td>" + birim_fiyati.val() + "</td>" + 
                            "<td>" + miktar_birimi.val().toString().toUpperCase() + "</td>" +
                            "<td>" + iskonto + "</td>" + 
                            "<td>" +  kdv + "</td>" +    
                            "<td> Yeni </td>" +
                            "<td > " +   
                            "   <button id='edit' class='ui-icon ui-icon-pencil' style='float:left; margin-left: 0px; ' ></button> "+    
                            "   <button id='delete' class='ui-icon ui-icon-trash' style='float:left; margin-left: 10px; ' ></button> "+ 
                            "</td> " +
                          "</tr>";
  
                          $( "#users tbody" ).append(value);
                        }
                         $.ajax({
                           type: "POST",
                           url: "ajax-urun-bilgileri.php?urun_kodu="+ urun_pk.val(),
                           success: function(ajaxcevap){
                               if (ajaxcevap == -1) { 
                                   alert('Hata oluştu..'); 
                                }
                               else{                          
                                   getir(ajaxcevap);
                               }
                            },
                            error : function() {
                                alert('Hata oluştu..');
                            } 
                         });  
                    }
        }
        
        function checkStok(urun_pk,miktar) {
           $.ajax({
                  type: "POST",
                  url: "ajax-stok-kontol.php?urun_kodu="+ urun_pk.val() +"&miktar=" + miktar.val(),
                  success: function(ajaxcevap){
                      
                       var array = ajaxcevap.split('&');
                       if (array[0] == 0) { 
                            updateTips( array[1] );
                            ekle(false);
                        }
                        else if( array[0] == 1 ){
                            updateTips( array[1] );             
                            ekle(true);
                        }
                        /* urun stok un altına düştü izin istenmeli*/
                        else if( array[0] == 2 ){
                            $( ".hatali2" ).dialog({
                                  resizable: false,
                                  title: 'ONAY',
                                  modal: true,
                                   position: { my: "center top", 
                                               at: "center top",
                                               of: window },
                                  buttons: {
                                 "Devam Et": function() {
                                    ekle(true);
                                    $( this ).dialog( "close" );
                                  },
                                 'Hayır': function() {
                                     $( this ).dialog( "close" );
                                     updateTips( "Başka ürünler seçebilirsiniz.. " );
                                     ekle(false);
                                  }
                               }
                              }).text(array[1]); 
                              $( ".hatali2" ).closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
              
                        }
                        else{
                            updateTips( "Stok kontrolünde hata oluştu." );                        
                            ekle(false);
                        } 
                  },
                  error : function() {
                               updateTips( "Stok kontrolünde hata oluştu. Ürün ekleyemezsiniz.." );
                               ekle(false);
                          } 
                  });          
        } 
        $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 470,
            width: 440,
            modal: true,
            resizable: false,
            speed: 'slow',
            position: {
                        my: "center top", 
                        at: "center top",
                        of: window},
            buttons: {
                "Ürünü Ekle": function() {
                    checkStok(urun_pk,miktar);
                },
                " Kapat ": function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                   // allFields.val( "" ).removeClass( "ui-state-error" );
                    tips.text('Tüm alanlar doldurulmalı..');
                    $( "#urun_pk" ).find("input").text("");
                    $( "#urun_pk" ).children().first().prop({
                        selected: true
                    });
                    $( "#yeni_urun" ).find("input").val("");
                    
                    //alert( $( "#urun_pk" ).first().text() );
               
                    /* hesaplama işlemi burada yapılacak*/
                    hesapla();
             }  
        });
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
         $( "#hassasiyet" ).on("change",function() {
           //alert( $(this).val() );
           hesapla();
         });
          
        /* Yebi ürün ekleme*/
        $( "#create-user" )
            .button()
            .click(function() {
              $( "#dialog-form" ).dialog( "open" );
              $( "#dialog-form" ).closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
         
               //alert($( "#users" ).children('tbody').find('tr').first().find('td').length);
         });
       
       
          var urun_pk2 = $( "#urun_pk2" ),
            urun_adi2 = $( "#urun_pk2" ),
            miktar2 = $( "#miktar2" ),
            birim_fiyati2 = $( "#birim_fiyati2" ),
            miktar_birimi2 = $("#miktar_birimi2"),
            iskonta_tutari2 = $("#iskonta_tutari2"), 
            
            allFields2 = $( [] ).add( miktar2 ).add( birim_fiyati2 ).add( miktar_birimi2 ).add( iskonta_tutari2 ),
            tips = $( ".validateTips" );
       
         $( "#dialog-form-edit" ).dialog({
            
            autoOpen: false,
            height: 450,
            width: 440,
            modal: true,
            resizable: false,
            speed: 'slow',
            position: {
                        my: "center top", 
                        at: "center top",
                        of: window},
            buttons: {
                   "Güncelle " : function() {
               
                     var bValid = true;
                         allFields2.removeClass( "ui-state-error" );                   
                         bValid = bValid && checkValue(miktar2);
                         bValid = bValid && checkValue(birim_fiyati2);
                         bValid = bValid && checkIsEmpty(miktar_birimi2);
                         bValid = bValid && checkValue(iskonta_tutari2);
                         if (bValid) {
                             
                            var iskonto2 = 0;
                            // düz iskonto
                            if( $( "#iskonto_turu2" ).val() == 0 ){ 
                                iskonto2 =  parseFloat (  iskonta_tutari2.val() ); 
                               // alert("iskonto 1 : " + iskonto2);
                             } 
                            else if( $( "#iskonto_turu2" ).val() == 1 ) { 
                                iskonto2 = parseFloat(  iskonta_tutari2.val()) * parseFloat(miktar2.val()) * parseFloat(birim_fiyati2.val())  / 100;   
                              // alert("iskonto 2 : " + iskonto2);
                             }
                             
                             var array = click.children();
                             $(array[2]).text(miktar2.val() ); 
                             $(array[3]).text( birim_fiyati2.val()  );
                             $(array[4]).text( miktar_birimi2.val().toString().toUpperCase() ); 
                             $(array[5]).text(  iskonto2 ); 
                            
                              $(this).dialog("close");
                         }; 
                       
                   },
                   "Kapat " : function() {
                      $(this).dialog("close");
                   }
            },
            close: function () {
               allFields.val( "" ).removeClass( "ui-state-error" );
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
             $( "#dialog-form-edit" ).closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          
             click =  $(this).closest('tr');
             var array = click.children();
            // alert(click.length  + $(array[0]).text()                   );
             urun_adi2.val (  $(array[0]).text()  );
             miktar2.val (  $(array[2]).text()   );
             birim_fiyati2.val (  $(array[3]).text()  );
             miktar_birimi2.val (  $(array[4]).text()  );
             iskonta_tutari2.val (  $(array[5]).text()  );
             //hesapla(); 
        });
         
        /* Silme işlemi*/    
        $( "#users" ).find('tbody').on('click', '#delete',function() { 
               var de = $(this).closest('tr').find('#kod').text();
               $(this).closest('tr').remove().slideUp('slow');
               hesapla(); 
        });
        
        hesapla();
    });
    
    
    /* Combo box a ait**/
   /****************************************************/ 
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Tüm Bilgileri Göster" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " eşleşen veri yok.." )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
    
  })( jQuery );
 
  $(function() {
    $( "#urun_pk" ).combobox();
   // $( "#iskonto_turu").combobox();
   $( "#iskonto_turu").on("change",function() {
        if ( $(this).val() == 0 ) {  $( "#birim_fiyati_lbl" ).text("Top. İskonto :"); }
        else{ $( "#birim_fiyati_lbl" ).text("İskonto Oranı :"); }
   });
  });
  
  $(function() {
      /* İnteger ve double değerler girilmesini sağlamak için*/
       function spinyap(id) {
       $( id ).spinner({
            step: 0.01,
            numberFormat: "n"
        });
       }
       spinyap("#miktar");
       spinyap("#birim_fiyati");
       spinyap("#iskonta_tutari");
    }
  );
  </script>

 <div id="dialog-form-edit" title="Ürün Güncelleme">
    <form class="ui-widget">
       <fieldset>           
         <p class="validateTips">Tüm alanlar girilmelidir.</p>
         <div class="satir">
           <label for="name"  >Ürünler Kodu:</label>
            <input id="urun_pk2" name="urun_pk2" readonly="readonly" tabindex="0" id="miktar" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
        </div>
        <div class="satir">
            <label for="name">Miktar :</label>
            <input name="miktar2" tabindex="0" id="miktar2" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
        </div>
        <div class="satir">
            <label for="birim_fiyati">Birim Fiyatı :</label>
            <input name="birim_fiyati2" id="birim_fiyati2" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
        </div>
        <div class="satir">
            <label for="birim_fiyati">Miktar Birimi :</label>
            <input type="text" name="miktar_birimi2" id="miktar_birimi2" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
         </div>
        
         <div class="satir">
             <label>İskonto Türü :</label>
             <select id="iskonto_turu2" style="width: 230px; height: 24px;">
                 <option value="0">Toplam İskonto</option>
                 <option value="1">Birim Başına İskonto %</option>
             </select>
         </div>
         <div class="satir">
            <label for="birim_fiyati_lbl">İskonto Miktar :</label>
            <input name="iskonta_tutari2" id="iskonta_tutari2" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
         </div>
         <div style=" width: 350px; float: left">
               <b style="color: red">Not : </b>  Güncellemeler de stok hesaplaması yapılmamaktadır.</label>
         </div>
       </fieldset>
    </form>
</div>

 <div id="dialog-form" title="Yeni Ürün Seçimi">
    <form id="yeni_urun" class="ui-widget">
       <fieldset>           
         <p class="validateTips">Tüm alanlar girilmelidir.</p>
         <div class="satir">
           <label for="name"  >Ürünler :</label>
           <select id="urun_pk" name="urun_pk" style=" float: left; margin-bottom: 5px;" >
              <option value="0" ></option>         
 <?php
 
    error_reporting(0);
    require_once '../my_class/urunler.php';
    session_start();
       $sirket_pk = $_SESSION['sirket_pk'];
  if ($sirket_pk) {
   
     $db = new urunler();
     $urunler = $db->urun_getir_sirket_pk_ve_isim($sirket_pk,$urun_isim);
     if ($urunler) {
        foreach ($urunler as $urun) {
             echo "  <option value='{$urun['urun_kodu']}' > {$urun['urun_ismi']} </option> ";      
         }
     }
  }      
   ?>               
           </select>   
        </div>
        <div class="satir">
            <label for="name">Miktar :</label>
            <input name="miktar" tabindex="0" id="miktar" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
        </div>
        <div class="satir">
            <label for="birim_fiyati">Birim Fiyatı :</label>
            <input name="birim_fiyati" id="birim_fiyati" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
        </div>
        <div class="satir">
            <label for="birim_fiyati">Miktar Birimi :</label>
            <input type="text" name="miktar_birimi" id="miktar_birimi" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
         </div>
         <div class="satir">
             <label>İskonto Türü :</label>
             <select id="iskonto_turu" style="width: 230px; height: 24px;">
                 <option value="0">Toplam İskonto</option>
                 <option value="1">Birim Başına İskonto %</option>
             </select>
         </div>
         <div class="satir">
            <label id="birim_fiyati_lbl" for="birim_fiyati">İskonto Miktar :</label>
            <input name="iskonta_tutari" id="iskonta_tutari" style="width: 230px;" class="text ui-widget-content ui-corner-all" />
         </div>
 
          <div style=" width: 350px; float: left">
               <b style="color: red">Not : </b>  Ekli ürünler stok hesaplamasına dahil değildir.</label>
          </div>  
       
       </fieldset>
    </form>
</div>
<!-- Dialog form sonu -->
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
