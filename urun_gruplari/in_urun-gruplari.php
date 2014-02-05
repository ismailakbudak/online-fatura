 <?php 
     require_once 'session_kontrol.php';
     require_once 'my_class/urun_grup.php';
 ?>


<script type="text/javascript">
  $(function(){
     $( "#mainNav" ).find("#urun-gruplari").addClass("active");
  });
</script>
 
<div id='containerHolder' >
       <div id='container' style="height: 490px;">
                <div id='sidebar'>
                    <ul class='sideNav'>
                        <li><a href="urun_gruplari/ekle-form.php">Ürün Grubu Ekle</a></li>
                    </ul>
                </div>                
                <h2>
                   <a class='active' href='#'>ÜRÜN GRUPLARI</a>
                </h2>
                <div id='main'>
                    <form action='' class='jNice'>
                        <h3>Ürünler Grupları Listesi</h3>
                        <table cellpadding='0' cellspacing='0'>
                            <tr>
                                <td>ÜRÜN GRUBU İSMİ </td>
                                <td class='action'>İŞLEM</td>
                            </tr>
                             <?php
                                 $db = new urun_grup();                   
                                 $gruplar = $db->grup_getir_sirket_fk($sirket_pk);
                                
                                
                                 //SAyfalama yapan kısım
                                 $toplam_sayfa = ceil(count($gruplar) / 12);
                                 $sayfa = $_GET['sayfa_no'];
                                 if(!$sayfa || $sayfa > $toplam_sayfa || $sayfa < 0 || !is_numeric($sayfa) )
                                    $sayfa = 1;
                                    
                                 $baslangic = (($sayfa - 1) * 12);
                                 $gruplar = $db->grup_getir_for_sayfa($sirket_pk,$baslangic,12);
                                 // sayfalama bitiş
                                 
                                if ($gruplar) {
                                    foreach ($gruplar as $grup) {
                                         echo "<tr>
                                                  <td> {$grup['grup_ismi']} </td>
                                                  <td class='action'>
                                                    <a href='urun_gruplari/guncelle-form.php?pk={$grup['pk']}'  class='view' >Güncelle</a>
                                                    <a href='urun_gruplari/sil.php?pk={$grup['pk']}'  class='delete'>Sil</a>
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
              if ($i < 4 || $i > ($toplam_sayfa - 3)  ) {
                     if($i == $sayfa)
                         echo '<a data-no="'.$i.'" class="selected" href="anasayfa.php?page=urun-gruplari&sayfa_no='.$i .'">'.$i .'</a>';
                     else
                         echo '<a data-no="'.$i.'" href="anasayfa.php?page=urun-gruplari&sayfa_no='.$i .'">'.$i .'</a>';
              }
              else{
                     if($i > $sayfa-3 &&  $i < $sayfa + 3 ){
                          if($i == $sayfa)
                             echo '<a data-no="'.$i.'" class="selected" href="anasayfa.php?page=urun-gruplari&sayfa_no='.$i .'">'.$i .'</a>';
                          else
                              echo '<a data-no="'.$i.'" href="anasayfa.php?page=urun-gruplari&sayfa_no='.$i .'">'.$i .'</a>';
                     }
                     else
                         echo '<a data-no="'.$i.'" class="nokta" href="anasayfa.php?page=urun-gruplari&sayfa_no='.$i .'">.</a>';
              }
           }
       ?>
       </div>
</div>  