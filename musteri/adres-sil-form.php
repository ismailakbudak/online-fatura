<?php

     // session kontrolleri yapan sayfa
     require_once '../include/ust.php';   
    
     require_once '../my_class/adres.php';  
     require_once '../my_class/telefon.php'; 
     require_once '../my_class/musteri_detay.php'; 
     
    /**
     * kullanıcı bilgileri gelmiş mi kontrol ediliyor
     */
    $musteri_pk = $_GET['musteri_pk'];
    
    if (!$musteri_pk){ 
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
 <script>  
    $(function(){
       $( "#mainNav" ).find("#musteri").addClass("active");
    }); 
   function ajax() {
        $.ajax({
            type: "POST",
            url: "ajax-telefon-sil.php",
            data: $('#form').serialize(),
            success: function(ajaxcevap2){ 
                $('.telefonbilgileri').html(ajaxcevap2).slideDown('slow');
            },
            error: function() {
              ajax();
            } 
        }); 
      }  
      var dizi = new Array('adresler') 
 </script>
  <div id='containerHolder'>
       <div id='container' style='background: #fff; height: 580px;'> 
        <h2 class='me' >
            <a href='../anasayfa.php?page=musteriler'>MÜŞTERİLER</a>
            &raquo;
           <a href='../musteri/detay.php?pk=<?php echo $musteri_pk; ?>'>Detay</a>
            &raquo;
           <a class='active' href='#'>Adres Sil</a>
        </h2>       
        <div id='main' class='me' >
                     <h3 style=' font-size:16px;'>  
                        Bu adres ve telefon bilgileri 
                        <b style='color:#C66653'>
              <?php          echo strtoupper($musteri['musteri_unvan']); ?>
                        </b>
                       ünvanlı müşteriden silinecek..
                    </h3>
            
            <form onsubmit='return kontrol_dizi(dizi);' action='adres-sil-islem.php?pk=<?php echo $musteri_pk ?>' method='post' id='form' class='jNice'>          
                   <div class='my' > 
                      <div class='kullanici_ekle_sag' > Müşterinin Adresleri :</div>  
                      <div class='myy'>
                         <select  name='adresler'  onchange="javascript:ajax();"  >
                            <option value='0' > Adres Seçiniz</option>
               
<?php     
    /**
     * adres bilgileri çekilecek olan müşteri
     */
    $db = new adres();
    $adresler = $db->musteri_adresleri($musteri_pk);
    $adres_pk = $_GET['adres_pk'];
    
    if ($adresler) {
      foreach ($adresler as $row) {
          if ($adres_pk == $row['pk']) {
               echo "<option selected value='{$row['pk']}'> {$row['baslik']} </option>";
          }
          else{ 
               echo "<option value='{$row['pk']}'> {$row['baslik']} </option>";
           }
      }
    }
?>
                       </select>
                   </div> 
                  <div style="float:right; margin-right: 60px;">
                      <input type='submit' name='onay' value='Seçili Adresi Sil' /> 
                  </div>
                 </div>
            </form>
        </div>
        <div id='main' style='float:left; margin-left:120px;'>
           <form action='tel-sil-islem.php?pk=<?php echo $musteri_pk ?>' method='post' id='form' class='jNice'>          
            <div class='telefonbilgileri'>
                          
            </div> 
         </div>   
     </div>
    </div>
        
       
<?php    
     
    require_once '../include/_alt.php'; 
    /*
    *  adres_pk varsa bilgilerinin çekilmesi
    */
   if ($adres_pk)
          echo "<script> ajax(); </script>";   
       
?>