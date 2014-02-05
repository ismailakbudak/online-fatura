<script type="text/javascript">
  $(function(){
     $( "#mainNav" ).find("#musteri").addClass("active");
  });
</script>

 <?php 
     // sesssion kontrol
     require_once 'session_kontrol.php';
     require_once ('my_class/musteri_detay.php');
 ?>
<div id='containerHolder'>
       <div id='container' style="height: 490px;">
                <div id='sidebar'>
                    <ul class='sideNav'>
                        <li><a href='musteri/ekle-form.php'>Müşteri Ekle </a></li>
                         <li><a href='anasayfa.php?page=kodlar'>Müşteri Kodları </a></li>
                         <li><a href='musteri/kod-ekle-form.php'>Müşteri Kodu Ekle </a></li>
                    </ul>
                </div>    
            
                <h2>
                   <a class='active' href='#'>MÜŞTERİLER</a>
                </h2>
               
                <div id='main'>
                    <form action='' class='jNice'>
                         <h3>Müşteriler Listesi</h3>
                        <table cellpadding="0" cellspacing="0"  >
                            <tr class="odd">
                               <td>  MÜŞTERİ UNVANI </td>
                               <td>  MÜŞTERİ KODU </td>
                               <td  class="action">  İŞLEM </td>
                           </tr>      
                      <?php
                         $db = new musteri_detay();
                         $musteriler = $db->listele($sirket_pk);
                      
                         //SAyfalama yapan kısım
                        $toplam_sayfa = ceil(count($musteriler) / 12);
                        $sayfa = $_GET['sayfa_no'];
                        if(!$sayfa || $sayfa > $toplam_sayfa || $sayfa < 0 || !is_numeric($sayfa) )
                           $sayfa = 1;
                           
                        $baslangic = (($sayfa - 1) * 12);
                        $musteriler = $db->musteri_getir_for_sayfa($sirket_pk,$baslangic,12);
                        // sayfalama bitiş
                        
                          if ($musteriler) {
                             foreach ($musteriler as  $row) {
                                     
                                echo" <tr class='odd'>
                                          <td>  {$row['musteri_unvan']} </td>                                
                                          <td>  {$row['musteri_tabela']} </td>
                                          <td class='action'>
                                             <a href='musteri/detay.php?pk={$row['pk']}' class='view' >Detay</a>
                                             <a href='musteri/guncelle-form.php?pk={$row['pk']}' class='edit'>Güncelle</a>
                                             <a href='musteri/sil.php?pk={$row['pk']}' class='delete'>Sil</a>
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
     <!------ SAYFALAMA için GEREKLİ ---------->
       <div id="page" >
        <?php
          for($i=1;$i<=$toplam_sayfa;$i++){
               if ($i < 4 || $i > ( $toplam_sayfa - 3)  ) {
                     if($i == $sayfa){
                         echo '<a data-no="'.$i.'" class="selected" href="anasayfa.php?page=musteriler&sayfa_no='.$i .'">'.$i .'</a>';
                     }
                     else{
                         echo '<a data-no="'.$i.'" href="anasayfa.php?page=musteriler&sayfa_no='.$i .'">'.$i .'</a>';
                     }
               }
               else{
                     if($i > $sayfa-3 &&  $i < $sayfa + 3 ){
                          
                          if($i == $sayfa)
                             echo '<a data-no="'.$i.'" class="selected" href="anasayfa.php?page=musteriler&sayfa_no='.$i .'">'.$i .'</a>';
                           
                          else
                              echo '<a data-no="'.$i.'" href="anasayfa.php?page=musteriler&sayfa_no='.$i .'">'.$i .'</a>';
                     
                     }
                     else
                         echo '<a data-no="'.$i.'" class="nokta" href="anasayfa.php?page=musteriler&sayfa_no='.$i .'">.</a>';
                     
                   }
           }
       ?>
       </div>
</div>  

