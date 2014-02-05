<?php

    require '../include/ust.php';
    require  '../my_class/sirket_detay.php';     
    
    $db = new sirket_detay();
    $sirket = $db->sirket_getir($sirket_pk);
    
    /*  Kullanıcı bilgileri gelmez ise geri yönlendirir  */
    if (!$sirket) {
         $mesaj = "Şirket bilgileri çekilemedi..";
         redirect('../anasayfa.php?page=sirket&msj='.$mesaj);
    }
    
?>

<script type="text/javascript">
  $(function () {
     $( "#mainNav" ).find("#anasayfa").addClass("active");
  });
</script>

<div id='containerHolder'>
       <div id='container' style='background: #fff; height: 500px;'>
           <h2 class="me">
                   <a  href='../anasayfa.php'>ANA SAYFA</a>
                   &raquo;
                   <a href='../anasayfa.php?page=sirket'>ŞİRKET</a>
                   &raquo;
                   <a class='active' href='#'>Güncelle</a>
            </h2>    
            <div id='main' class="me">
                <form onsubmit='return kontrol_sirket()' action='guncelle-islem.php?pk=<?php echo $sirket['pk'] ?>' method='post' class='jNice'> 
                    <h3>Şirket Bilgileri</h3>
                    <div class='kullanici_ekle_satir'>
                      <div class='kullanici_ekle_sag' > Şirket İsim :</div>
                      <input value='<?php echo $sirket['sirket_isim'] ?>' id='ad' type='text'  placeholder='Şirket İsim ' name='sirket_isim' />
                    </div>                
                    <div class='kullanici_ekle_satir'>
                       <div class='kullanici_ekle_sag' > Vergi Dairesi Adı :</div>
                       <input value='<?php echo $sirket['vergi_dairesi'] ?>' id='vergi_dairesi' type='text'  placeholder='Vergi Dairesi Adı ' name='vergi_dairesi' />
                    </div>
                    <div class='kullanici_ekle_satir'>
                       <div class='kullanici_ekle_sag' > Vergi No :</div>
                       <input value='<?php echo $sirket['vergi_no'] ?>' id='vergi_no' type='number'  placeholder='Vergi no ' name='vergi_no' />
                    </div>    
                    <div class='kullanici_ekle_satir'>
                         <div class='kullanici_ekle_sag' > Şirket Eposta :</div>
                         <input value='<?php echo $sirket['eposta'] ?>' id='eposta' type='email'  placeholder='Opsiyonel Şirket Eposta Adresi ' name='eposta' />
                    </div>
                    <div class='kullanici_ekle_satir'>
                         <div class='kullanici_ekle_sag' > Şirket Web Adresi:</div>
                         <input value='<?php echo $sirket['web'] ?>' id='web' type='text'  placeholder=' Opsiyonel Şirket Web Adresi' name='web' />
                    </div>
                    <div class='kullanici_ekle_satir' style='height:50px'>
                         <div class='kullanici_ekle_sag' > Açıklama :</div>
                         <textarea id='resizable' name='aciklama' style='height:50px; float:left; width:300px;' rows='5' cols='20'> <?php echo $sirket['aciklama'] ?></textarea>                    
                    </div> 
                    <div class='kullanici_ekle_satir'>
                           <div class='kullanici_ekle_sag' > &nbsp  </div>
                           <input  class='my_button' type='submit' name='onay' value='Şirketi Güncelle' />
                     </div> 
                </form>
             </div>    
             <div class='clear'></div>
       </div>
</div>

<?php  require '../include/_alt.php';  ?>  