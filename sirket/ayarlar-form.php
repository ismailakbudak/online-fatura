<?php

    require '../include/ust.php';
    require  '../my_class/sirket_ayar.php';     
      
    $db = new sirket_ayar();
    $sirket_ayar = $db->ayar_getir_sirket( $sirket_pk );

    if (!$sirket_ayar) {
         $mesaj = "Şirket ayar bilgileri çekilemedi..";
         redirect('../anasayfa.php?page=sirket&msj='.$mesaj);
    }
    
?>

<script type="text/javascript">
      $(function () {
         $( "#mainNav" ).find("#anasayfa").addClass("active");
      });

     var dizi = new Array('kurus_ayar');

</script>

<div id='containerHolder'>
       <div id='container' style='background: #fff; height: 500px;'>
           <h2 class="me">
                   <a  href='../anasayfa.php'>ANA SAYFA</a>
                   &raquo;
                   <a href='../anasayfa.php?page=sirket'>ŞİRKET</a>
                   &raquo;
                   <a class='active' href='#'>Ayarlar</a>
            </h2>    
            <div id='main' class="me">
                <form onsubmit='return kontrol_dizi(dizi)' action="sirket-ayar-güncelle-islem.php?sirket_ayar_pk=<?php echo $sirket_ayar['pk']  ?>" method="post"  class='jNice'  > 
                    <h3>Şirket Ayarları</h3>

                    <div class='kullanici_ekle_satir'>
                      <div class='kullanici_ekle_sag' > Kuruş Kısmı : </div>
                      <input value="<?php echo $sirket_ayar['kurus_ayar'] ?>" name="kurus_ayar" id="kurus_ayar" type='number'  max="8" min="1"  />
                    </div>                
          

                    <div class='kullanici_ekle_satir'>
                           <div class='kullanici_ekle_sag' > &nbsp  </div>
                           <input  class='my_button' type='submit' name='onay' value='Ayarları Güncelle' />
                     </div> 

                </form>
             </div>    
             <div class='clear'></div>
       </div>
</div>

<?php  require '../include/_alt.php';  ?>  