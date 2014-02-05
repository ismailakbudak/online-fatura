<?php
    require_once '../include/ust.php';

 ?>
 
 <script>
  function ajax() {
      $.ajax({
            type: "POST",
            url: "ajax-musteri-kodu.php",
            data: $('#form').serialize(),
            success: function(ajaxcevap2){ 
                $('#musteri_kod_div').html(ajaxcevap2).slideDown('slow');
            },
            error : function() {
              ajax();
            } 
        }); 
  }
  $(function(){
     $( "#mainNav" ).find("#musteri").addClass("active");
  });   
 </script>
   
<div id='containerHolder'>
    <div id='container' style='background: #fff; height: 500px;'> 
        <h2 class='me'>
            <a href='../anasayfa.php?page=musteriler'>MÜŞTERİLER</a>
            &raquo;
           <a class='active' href='#'>Ekle</a>
        </h2>
         <script>
             var dizi = new Array('musteri_kod','resizable','musteri_unvan','sirket','vergi_dairesi','vergi_no');
         </script>
     
        <div id='main'class="me">
            <form id="form" onsubmit='return kontrol_musteri(dizi)' action='ekle-islem.php' method='post' class='jNice'> 
   
               
                <div class='my' style="margin-top: 2px;" > 
                      <div class='kullanici_ekle_sag' > Müşteri Kodu  :</div>
                      <div class='myy' id="musteri_kod_div"> <!--- AJAX ile bilgileri geliyor -----></div>
               </div>
                
          	   <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Müşteri Unvan :</div>
                  <input name='musteri_unvan' id='musteri_unvan' placeholder='Müşteri Unvan' type='text' />
                </div>  
   
                <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Vergi Dairesi Adı :</div>
                  <input id='vergi_dairesi' type='text'  placeholder='Vergi Dairesi Adı ' name='vergi_dairesi' />
                </div>
      
               <div class='kullanici_ekle_satir'>
                  <div class='kullanici_ekle_sag' > Vergi No :</div>
                  <input id='vergi_no' type='number'  placeholder='Vergi no ' name='vergi_no' />
                </div>
              
                <div class='kullanici_ekle_satir' style='height:50px'>
                  <div class='kullanici_ekle_sag' > Adres :</div>
                  <textarea id='resizable' name='adres' placeholder=' Adres' style='height:50px; float:left; width:300px;' rows='5' cols='20'></textarea>                    
                </div> 
               
				 <div class='kullanici_ekle_satir' style='height:40px;'>
                        <div class='kullanici_ekle_sag' > &nbsp  </div>
                        <input  class='my_button' type='submit' name='onay' value='Müşteri Ekle' />
                </div>
            
	          </form>
            </div>   
           <div class='clear'></div>
       </div>
</div>     
  <script>
       ajax();
</script>
  
<?php   require_once '../include/_alt.php';   ?>