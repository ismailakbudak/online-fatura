 <?php 

      // sesssion kontrol
     require_once 'session_kontrol.php';
     require  'my_class/sirket_detay.php';     
    
    $db = new sirket_detay();
    $sirket = $db->sirket_getir($sirket_pk);
    
    //  Kullanıcı bilgileri gelmez ise geri yönlendirir 
    if (!$sirket) {
         $mesaj = "Şirket bilgileri çekilemedi..";
         redirect('anasayfa.php?page=sirket&msj='.$mesaj);
    }

 ?>

 <script type="text/javascript">
     $(function () {
           $( "#mainNav" ).find("#anasayfa").addClass("active");
      });
</script>

<div id='containerHolder'>
       <div id='container' style="height: 490px;">
            <div id='sidebar'>
                <ul class='sideNav'>
                    <li><a href="sirket/guncelle-form.php">Şirketi Güncelle </a></li>
                    <li><a href="sirket/ayarlar-form.php">Şirket Ayarları </a></li>
                    <li><a href="dinamik_fatura/dizayn-form.php">Fatura Dizaynı Ekle</a> </li>
                    <li><a href="dinamik_fatura/dizayn-edit.php">Fatura Dizaynı Güncelle</a> </li>
                </ul>
             </div>                
             <h2>
                <a  href='anasayfa.php'>ANA SAYFA</a>
                 &raquo;
                 <a class='active' href='#'>ŞİRKET</a>
             </h2>
             <div id='main'>
                 <form onsubmit='return kontrol_sirket()' action='guncelle-islem.php?pk=<?php echo $sirket['pk'] ?>' method='post' class='jNice'> 
                    <h3>Şirket Bilgileri</h3>
                    <div class='kullanici_ekle_satir'>
                        <div class='kullanici_ekle_sag' > Şirket İsim :</div>
                         <label  class='sirket_lbl'>
                              <?php echo $sirket['sirket_isim'] ?>
                         </label>
                    </div>
                    <div class='kullanici_ekle_satir'>
                       <div class='kullanici_ekle_sag' > Vergi Dairesi Adı :</div>
                       <label  class='sirket_lbl'>
                           <?php echo $sirket['vergi_dairesi'] ?>
                       </label>
                     </div>
                     <div class='kullanici_ekle_satir'>
                       <div class='kullanici_ekle_sag' > Vergi No :</div>
                       <label  class='sirket_lbl'>
                         <?php echo $sirket['vergi_no'] ?>
                        </label>    
                     </div>
                     <div class='kullanici_ekle_satir'>
                         <div class='kullanici_ekle_sag' > Şirket Eposta :</div>
                               <label  class='sirket_lbl'>
                                  <?php echo $sirket['eposta'] ?>
                            </label>
                     </div>
                     <div class='kullanici_ekle_satir'>
                         <div class='kullanici_ekle_sag' > Şirket Web Adresi:</div>
                        <label  class='sirket_lbl'>
                            <?php echo $sirket['web'] ?> 
                        </label>    
                    </div>
                    <div class='kullanici_ekle_satir' style='height:130px'>
                         <div class='kullanici_ekle_sag' > Açıklama :</div>                        
                         <label class='sirket_lbl'>
                               <?php echo $sirket['aciklama']  ?>
                         </label>                    
                    </div> 
                </form>
             </div>    
             <div class='clear'></div>
       </div>
</div>