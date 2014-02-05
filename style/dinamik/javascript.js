
 /* Jquery ile uyarı*/
  function mesaj(id, text, title) {
     $(document).ready(function () {
          $(id).dialog({
              modal: true,
              show: 'bounce',  
              hide: 'highlight',
              height: 150,
              width:250,
              speed: '4000',
              title:  title,
              position: { my: "center top", 
                          at: "center top",
                          of: "#sonuc" },
              draggable: false
          }).text(text);
          $(id).closest('.ui-dialog').find('.ui-dialog-titlebar-close').show();
         
          setTimeout(function () {
              $(id).dialog("close")
          }, 3400);
      });
  }

$(document).ready(function () {

           var tips = $( "#hata-mesaj" ); 
           $( "#mainNav" ).find("#anasayfa").addClass("active");
         
           $( "#sayfa" ).droppable({
                accept: function( event, ui ) {
                    return true;
                },
                drop: function( event, ui ) {
                }
            });     
                   
           $( "#basliklar" ).delegate(".ui-icon-plusthick" , "click",function(){
                          var value = "   <div class='element'  data-left='13' data-top='13' " + 
                                      " data-id= " + $( this ).parent().data('id') + 
                                      " > " + $( this ).parent().text()  +
                                      "  <a  class='ui-icon ui-icon-minusthick' title='Çıkar' ></a> </div>";
                          $(this).hide(200);
                          $( "#sayfa" ).prepend(value);
                          $(this).parent().parent().fadeOut(function(){
                                   $(this).remove();
                              });
                          yap();
                          hesapla();
                          eleman_yerlestir();
               });
         
           $( "#sayfa" ).delegate(".ui-icon-minusthick","click" , function(){
                    var value = " <li>                    " +
                                "   <div class='element' data-id= " + $( this ).parent().data('id') + "> " +
                                   $( this ).parent().text() +
                                "      <a  class='ui-icon ui-icon-plusthick' title='Ekle' ></a> " + 
                                "   </div>                " + 
                                " </li> " ;
                    $(this).hide(200);
                    $( "#basliklar ul" ).append(value);
                    $(this).parent().fadeOut(250, function(){
                               $(this).remove();
                        });
                    element_sıfırla();
                    hesapla();
                    setTimeout(function() { eleman_yerlestir(); }, 302  );
               });

           function element_sıfırla(){ // elementlerin isim ve pozisyon değerlerini yazan kısmı sıfırlar
                var top = $( "#top" ),
                    left = $( "#left" ),
                    name = $( "#element-name" );
                    
                    top.val("");
                    left.val("")
                    name.text("");      
               }
 
           function hataVer( text ) { // hata mesajı vermek için
                    
                    tips.text( text )
                        .addClass( "ui-state-highlight" );
                        setTimeout(function() {
                                       tips.removeClass( "ui-state-highlight", 2000 );
                                    },200 
                                   );
                        setTimeout(function(){
                            tips.text("");
                        },3000);
               }

           $( "#sayfa .element" ).draggable({
                      revert: "invalid",
                      containment: "#sayfa",
                      opacity: 0.35,
                      scroll: true,
                      stop: function() {
                            var pos_base = $( "#sayfa" ).position(),
                      yazPozisyonTop = $( "#yazPozisyon" ).find("#top"),
                      yazPozisyonSoldan = $( "#yazPozisyon" ).find("#left"),
                      element_name = $( "#element-name" ),
                      positionLeft,
                      positionTop;
                    
                      positionLeft =  ($(this).offset().left - pos_base.left).toFixed(0);
                      positionTop =  ($(this).offset().top - pos_base.top ).toFixed(0);
                      
                      $(this).data().top = positionTop;
                      $(this).data().left = positionLeft;
                      
                      element_name.text( $(this).text());
                      yazPozisyonSoldan.val(positionLeft);
                      yazPozisyonTop.val(positionTop);
                      }       
               });  
      
           $( "#left, #top" ).on( "change", function(){
                 if( isNaN( $(this).val() ) == true  || $(this).val() == ""){ 
                     hataVer("Lütfen Sayı giriniz...");
                     $(this).val("");
                     return;
                } 
                else { 
                     var name = $("#element-name").text(),
                         array = $("#sayfa").find(".element"),
                         pos_base = $( "#sayfa" ).position(),
                         top = parseFloat( $("#top").val() ),
                         left = parseFloat( $("#left").val() ),
                         widthPage = $( "#sayfa" ).width(),
                         heightPage = $( "#sayfa" ).height(),
                         our_element;
                       
                      if ( !(name.length > 2) ) {
                         $(this).val("");
                         hataVer("Nesne seçmediniz..."); 
                         return;
                      }

                      if( !(left > 12) || !(top > 12) ){
                         hataVer("Kenarlara yakınlık çıktıyı bozabilir."); 
                      } 
                      
                      for (var i = array.length - 1; i >= 0; i--) {
                         if (name == $(array[i]).text() ) {
                             our_element = $(array[i]);
                             break;
                         }
                      }
                      
                      if (   pos_base.left <= ( pos_base.left + left ) &&  
                            (pos_base.left + left ) <= (pos_base.left + widthPage - our_element.width() + 5) && /* Border için verilmiş boşluk*/ 
                             pos_base.top <= (pos_base.top + top) &&
                            (pos_base.top + top) <= (pos_base.top + heightPage - our_element.height())
                            ) {
                            top = top + pos_base.top;
                            left = left + pos_base.left;
                            our_element.offset({ top: top , left: left });
                      }
                      else{
                            hataVer("Sınırları Aştınız...");
                          
                            $(this).val("");
                            return;
                      }
                    }
               });

           function yap(){  // yeni eleman eklendikten sonra sürüklenebilir olmasını sağlar
         
             $( "#sayfa .element" ).draggable({
               revert: "invalid",
               containment: "#sayfa",
               opacity: 0.35,
               scroll: true,
               stop: function() {
                  var pos_base = $( "#sayfa" ).position(),
                      yazPozisyonTop = $( "#yazPozisyon" ).find("#top"),
                      yazPozisyonSoldan = $( "#yazPozisyon" ).find("#left"),
                      element_name = $( "#element-name" ),
                      positionLeft,
                      positionTop;
                    
                      positionLeft =  ($(this).offset().left - pos_base.left).toFixed(0);
                      positionTop =  ($(this).offset().top - pos_base.top ).toFixed(0);
                      
                      $(this).data().top = positionTop;
                      $(this).data().left = positionLeft;
                      
                      element_name.text( $(this).text());
                      yazPozisyonSoldan.val(positionLeft);
                      yazPozisyonTop.val(positionTop);
                     }       
                   });
                  
                $( "#sayfa .element" ).on("click", function(){ 
                     var pos_base = $( "#sayfa" ).position(),
                      yazPozisyonTop = $( "#yazPozisyon" ).find("#top"),
                      yazPozisyonSoldan = $( "#yazPozisyon" ).find("#left"),
                      element_name = $( "#element-name" ),
                      positionLeft,
                      positionTop;

                      positionLeft =  ($(this).offset().left - pos_base.left).toFixed(0);
                      positionTop =  ($(this).offset().top - pos_base.top ).toFixed(0);
                      element_name.text( $(this).text());
                      yazPozisyonSoldan.val(positionLeft);
                      yazPozisyonTop.val(positionTop);
                  });
               }  

//////////////////////////////////////////////////////////////////////////////////////////////////////////
// Sayfa Yapısı ile ilgili Kısım /////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////         

           $( "#height, #width" ).on( "change", function(){
                var pos = $( "#sayfa" ),
                    widthVal = parseFloat($("#width").val()),
                    heightVal = parseFloat($("#height").val()),
                    uzunluk_cinsi = $("#uzunluk").val();
                 if(uzunluk_cinsi == 1){
                    if(widthVal >= 200 && heightVal >= 200){   
                        pos.width(widthVal);
                        pos.height(heightVal);
                    }
                    else
                        hesapla_yaz(pos);
                  }
                  else if(uzunluk_cinsi == 2){
                      if(widthVal >= 6 && heightVal >= 6){   
                         pos.width((widthVal * 37.795276).toFixed(2) );
                         pos.height((heightVal * 37.795276).toFixed(2) );
                       }
                       else
                        hesapla_yaz(pos);
                   }
                   
               });
            
           $( "#width-arttir, #width-azalt, #heigth-arttir, #heigth-azalt" ).click(function(){
                
                     var pos = $( "#sayfa" ); 
                     if( $(this).attr('id') == "width-arttir" )
                          pos.width(pos.width() + 37.795276 );
                     else if( $(this).attr('id') == "width-azalt" ){ 
                        if(pos.width() >= 250 )
                           pos.width(pos.width() - 37.795276 );
                      }
                      else if( $(this).attr('id') == "heigth-azalt" ){ 
                         if(pos.height() >= 250 )
                            pos.height(pos.height() - 37.795276 );
                      }
                      else if( $(this).attr('id') == "heigth-arttir" )
                        pos.height(pos.height() + 37.795276 );
       
                      hesapla_yaz(pos);
                      eleman_yerlestir();
            });
         
           $( "#uzunluk").on("change",function() {
            
                hesapla_yaz($( "#sayfa" )); 
            });
            // sayfanın yapısını pkur yazar
           function hesapla_yaz(pos){
                var  uzunluk_cinsi = $("#uzunluk").val(),
                     width = $("#width"),
                     height = $("#height");

                 if( uzunluk_cinsi == 1) { 
                     width.val(pos.width());
                     height.val(pos.height());
                  }
                  else if(uzunluk_cinsi == 2) {
                     var value = 0.02645833;
                     width.val((pos.width() * value).toFixed(2) );
                     height.val((pos.height() * value).toFixed(2) );
                  }
           }
            // Side barın uzunluğunu hesaplar
           function hesapla(){
               var uzunluk = $( "#basliklar" ).find("li").length,
                  yukseklik = $( "#basliklar" ).find(".element").height(),
                  basliklar = $( "#basliklar" ).find("ul");

                basliklar.height( uzunluk  * (yukseklik + 10) );
           }
            // eleamnları yeniden konumlandırır
           function eleman_yerlestir(){
                var elements = $( '#sayfa' ).find('.element');
                for (var i = elements.length - 1; i >= 0; i--) {
                   var eleman = $( elements[i] ),
                       pos_base = $( "#sayfa" ).position(),
                       top = parseFloat( eleman.data('top') ),
                       left = parseFloat( eleman.data('left') ),
                       widthPage = $( "#sayfa" ).width(),
                       heightPage = $( "#sayfa" ).height();
                       
                       top = top + pos_base.top;
                       left = left + pos_base.left;
                       eleman.offset({ top: top , left: left });
                 }
                yap();
           }

           hesapla_yaz( $( "#sayfa" ) );
           hesapla();
           eleman_yerlestir();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Kaydetme işlemi  ////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////         

           $( "#kaydet" ).on("click", function(){
                var array = $("#sayfa").find(".element"), 
                    pos_base = $( "#sayfa" ).position(),
                    positionLeft, 
                    positionTop,
                    veri = ""; 
                if( array.length > 0 ){
                    if ($('#dizayn_adi').val() != '' ) {
                          for (var i = array.length - 1; i > 0; i--) {
                               positionLeft =  ($(array[i]).offset().left - pos_base.left).toFixed(0);
                               positionTop =  ($(array[i]).offset().top - pos_base.top ).toFixed(0);
                               veri +=  $(array[i]).data('id') + "*" + positionLeft + "*" + positionTop + "/" ;
                          }
                          positionLeft =  ($(array[0]).offset().left - pos_base.left).toFixed(0);
                          positionTop =  ($(array[0]).offset().top - pos_base.top ).toFixed(0);
                          veri +=  $(array[0]).data('id') + "*" + positionLeft + "*" + positionTop ;
                          
                           $.ajax({
                                   type: "POST",
                                   url: "dizayn-ekle-islem.php?veri="+veri,
                                   data: $('#form').serialize(),
                                   success: function(ajaxcevap){ 
                                         
                                         if (ajaxcevap == 1) 
                                            window.location = 'dizayn-form.php?msj=Ekleme işlemi başarılı bir şekilde yapıldı...';
                                         else
                                             $('#sonuc').html(ajaxcevap).slideDown('slow');
                                          
                                   },
                                   error : function() {
                                          mesaj('.hatali', 'Hata oluştu işlem yapılamadı', 'UYARI');
                                   } 
                            });
                         }
                         else {
                            mesaj('.hatali', 'Dizayn ismi girmediniz..', 'UYARI');
                            return ;
                         }
                  }
                  else {
                    mesaj('.hatali','Hiç eleman eklemediniz...','SONUÇ');
                    return false; 
                  }
            });
      });