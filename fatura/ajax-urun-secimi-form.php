          
    
<div>
     <label> İskonto Tutar TL :  </label>
     <input class="number"   id="toplamdan_iskonta_tutari" name="toplamdan_iskonta_tutari" readonly="readonly"  value="0" />
</div>
         
<div>
      <label> KDV Tutarı TL :  </label>
      <input class="number"  id="kdv_tutar" type="text" name="kdv_tutar" readonly="readonly" value="0"  />
</div>  
 <div>
     <label> İskontasız Top. Tutar TL :  </label>
     <input class="number"  id="iskontadan_onceki_toplam" name="iskontadan_onceki_toplam" readonly="readonly" value="0"  />
</div> 
<div >
     <label>KDV'siz Top. Tutar TL :  </label>
     <input class="number" style="padding: 0px"  id="kdvsiz_toplam_tutar" name="kdvsiz_toplam_tutar"   readonly="readonly" value="0"  />
</div>
<div>
     <label> Toplam Tutar TL :  </label>
     <input class="number"  id="toplam_tutar" name="toplam_tutar"  readonly="readonly" value="0" /> 
</div>

<div>
    <label> Kuruş :</label>
    <select id="hassasiyet" style="float: left; width: 120px; height: 23px; " >

<?php
    error_reporting(0);
    session_start();
    include '../my_class/sirket_ayar.php';

    $sirket_pk = $_SESSION['sirket_pk'];
    
    $db = new sirket_ayar();
    $sirket_ayar = $db->ayar_getir_sirket( $sirket_pk );

    
     $ayar = 2;
     if ($sirket_ayar)
         $ayar = $sirket_ayar['kurus_ayar'];

    $diyez = ".#";
    for ($i=1; $i <= 8 ; $i++) {
       if($ayar == $i) 
           echo "  <option selected value='{$i}'>$diyez</option> ";
       else
           echo "  <option value='{$i}'>$diyez</option> "; 
       $diyez .= "#";
    }

    
?>       
    </select>
</div>
    
