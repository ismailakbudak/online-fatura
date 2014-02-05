 /*
  *
  * 21.07.2013
  **********************İsmail AKBUDAK*/  
  
    // üzerine geldiğinde numarasını göstermeyi sağlamak için
    $(function() {   
       $( "#page" ).on("mouseover" ,"a" ,function(){
           var no = $(this).data('no');
           if($(this).text(no) == "."){
               $(this).text(no);
           }
       }).on("mouseleave","a",function(){
             if($(this).hasClass("nokta")){
                 $(this).text(".");  
             }
        });
    });
  
   /*Session zamanı için değer üretir */
  function startclock(id,zaman)
  {
     var zaman2 = parseInt(zaman); 
     var dk = parseInt(zaman2/60);
     var sn = zaman2%60;
   
     zaman2 = zaman2 - 1;  
     var value='<p> Oturum : <b>' + dk +':'+sn  +'</b> </p>';
     $(id).html(value);
     
     if (zaman2 != -1) {
         setTimeout("startclock('"+ id +"','"+ zaman2 + "')",1000);
     };
  } 

   //Parametrede aldığı detay dizisindeki elemanların değerleri boş mu dolumu kontrol eder 
  function kontrol_dizi(dizi) {
      sta = true; //varsayılan olarak gönderim değerimiz true 
      $.each(dizi, function () {
          if ($('#' + this).val() == '' || $('.' + this).val() == '0' ) {
               sta = false;  //ve tabii ki gönderimi kesmek için bu değeri false yapıyoruz.
               myClick('.hatali', 'Eksik bilgi girdiniz..', 'UYARI');
               return false;
          }
      });
      if (sta == true) {
          return true;
      }
      else {
          myClick('.hatali', 'Eksik bilgi girdiniz..', 'UYARI');
          return false;
      }
  }
  
   // Parametrede aldığı detay dizisindeki elemanların değerleri boş mu dolumu kontrol eder
  function kontrol_dizi_top(dizi) {
      sta = true; //varsayılan olarak gönderim değerimiz true 
      $.each(dizi, function () {
          if ($('#' + this).val() == '' || $('.' + this).val() == '0' ) {
               sta = false;  //ve tabii ki gönderimi kesmek için bu değeri false yapıyoruz.
               myClicktop('.hatali', 'Eksik bilgi girdiniz..', 'UYARI');
               return false;
          }
      });
      if (sta == true) {
          return true;
      }
      else {
          myClicktop('.hatali', 'Eksik bilgi girdiniz..', 'UYARI');
          return false;
      }
  }
  
   // Parametrede aldığı detay dizisindeki elemanların değerleri boş mu dolumu kontrol eder 
  function kontrol_musteri(dizi) {
      sta = true; //varsayılan olarak gönderim değerimiz true 
      $.each(dizi, function () {
          if ($('#' + this).val() == '' || $('.' + this).val() == '0' ) {
               sta = false;  //ve tabii ki gönderimi kesmek için bu değeri false yapıyoruz.
               myClick('.hatali', 'Eksik bilgi girdiniz..', 'UYARI');
               return false;
          }
      });
      if (sta == true) {
          return true;
      }
      else {
          myClick('.hatali', 'Eksik bilgi girdiniz..', 'UYARI');
          return false;
      }
  }
  
   // girdi id li input değeri girilip girilmediğini kontrol eder 
  function kontrol_yap() {
     if ($('#girdi').val() == ''  ) {
  		       myClick('.hatali','Eksik bilgi girdiniz..','UYARI');
  			  return false;
  		 }
  		 else{
  		     return true;
  	       }
   }
  
   // sirket verilerinin dogru girilip girilmediğini kontol eder
   function kontrol_sirket(){  
       	var detay = new Array('ad','vergi_dairesi','vergi_no');
  	    sta = true; //varsayılan olarak gönderim değerimiz true 
  		$.each(detay, function(){
  		    	if ($('#'+this).val() == ''  ) {
  				    sta = false;  //ve tabii ki gönderimi kesmek için bu değeri false yapıyoruz.
  				}
  			});
          if (sta == true){
  		     	return true;
  		}
  		else {
  			myClick('.hatali','Eksik bilgi girdiniz..','UYARI');
  			return false;	
  		}
  }
  
  // kullanıcı güncellemede #ad girilmiş mi kontrol eder
  function kontrol_by_element() {
          if ($('#ad').val() == ''  ) {
  		       myClick('.hatali','Eksik bilgi girdiniz..','UYARI');
  			  return false;
  		 }
  		 else{
  		     return true;
  	       }
  }
  
  // kullanıcı güncellemede #soyad girilmiş mi kontrol eder
  function kontrol_by_element2() {
          if ($('#soyad').val() == ''  ) {
  		       myClick('.hatali','Eksik bilgi girdiniz..','UYARI');
  			  return false;
  		 }
  		 else{
  		     return true;
  	       }
  }
  
  // kullanıcı güncellemede #kul_ad girilmiş mi kontrol eder
  function kontrol_by_element3() {
          if ($('#kul_ad').val() == ''  ) {
  		       myClick('.hatali','Eksik bilgi girdiniz..','UYARI');
  			  return false;
  		 }
  		 else{
  		     return true;
  	       }
  }
  
  // kullanıcı güncellemede #kul_sifre girilmiş mi kontrol eder
  function kontrol_by_element4() {
          if ($('#kul_sifre').val() == ''  ) {
  		       myClick('.hatali','Eksik bilgi girdiniz..','UYARI');
  			  return false;
  		 }
  		 else{
  		     return true;
  	       }
  }
  
   // kullanıcı ekleme işleminde form verilerinin boş olup olmadığını kontrol eder
   function kontrol(){  
       	var detay = new Array('ad','soyad','kul_ad','kul_sifre');
  	    sta = true; //varsayılan olarak gönderim değerimiz true 
  		$.each(detay, function(){
  		    	if ($('#'+this).val() == ''  ) {
  				    sta = false;  //ve tabii ki gönderimi kesmek için bu değeri false yapıyoruz.
  				}
  			});
          if (sta == true){
          	if ($('#yetki').val() == '0'  ) {
          		    myClick('.hatali','Kullanıcı için yetki seçmediniz..','UYARI');
  				    return false;  //ve tabii ki gönderimi kesmek için bu değeri false yapıyoruz.
  			}
  			else{
  		     	return true;
  			}
  		}
  		else {
  			myClick('.hatali','Eksik bilgi girdiniz..','UYARI');
  			return false;	
  		}
  }
  
  /* Jquery ile uyarı*/
  function myClicktop(id, text, title) {
     $(document).ready(function () {
          $(id).dialog({
              modal: true,
              show: 'bounce',  
              hide: 'highlight',
              height: 150,
              width:250,
              speed: '4000',
              title:  title,
              draggable: false
          }).text(text);
          $(id).closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
         
          setTimeout(function () {
              $(id).dialog("close")
          }, 2000);
      });
  }
  
  /* Jquery ile uyarı*/
  function myClick(id, text, title) {
     $(document).ready(function () {
          $(id).dialog({
              modal: true,
               // titreşim verir  show: 'bounce',  
              hide: 'fade',
              height: 150,
              width:250,
              speed: 'slow',
              title:  title,
              position: { my: "center top", 
                          at: "center top",
                          of: "#main" },
              draggable: false
          }).text(text);
          $(id).closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
         
          setTimeout(function () {
              $(id).dialog("close")
          }, 2000);
      });
  }
  
  /* JQuery ile bilgi  */
  function my (id, text, title) {
    $(document).ready(
    	function() {
         $(id).dialog({
              modal: true,
              show: 'slide',   // titreşim verir  //slide  //highlight  //bounce  // fade
              hide: 'slide',
              height: 170,
              width:370,
              speed: 'slow',
              title:  title,
              draggable: false
          
          }).text(text);
          // üstteki close butonunu kaldırrı
         $(id).closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          
          setTimeout(function () {
              $(id).dialog("close")
          }, 3000);
      });
  }
