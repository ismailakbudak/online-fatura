<?php

    // session kontrolleri yapan sayfa
    require_once '../include/ust.php';
    require_once '../my_class/urun_grup.php';  
    
     $urun_pk = $_GET['pk'];
     if (!$urun_pk){
          $mesaj = 'Ürün bilgileri eksik geldi..';
          redirect('../anasayfa.php?page=urunler&msj='.$mesaj);
     }
     
 ?>  

<script type="text/javascript">
    $(function(){
        $( "#mainNav" ).find("#urunler").addClass("active");
    });
</script>
   
   <div id='containerHolder'>
       <div id='container' style='background: #fff; height: 500px;'>            
                <h2 class='me'>
                   <a href='../anasayfa.php?page=urunler'>ÜRÜNLER</a>
                   &raquo;
                   <a class='active' href='#'>Detay</a>
                </h2>
                <div id='main' class='me' >
                    <form  class='jNice'>
                        <p>Stok hareketleri gelebilir </p> 
                     </form>
               </div>   
              <div class='clear'></div>
       </div>
</div>  
  
<?php   require_once '../include/_alt.php';   ?>








