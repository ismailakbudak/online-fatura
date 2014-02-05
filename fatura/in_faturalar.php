<script type="text/javascript">
  $(function(){
     $( "#mainNav" ).find("#faturalar").addClass("active");
  });
</script>

 <?php 
   // sesssion kontrol
     require_once 'session_kontrol.php';
     require 'my_class/fatura_detay.php';
 ?>
<div id='containerHolder'>
       <div id='container' style="height: 490px;">
                <div id='sidebar'>
                    <ul class='sideNav'>
                    	 <li><a href="anasayfa.php?page=faturalar">İrsaliyeli Faturalar </a></li>
                         <li><a href="fatura/ekle-form.php">İrsaliyeli Fatura Ekle </a></li>
                          <li><a href="#">Normal Faturalar </a></li>
                         <li><a href="fatura/normal-fatura-ekle-form.php">Normal Fatura Ekle </a></li>
                         <li><a href="#">İrsaliye Faturaları </a></li>
                         <li><a href="irsaliye_fatura/fatura-ekle-form.php">İrsaliye Faturası Ekle</a></li>
                    </ul>
                </div>    
            
                <h2>
                   <a href='#'>FATURALAR</a>
                    &raquo;
                   <a class='active' href='#'>İrsaliyeli Faturalar</a>
                </h2>
               
                <div id='main'>
                    <form action='' class='jNice'>
                         <h3>Faturaların Listesi</h3>
                        <table cellpadding='0' cellspacing='0'>
                            <tr>
                                <td>FATURA NO</td>
                                <td>FATURA TARİHİ</td>
                                <td class='action'>İŞLEM</td>
                            </tr>
 <?php
   $db = new fatura_detay();
   $faturalar = $db->listele($sirket_pk);
   
   //SAyfalama yapan kısım
   $toplam_sayfa = ceil(count($faturalar) / 12);
   $sayfa = $_GET['sayfa_no'];
   if(!$sayfa || $sayfa > $toplam_sayfa || $sayfa < 0 || !is_numeric($sayfa) )
      $sayfa = 1;
      
   $baslangic = (($sayfa - 1) * 12);
   $faturalar = $db->fatura_getir_for_sayfa($sirket_pk,$baslangic,12);
   // sayfalama bitiş
   
   if ($faturalar) {
       foreach ($faturalar as $fatura) {
                $html = "  <tr> 
                              <td> {$fatura['fatura_no']} </td>
                              <td> {$fatura['fatura_tarih']} </td>
                              <td class='action' >
                                    <a href='fatura/detay.php?pk={$fatura['pk']}' class='view'> Detay </a>
                                    <a href='fatura/guncelle-form.php?pk={$fatura['pk']}' class='edit'> Güncelle </a>
                                    <a href='fatura/sil.php?pk={$fatura['pk']}' class='delete'> Sil </a> 
                              </td>
                           </tr>";
              echo $html;               
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
                         echo '<a data-no="'.$i.'" class="selected" href="anasayfa.php?page=faturalar&sayfa_no='.$i .'">'.$i .'</a>';
                     }
                     else{
                         echo '<a data-no="'.$i.'" href="anasayfa.php?page=faturalar&sayfa_no='.$i .'">'.$i .'</a>';
                     }
               }
               else{
                     if($i > $sayfa-3 &&  $i < $sayfa + 3 ){
                          
                          if($i == $sayfa)
                             echo '<a data-no="'.$i.'" class="selected" href="anasayfa.php?page=faturalar&sayfa_no='.$i .'">'.$i .'</a>';
                           
                          else
                              echo '<a data-no="'.$i.'" href="anasayfa.php?page=faturalar&sayfa_no='.$i .'">'.$i .'</a>';
                     
                     }
                     else
                         echo '<a data-no="'.$i.'" class="nokta" href="anasayfa.php?page=faturalar&sayfa_no='.$i .'">.</a>';
                     
                   }
           }
       ?>
       </div>
</div>  