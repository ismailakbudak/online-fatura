<?php

    require '../include/ust.php';
    require '../my_class/urun_grup.php';
    
     $grup_pk = $_GET['pk'];
     if (!$grup_pk){
          $mesaj = 'Ürün Grubu bilgileri eksik geldi..';
          redirect('../anasayfa.php?page=urun-gruplari&msj='.$mesaj);
     }
     
     $db = new urun_grup();
     $grup = $db->grup_getir_grup_pk($grup_pk);
    
     if (!$grup) {
          $mesaj = 'Ürün Grubu bilgileri veritabanından çekilemedi..';
          redirect('../anasayfa.php?page=urun-gruplari&msj='.$mesaj);
     }   
 ?>

 <script type="text/javascript">
  $(function(){
     $( "#mainNav" ).find("#urun-gruplari").addClass("active");
  });
  // değer kontrolü için
  var dizi = new Array('grup_ismi' );
</script>
 
    <div id='containerHolder'>
       <div id='container' style='background: #fff; height: 500px;'> 
                <h2 class='me'>
                   <a href='../anasayfa.php?page=urun-gruplari'>ÜRÜN GRUPLARI</a>
                   &raquo;
                   <a class='active' href='#'>Güncelle</a>
                </h2>
                <div id='main' class='me' >
                    <form onsubmit="return kontrol_dizi(dizi)" action='guncelle-islem.php?pk=<?php echo $grup_pk ?>' method="post" class='jNice'>
                       <div class='kullanici_ekle_satir'>
                            <div class='kullanici_ekle_sag' > Ürün Grubu İsmi :</div>
                            <input name='grup_ismi' value=" <?php echo $grup['grup_ismi'] ?> " id='grup_ismi' type='text'  placeholder='Grup ismi'  />
                       </div>
                       <!-- Onay Butonu -->
                       <div class='kullanici_ekle_satir' style='height:40px;'>
                           <div class='kullanici_ekle_sag' > &nbsp  </div>
                           <input  class='my_button' type='submit' name='onay' value='Grubu Güncelle' />
                       </div>
                  </form>
               </div>   
              <div class='clear'></div>
       </div>
</div>
<?php   
      require_once '../include/_alt.php';   
?>
