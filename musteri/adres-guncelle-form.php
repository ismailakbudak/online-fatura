<?php 
    /**
     * session bilgisi kontrol edilir
     */ 
    error_reporting(0);
    require_once '../include/ust.php';
    require_once ('../my_class/musteri_detay.php');
    require_once '../my_class/adres.php'; 
    require_once '../my_class/sirket_detay.php';
   
    /**
     * kullanıcı bilgileri gelmiş mi kontrol ediliyor
     */
     $musteri_pk = $_GET['musteri_pk'];
     $adres_pk = $_GET['adres_pk'];
     
    if (!$musteri_pk) {
         $mesaj = "Müşteri bilgileri eksik....";
         redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
    }
    
     $db = new musteri_detay();   
     $musteri = $db->musteri_getir2($musteri_pk);
     if (!$musteri){ 
         $mesaj = "Müşteri bilgileri eksik geldiği için adres ekleme yapılamıyor..";
         redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);  
     }
    
?>  
<script >
       $(function(){
          $( "#mainNav" ).find("#musteri").addClass("active");
       });
       function ajax() {
          $.ajax({
            type: "POST",
            url: "ajax-adres.php",
            data: $('#form').serialize(),
            success: function(ajaxcevap){ 
                $('.adresbilgileri').html(ajaxcevap).slideDown('slow');
            },
            error: function() {
               ajax();
            }          
        });
        
        $.ajax({
            type: "POST",
            url: "ajax-telefon.php",
            data: $('#form').serialize(),
            success: function(ajaxcevap2){ 
                $('.telefonbilgileri').html(ajaxcevap2).slideDown('slow');
            },
            error: function() {
               ajax()
            } 
        }); 
      }
</script>
      <div id='containerHolder'  style='margin-bottom: 10px;'>
        <div id='container' style='background: #fff; height: auto;'> 
              
                <h2 class="me">
                   <a href='../anasayfa.php?page=musteriler'>MÜŞTERİLER</a>
                   &raquo;
                  <a href='../musteri/detay.php?pk=<?php echo $musteri_pk; ?>'>Detay</a>
                   &raquo;
                 <a class='active' href='#'>Adres Güncelle</a>
                </h2>
               
                <div id='main' class="me" >
                      <h3 style=' font-size:16px;'>  
                        Şu anda işlem yaptığınız müşterinin Ünvanı : 
                        <b style='color:#C66653'>
              <?php          echo strtoupper($musteri['musteri_unvan']); ?>
                        </b>
                    </h3>
                    <form id="form" method="post"  class='jNice'>
                    
                      <div class='my' > 
                         <div class='kullanici_ekle_sag' > Adres Başlıkları :</div>  
                         <div class='myy'>
                             <select  name='adresler'  onchange="javascript:ajax();" >
<?php 
    // adres bilgileri çekilecek olan müşteri
     
    $db = new adres();
    $adresler = $db->musteri_adresleri($musteri_pk);
    
    if ($adresler) {
      foreach ($adresler as $row) {
           if ($adres_pk == $row['pk'] ) {
                echo "<option selected value='{$row['pk']}'> {$row['baslik']} </option>";
           }
           else {
               echo "<option value='{$row['pk']}'> {$row['baslik']} </option>";
           } 
          
       }
    }
?>                                      
                             </select>
                         </div>
                    </div>            
                  </form>
                  
               <div id='main'  class="adresbilgileri" style='float:left; '>
                
                </div>
                <div id='main' class="telefonbilgileri" style='float:left;'> 
               </div>
            
               </div>   
              <div class='clear'></div>
       </div>
</div>  
  
<script>
    ajax();
</script>    
<?php    
   require_once '../include/_alt.php';
?>
                 
                      