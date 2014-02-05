<?php
    require_once '../include/ust.php';
 ?>

<script type="text/javascript">
  $(function(){
     $( "#mainNav" ).find("#urun-gruplari").addClass("active");
  });
  // değerler kontrolü içiin
  var dizi = new Array('grup_ismi' ); 
</script>
 
    <div id='containerHolder'>
       <div id='container' style='background: #fff; height: 500px;'> 
                <h2 class='me'>
                   <a href='../anasayfa.php?page=urun-gruplari'>ÜRÜN GRUPLARI</a>
                   &raquo;
                   <a class='active' href='#'>Ekle</a>
                </h2>
                <div id='main' class='me' >
                    <form onsubmit="return kontrol_dizi(dizi)" action='ekle-islem.php' method="post" class='jNice'>
                       <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Ürün Grubu İsmi :</div>
                            <input name='grup_ismi' id='grup_ismi' type='text'  placeholder='Grup ismi'  />
                       </div>
                       <!-- Onay Butonu -->
                       <div class='kullanici_ekle_satir' style='height:40px;'>
                           <div class='kullanici_ekle_sag' > &nbsp  </div>
                           <input  class='my_button' type='submit' name='onay' value='Grubu Ekle' />
                       </div>
                  </form>
               </div>   
              <div class='clear'></div>
       </div>
</div>
<?php   
      require_once '../include/_alt.php';   
?>
