<?php
    require_once '../include/ust.php';
 ?>
 <script type="text/javascript">
  $(function(){
     $( "#mainNav" ).find("#musteri").addClass("active");
  });
  </script>
    <div id='containerHolder'>
       <div id='container' style='background: #fff; height: 500px;'> 
                <h2 class='me'>
                   <a href='../anasayfa.php?page=kodlar'>MÜŞTERİ KODLARI</a>
                   &raquo;
                   <a class='active' href='#'>Ekle</a>
                </h2>
                <div id='main' class='me' >
                    
                    <script> var dizi = new Array('kod' ,'resizable' ); </script>
                    
                    <form onsubmit="return kontrol_dizi(dizi)" action='kod-ekle-islem.php' method="post" class='jNice'>
          
                       <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Kod :</div>
                            <input name='kod' id='kod' type='text'  placeholder='Kod giriniz'  />
                       </div>
                           <div class='kullanici_ekle_satir' style='height:50px'>
                           <div class='kullanici_ekle_sag' > Acıklama :</div>
                           <textarea id='resizable' name='aciklama' placeholder=' Acıklama giriniz' style='height:50px; float:left; width:300px;' rows='5' cols='20'></textarea>                    
                      </div> 
     
                       <!---- Onay Butonu -------------------------------------->
                       <div class='kullanici_ekle_satir' style='height:40px;'>
                           <div class='kullanici_ekle_sag' > &nbsp  </div>
                           <input  class='my_button' type='submit' name='onay' value='Kodu Ekle' />
                       </div>
                  </form>
               </div>   
              <div class='clear'></div>
       </div>
</div>


<?php   require_once '../include/_alt.php';   ?>
