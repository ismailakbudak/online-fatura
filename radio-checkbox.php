<?php
     
      error_reporting(0);
	  // fatura ekleeme sayfası için
	  if ($_GET['page'] == 'ekle-form-fatura2') {
       	 $html  = "   <div style ='float:left;  width:100px;'> 
                          <div style ='float:left; width:60px; padding-top:0px; '> Açık : </div>    
                          <input style ='float:right;  width:20px; height: 14px; '  type='radio' checked  name='fatura_tipi[]' value='1' /> 
                      </div> 
                       
                       <div style ='float:left; margin-left:10px;  width:110px;'> 
                           <div style ='float:left; width:70px; padding-top:0px; '> Kapalı : </div>  
                           <input style ='float:right; width:20px; height:14px; padding-top:15px; ' type='radio' name='fatura_tipi[]' value='0' /> 
                       </div> ";
               
          echo $html;
       }   
      // fatura güncelleme sayfası için
      if ($_GET['page'] == 'ekle-form-fatura') {          
          
               $acik = $_GET['acik'];
                    
               if ( !$acik ) 
                   $durum = 0;   
               
               else{
                   if ($acik == 0) 
                       $durum = 0;
                   else 
                       $durum = 1;
               }
               
               $html  = "  <div style ='float:left;  width:100px;'> ";
               $html .= "   <div style ='float:left; width:60px; padding-top:0px; '> Açık : </div>    ";
               $html .= "   <input style ='float:right;  width:20px; height: 14px; '  type='radio' "; 
               
               if ($durum == 1){ 
                    $html .= "              checked ";    
               }
               
               $html .= "                     name='fatura_tipi[]' value='1' /> ";
               $html .= " </div> ";
                     
               $html .= " <div style ='float:left; margin-left:10px;  width:110px;'> ";
               $html .= "   <div style ='float:left; width:70px; padding-top:0px; '> Kapalı : </div>  ";  
               $html .= "   <input style ='float:right; width:20px; height:14px; padding-top:15px; ' type='radio'  ";
         
               if ( $durum == 0){ 
                    $html .= "              checked ";    
               }
               $html .= "           name='fatura_tipi[]' value='0' /> ";
               $html .= " </div> ";
               
               echo $html;
     }
      
       // ürün ekleme sayfası için
     if ($_GET['page'] == 'ekle-form') {    
          echo" <div style ='float:left;  width:100px;'>
                       <div style ='float:left; width:60px; padding-top:1px; margin-top:2px;'> Sınırlı : </div>      
                       <input style ='float:right;  width:20px;' type='radio' checked name='sinir[]' value='0' />
                </div>
                
                <div style ='float:left; margin-left:10px;  width:110px;'>
                   <div style ='float:left; width:70px; padding-top:1px; margin-top:2px;'> Sınırsız : </div> 
                   <input style ='float:right; width:20px;'  type='radio' name='sinir[]' value='1' />
                </div> ";
     }
      // ürün güncelleme sayfası için
     if ($_GET['page'] == 'guncelle-form') {    
          $stok = $_GET['stok'];
          if ($stok == 0) {
           echo"<div style ='float:left;  width:100px;'>
                       <div style ='float:left; width:60px; padding-top:1px; margin-top:2px;'> Sınırlı : </div>      
                       <input style ='float:right;  width:20px;' type='radio' checked name='sinir[]' value='0' />
                </div>
                
                <div style ='float:left; margin-left:10px;  width:110px;'>
                   <div style ='float:left; width:70px; padding-top:1px; margin-top:2px;'> Sınırsız : </div> 
                   <input style ='float:right; width:20px;'  type='radio' name='sinir[]' value='1' />
                </div>";
          }
          else {
            echo"<div style ='float:left;  width:100px;'>
                       <div style ='float:left; width:60px; padding-top:1px; margin-top:2px;'> Sınırlı : </div>      
                       <input style ='float:right;  width:20px;' type='radio' name='sinir[]' value='0' />
                </div>
                
                <div style ='float:left; margin-left:10px;  width:110px;'>
                   <div style ='float:left; width:70px; padding-top:1px; margin-top:2px;'> Sınırsız : </div> 
                   <input style ='float:right; width:20px;'  type='radio' checked name='sinir[]' value='1' />
                </div>";
          }
     }
?>