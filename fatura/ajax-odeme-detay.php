 <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    height:20px;
    /* support: IE7 */
    *height: 1.7em;
    *top: 0.1em;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 0.1em;
  }
  </style>
  <script>
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
        if ( this.input.val() != "" ) {
            
              var data = this.input.val().toString().toUpperCase();
             //myClick('.hatali',  , 'Uyarı');
         
              $( ".hatali2" ).dialog({
                   resizable: false,
                   title: 'ONAY',
                   modal: true, 
                   buttons: {
                       
                       "Ödeme Türünü Ekle": function() {
                           /* ekleme işlemi yapılacak */
                           
                             $.ajax({
                                type: "POST",
                                url: "ajax-odeme-detay-ekle.php?data="+data,
                                data: $('#form').serialize(),
                                success: function(ajaxcevap2){
                                  
                                    var yazi = "";
                                   
                                    if (ajaxcevap2 == 1)  
                                    {    
                                       yazi = 'Başarılı bir şekilde eklendi..';
                                       $.ajax({
                                          type: "POST",
                                          url: "ajax-odeme-detay.php?data="+data,
                                          data: $('#form').serialize(),
                                          success: function(ajaxcevap2){ 
                                                  $('#odeme').html(ajaxcevap2).slideDown('slow');
                                          },
                                          error : function() {
                                                  alert('Hata oluştu..');
                                          } 
                                        });  
                                    }else
                                        yazi = 'Ödeme Detay eklenemedi..';
                                    
                                    $( ".hatali2" ).dialog({
                                          resizable: false,
                                          title: 'SONUÇ',
                                          modal: true,
                                          buttons:{
                                              'Tamam':function(){
                                                  $(this).dialog('close');
                                              }
                                          } 
                                     }).text(yazi);
                                },
                                error : function() {
                                    alert('Hata oluştu..');
                                 } 
                             });  
                           
                            $( this ).dialog( "close" );
                        },
                        'Hayır': function() {
                            $( "#odeme_detay" ).children().first().val(data);
                            
                             // alert($( "#odeme_detay" ).children().first().val());
                             $( this ).dialog( "close" );
                        }
                   }
               }).text('Ödeme Türü : ' + this.input.val().toString().toUpperCase() + ' Bu ödeme türünü veritabanına eklemek ister misiniz?');
               $(".hatali2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
               
               // kapatma ve boş geçilme durumlarında içinde ne varsa onu yazar
               $( "#odeme_detay" ).children().first().val(this.input.val().toString().toUpperCase());
            
        }else
        {
              $( "#odeme_detay" ).children().first().val("0");
        }
        /*
        this.input
          .val( "" )
          .attr( "title", value + " eşleşen veri yok.." )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
       */
        this.input.data( "ui-autocomplete" ).term = "";
      },
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );

  $(function() {
    $( "#odeme_detay" ).combobox(); 
     $("#odeme_detay").children().first().prop({
       selected: true
     });
  });
  </script>
<?php
      error_reporting(0);
      require_once '../my_class/odeme_detay.php';
      $odeme_tur = $_GET['data'];
   
          echo ' <select id="odeme_detay" name="odeme_detay" class="odeme_detay"  > ';
          if ($_GET['data']){ 
                echo  ' <option value="'.$odeme_tur.'" selected="selected" >'. $odeme_tur .'</option>  ';
          }
          else {
               echo  ' <option value="0" selected="selected" ></option>  ';
          }     
       $db = new odeme_detay();
       $odemeler = $db->listele();
       if ($odemeler) {
         foreach ($odemeler as  $row) {
             if(strcmp($odeme_tur, $row['odeme_tur']) == 0){
                   echo "  <option selected value='{$row['odeme_tur']}' > {$row['odeme_tur']} </option> ";           
              }
             else {
                 echo "  <option value='{$row['odeme_tur']}' > {$row['odeme_tur']} </option> "; 
             }
         }
       }
       echo "</select>";
    
?>   