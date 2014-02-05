
<?php
    require '../include/ust.php';
    require '../my_class/fatura_detay.php'; 
    require '../my_class/adres.php'; 
    
     $fatura_pk = $_GET['pk'];
     if (!$fatura_pk){
          $mesaj = 'Fatura bilgileri eksik geldi..';
          redirect('../anasayfa.php?page=faturalar&msj='.$mesaj);
     }
     
      $db_fatura = new fatura_detay();
      $db_adres = new adres();
     
     // fatura bilgileri çekiliyor
     $fatura = $db_fatura->fatura_getir_by_id($fatura_pk);
     if (!$fatura){ 
        $mesaj = "Fatura bilgileri eksik geldiği için işlem yapılamıyor yapılamıyor..";
        redirect('../anasayfa.php?page=faturalar&msj='.$mesaj);  
     }

     error_reporting(E_ALL);

     $musteri_pk = $fatura['musteri_fk'];

     $adresler = $db_adres->musteri_adresleri($musteri_pk);
     if (!$adresler) {
         $mesaj = "Musteri adres bilgileri çekilemedi..";
         redirect('../anasayfa.php?page=faturalar&msj='.$mesaj);  
     }

     $adres_bilgileri = array(0 =>"");
 
     foreach ($adresler as $adres) {
         $adres_bilgileri[] = $adres['adres'];
      } 
?>
<style>
   div#users-contain { width: 250px; margin: 0px 0; }
   div#users-contain table { margin: 1em 1em; border-collapse: collapse; }
   div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px;  font-size:12px;  text-align: center; }
   .ui-dialog .ui-state-error {  }
   .validateTips { border: 1px solid transparent; padding: 0.3em; }  
  
   #container #urun_secimi{ margin-left:0px; height:80px; width: 680px;}
   #container #urun_secimi label {width:200px; float:left; font-weight:800; font-size:13px; text-align:right; padding-top: 6px; margin-bottom:10px; padding-right: 5px;padding-left: 5px; } 
   #container #urun_secimi .number {width:120px; float:left; font-weight:800; font-size:13px; padding:3px; margin-bottom: 5px;}

</style>
<script type="text/javascript">
  $(function(){
         $( "#mainNav" ).find("#faturalar").addClass("active");
  }); 
</script>
 <div id='containerHolder'>
       <div id='container' style='background: #fff; ' >               
          <h2 style="margin-bottom: 10px;" class="me" >
                   <a href='../anasayfa.php?page=faturalar'>FATURALAR</a>
                   &raquo;
                   <a class='active' href='#'>Detay</a>
                      <b style=" color: #5494AF; float: right; "> Şu anda işlem yaptığınız fatura No : 
                           <b style='color:#C66653'>
                               <?php echo strtoupper($fatura['fatura_no']); ?>
                          </b>
                     </b>
          </h2>
          <div id='main2' style="margin-top: 50px;" >
             <form  class='jNice'>
                <div class='kullanici_ekle_satir' style="height: 25px">
                             <div class="satir_bol">
                                 <div class='kullanici_ekle_sag' > Müşteri Unvanı :</div>  
                                 <input style="height: 24px; padding-top: 0px" value="<?php echo $fatura['musteri_unvan']?>"  readonly  />
                             </div>
                            <div class="satir_bol">
                                <div class='kullanici_ekle_sag'  style="padding-top: 3px;"> Fatura No : </div>
                                <input style="height: 24px; padding-top: 0px" value="<?php echo $fatura['fatura_no']?>" readonly  /> 
                             </div>
                  </div>
                  <div class="kullanici_ekle_satir">
                             <div class="satir_bol">
                                 <div class="kullanici_ekle_sag">Vergi Dairesi :</div>
                                 <input style="height: 24px; padding-top: 0px" value="<?php echo $fatura['vergi_daire_no']?>"  readonly  />
                             </div>
                             <div class="satir_bol">
                                 <div class="kullanici_ekle_sag"> Vergi No :</div>
                                 <input style="height: 24px; padding-top: 0px" value="<?php echo $fatura['vergi_no']?>"  readonly  />
                             </div>
                   </div>
                   <div class="kullanici_ekle_satir" style="height:30px;">
                                  <div class='kullanici_ekle_sag'  style=" padding-top: 3px;" > Adres :  </div>
                                  <textarea id="resizable" cols="60" rows="40" readonly="readonly" style="width: 680px; height: 28px;" > <?php echo $adres_bilgileri[1] ?> </textarea>
                    </div>                 
                    <div class='kullanici_ekle_satir'>
                            <div  style=" width: 250px; float: left; ">
                                <div class="kullanici_ekle_sag"  style=" float: left; padding-top: 3px;" > Fatura Tarihi :  </div>
                                <input style=" width: 100px; float: left; "  value="<?php echo $fatura['fatura_tarih']?>"  readonly   />
                             </div>
                             <div  style=" width: 300px; float: left; "> 
                               <div  class="kullanici_ekle_sag" style="float: left; width: 190px; padding-top: 3px;" > Fatura Düzenlenme Saati :  </div>
                                <input style=" width: 100px; float: left; "  value="<?php echo $fatura['fatura_basim_tarihi']?>"  readonly   />
                              </div>
                              <div style=" width: 250px; float: left; ">
                                  <div class="kullanici_ekle_sag"  style=" float: left; padding-top: 3px;" > Fiili Sevk Tarihi :  </div>
                                  <input style=" width: 100px; float: left; "  value="<?php echo $fatura['fiili_sevk_tarihi']?>"  readonly   />
                              </div>      
                   </div>             
                   
                   <div id="users-contain" class="ui-widget" style="padding: 0px;" >         
                   <table id="users" style="float:left; width: 900px; margin-left: 8px; margin-right: 8px; " class="ui-widget ui-widget-content">
                        <thead>
                           <tr class="ui-widget-header ">
                              <th id='kod'>Ürün Kodu</th>
                              <th>Ürün Adı</th>
                              <th>Miktarı </th> 
                              <th>Birim Fiyatı</th>
                              <th>Miktar Birimi</th>
                              <th>İndirim Tutarı</th>
                              <th>KDV Oranı</th>
                            </tr>
                          </thead>
                          <tbody>
<?php
  if ($fatura_pk) {
      require '../my_class/fatura_urun.php';
      $db = new fatura_urun();
      $fatura_urunleri = $db->fatura_urun_getir_by_fatura_detay_fk($fatura_pk);
      if ($fatura_urunleri) {
          foreach ($fatura_urunleri as $fatura_urun) {
              echo "  <tr>
                            <td id='kod' >{$fatura_urun['urun_kodu']}</td>
                            <td>{$fatura_urun['urun_adi']}</td>
                            <td>{$fatura_urun['miktar']}</td>
                            <td>{$fatura_urun['birim_fiyati']}</td>
                            <td>{$fatura_urun['miktar_birim']}</td>
                            <td>{$fatura_urun['iskonto_tutari']}</td>
                            <td>{$fatura_urun['kdv_orani']}</td>
                        </tr>  ";
          }     
      }
  }  
?>                      
                          </tbody>
                        </table>                     
                     </div>     
                     <fieldset id="urun_secimi" style="float: left; margin-bottom: 0px;" >
                        <div>
                          <label> İskonto Tutar TL :  </label>
                          <input value="<?php echo $fatura['toplamdan_iskonto_tutari']?>" class="number"   id="toplamdan_iskonta_tutari" name="toplamdan_iskonta_tutari" readonly="readonly" />
                        </div>
                        <div>
                          <label> KDV Tutarı TL :  </label>
                          <input value="<?php echo $fatura['kdv_tutar']?>" class="number"  id="kdv_tutar" type="text" name="kdv_tutar" readonly="readonly" />
                        </div>  
                        <div>
                           <label> İskontasız Top. Tutar TL :  </label>
                           <input value="<?php echo $fatura['iskontadan_onceki_toplam']?>" class="number"  id="iskontadan_onceki_toplam" name="iskontadan_onceki_toplam" readonly="readonly"  />
                       </div> 
                       <div >
                           <label>KDV'siz Top. Tutar TL :  </label>
                           <input value="<?php echo $fatura['kdvsiz_toplam_tutar']?>" class="number"  id="kdvsiz_toplam_tutar" name="kdvsiz_toplam_tutar"   readonly="readonly" />
                       </div>
                       <div>
                          <label> Toplam Tutar TL :  </label>
                          <input value="<?php echo $fatura['toplam_tutar']?>" class="number"  id="toplam_tutar" name="toplam_tutar"  readonly="readonly" /> 
                      </div>
                    </fieldset>
                    <div style="padding: 0px; float: left; width: 890px">
                        <h3 style=" text-align: center; margin-top: 10px; padding: 13px;">  Faturayı yazdırmak için  
                              <a target="blank" style="text-decoration: none; color: #C66653" href='fatura-yazdir.php?fatura_pk=<?php echo $fatura_pk ?>'>Tıklayınız..</a>
                        </h3>
                    </div>
                  </form>
               </div>   
              <div class='clear'></div>
       </div>
</div>  
  

<?php
    require '../include/_alt.php';
?>