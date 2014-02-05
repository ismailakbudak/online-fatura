<?php

  require_once '_session_kontrol_2.php';
  require_once '_metotlar_2.php';
  require_once ('../my_class/kullanicilar.php');
  
   ust_yaz();
   
     echo " <div class='hatali'></div>  ";
     $mesaj = $_GET['msj'];
     if(isset($mesaj) && strcmp($mesaj, "") != 0){
	        echo "<script> myClick('.hatali','{$mesaj}','UYARI'); </script>";	
	    }
 ?>  
   <div id="containerHolder">
	    <div id="container" style="height: 470px;">
			   <div id='sidebar'>
                	<ul class='sideNav'>
                        <li><a href='kullanici/ekle.php'>Kullanıcı Ekle </a></li>
                    </ul>
                </div>    
                <h2>
                   <a href='../yonetim.php#'>YÖNETİM</a> 
                   &raquo; 
                   <a href='#' class='active'>Kullanıcılar</a>
                </h2>
                <div id='main'>
                	<form action='' class='jNice'>
   	                    <h3>Kullanıcılar Listesi</h3>
	                    <table cellpadding="0" cellspacing="0">
	                        <tr class="odd">
	                          <td>  KULLANICI  ADI </td>
                              <td> YETKİSİ </td>
                              <td  class="action">  İŞLEM </td>
	                        </tr>
<?php 
	  $db = new kullanicilar();
	  $sonuc = $db->listele();
	   if ($sonuc) {
	                        	 //SAyfalama yapan kısım
                                 $toplam_sayfa = ceil(count($sonuc->fetchAll()) / 11);
                                 $sayfa = $_GET['sayfa_no'];
                                 if(!$sayfa || $sayfa > $toplam_sayfa || $sayfa < 0 || !is_numeric($sayfa) )
                                    $sayfa = 1;
                                    
                                 $baslangic = (($sayfa - 1) * 11);
                                 $sonuc = $db->kullanici_getir_for_sayfa($baslangic,11);
                                 // sayfalama bitiş	   
	      foreach ($sonuc as  $row) {
				  echo"   
				           <tr class='odd'>
                                <td>  {$row['kullanici_adi']} </td>
                                <td>  {$row['yetkisi']} </td>
                                <td class='action'>
                                  <a href='kullanici/detay.php?pk={$row['pk']}' class='view' >Detay</a>
                                  <a href='kullanici/duzenle.php?pk={$row['pk']}' class='edit'>Düzenle</a>
                                  <a href='kullanici/sil.php?pk={$row['pk']}' class='delete'>Sil</a>
                                </td>
                            </tr>                        
						";
	      }
	   }
?>
                     </table>	      
		          </form>
               </div>
          	<div class="clear"></div>
       </div>
       <!-- SAYFALAMA için GEREKLİ -->
       <div id="page" >
       <?php
          for($i=1;$i<=$toplam_sayfa;$i++){
              if ($i < 4 || $i > ($toplam_sayfa - 3)  ) {
                     if($i == $sayfa)
                         echo '<a data-no="'.$i.'" class="selected" href="kullanici_islem.php?sayfa_no='.$i .'">'.$i .'</a>';
                     else
                         echo '<a data-no="'.$i.'" href="kullanici_islem.php?sayfa_no='.$i .'">'.$i .'</a>';
              }
              else{
                     if($i > $sayfa-3 &&  $i < $sayfa + 3 ){
                          if($i == $sayfa)
                             echo '<a data-no="'.$i.'" class="selected" href="kullanici_islem.php?sayfa_no='.$i .'">'.$i .'</a>';
                          else
                              echo '<a data-no="'.$i.'" href="kullanici_islem.php?sayfa_no='.$i .'">'.$i .'</a>';
                     }
                     else
                         echo '<a data-no="'.$i.'" class="nokta" href="kullanici_islem.php?sayfa_no='.$i .'">.</a>';
              }
           }
       ?>
       </div>
   </div> 
                      
<?php
   alt_yaz(); 
?>

