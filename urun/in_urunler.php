 <?php 
       // sesssion kontrol
     require_once 'session_kontrol.php';
     require_once 'my_class/urunler.php';
 ?>

<script >
     $(function(){
        $( "#mainNav" ).find("#urunler").addClass("active");
     });
</script>
  
<div id='containerHolder'>
       <div id='container' style="height: 490px;">
                <div id='sidebar'>
                    <ul class='sideNav'>
                        <li><a href="urun/ekle-form.php">Ürün Ekle</a></li>
                         <li><a href="urun/stok-ekle-form.php"> Stok'a Ürün Ekle</a></li>
                    </ul>
                </div>    
                <h2>
                   <a class='active' href='#'>ÜRÜNLER</a>
                </h2>
                <div id='main'>
                    <form action='' class='jNice'>
                        <h3>Ürünler Listesi</h3>
                        <table cellpadding='0' cellspacing='0'>
                            <tr>
                                <td>ÜRÜN KODU</td>
                                 <td> ÜRÜN İSMİ</td>
                                <td class='action'>İŞLEM</td>
                            </tr>
                             <?php
                                 $db = new urunler();                   
                                 $urunler = $db->urun_getir_sirket_pk($sirket_pk);
                                 
                                   // Sayfalama yapan kısım
                                  $toplam_sayfa = ceil(count($urunler) / 12);
                                  $sayfa = $_GET['sayfa_no'];
                                  if(!$sayfa || $sayfa > $toplam_sayfa || $sayfa < 0 || !is_numeric($sayfa) )
                                     $sayfa = 1;
                                     
                                  $baslangic = (($sayfa - 1) * 12);
                                  $urunler = $db->urun_getir_for_sayfa($sirket_pk,$baslangic,12);
                                  // sayfalama bitiş
                                 
                                 if ($urunler) {
                                     foreach ($urunler as $urun) {
                                         echo "<tr>
                                                   <td> {$urun['urun_kodu']}</td>
                                                   <td>  {$urun['urun_ismi']}  </td>
                                                   <td class='action'>
                                                     <a href='urun/detay-form.php?pk={$urun['pk']}'  class='view' >Detay </a>
                                                     <a href='urun/guncelle-form.php?pk={$urun['pk']}'  class='edit' >Güncelle</a>
                                                     <a href='urun/sil.php?pk={$urun['pk']}'  class='delete'>Sil</a>
                                                   </td>
                                               </tr>";                              
                                     }
                                 }                   
                             ?>                                
                        </table>    
                    </form>
                </div>
                <div class='clear'></div>
       </div>
       
       <!-- SAYFALAMA için GEREKLİ -->
       <div id="page" >
       <?php
          for($i=1;$i<=$toplam_sayfa;$i++){
               if ($i < 4 || $i > ( $toplam_sayfa - 3)  ) {
                     if($i == $sayfa)
                         echo '<a data-no="'.$i.'" class="selected" href="anasayfa.php?page=urunler&sayfa_no='.$i .'">'.$i .'</a>';
                     else
                         echo '<a data-no="'.$i.'" href="anasayfa.php?page=urunler&sayfa_no='.$i .'">'.$i .'</a>';
               }
               else{
                     if($i > $sayfa-3 &&  $i < $sayfa + 3 ){
                          if($i == $sayfa)
                              echo '<a data-no="'.$i.'" class="selected" href="anasayfa.php?page=urunler&sayfa_no='.$i .'">'.$i .'</a>';
                          else
                              echo '<a data-no="'.$i.'" href="anasayfa.php?page=urunler&sayfa_no='.$i .'">'.$i .'</a>';
                     }
                     else
                         echo '<a data-no="'.$i.'" class="nokta" href="anasayfa.php?page=urunler&sayfa_no='.$i .'">.</a>';
              }
           }
       ?>
       </div>
</div>  