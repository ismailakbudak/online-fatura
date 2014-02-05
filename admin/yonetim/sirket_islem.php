<?php


  require_once '_session_kontrol_2.php';
  require_once '_metotlar_2.php';
  require_once ('../my_class/sirket_detay.php');
	  
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
                        <li><a href='sirket/ekle.php'>Şirket Ekle </a></li>
                    </ul>
                </div>    
                <h2>
                   <a href='../yonetim.php#'>YÖNETİM</a> 
                   &raquo; 
                   <a href='#' class='active'>Şirketler</a>
                </h2>
               <div id='main' >
                  <form method='post' class='jNice'> 
                        <h3>Şirketler Listesi</h3>
	                    <table cellpadding='0' cellspacing='0'>
							<tr>
                                <td>ŞİRKET İSMİ</td>
                                <td class='action'>İŞLEM</td>
                            </tr>  
<?php     
	     
	  $db = new sirket_detay();
	  $sirket = $db->listele();
	   if ($sirket) {                          
	                            //SAyfalama yapan kısım
                                 $toplam_sayfa = ceil(count($sirket->fetchAll()) / 11);
                                 $sayfa = $_GET['sayfa_no'];
                                 if(!$sayfa || $sayfa > $toplam_sayfa || $sayfa < 0 || !is_numeric($sayfa) )
                                    $sayfa = 1;
                                    
                                 $baslangic = (($sayfa - 1) * 11);
                                 $sirket = $db->sirket_getir_for_sayfa($baslangic,11);
                                 // sayfalama bitiş	   
	      foreach ($sirket as  $row) {
				  echo"   
				           <tr class='odd'>
                                <td>  {$row['sirket_isim']}    </td>
                                <td class='action'>
                                  <a href='sirket/detay.php?pk={$row['pk']}' class='view' >Detay</a>
                                  <a href='sirket/duzenle.php?pk={$row['pk']}' class='edit'>Düzenle</a>
                                  <a href='sirket/sil.php?pk={$row['pk']}' class='delete'>Sil</a>
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
                         echo '<a data-no="'.$i.'" class="selected" href="sirket_islem.php?sayfa_no='.$i .'">'.$i .'</a>';
                     else
                         echo '<a data-no="'.$i.'" href="sirket_islem.php?sayfa_no='.$i .'">'.$i .'</a>';
              }
              else{
                     if($i > $sayfa-3 &&  $i < $sayfa + 3 ){
                          if($i == $sayfa)
                             echo '<a data-no="'.$i.'" class="selected" href="sirket_islem.php?sayfa_no='.$i .'">'.$i .'</a>';
                          else
                              echo '<a data-no="'.$i.'" href="sirket_islem.php?sayfa_no='.$i .'">'.$i .'</a>';
                     }
                     else
                         echo '<a data-no="'.$i.'" class="nokta" href="sirket_islem.php?sayfa_no='.$i .'">.</a>';
              }
           }
       ?>
       </div>
   </div>  
<?php
      alt_yaz(); 
?>


