<?php
    
    require  '../include/function.php';
    require  '../my_class/sirket_ayar.php';     

    $ayar_pk = $_GET['sirket_ayar_pk'];
    $kurus_ayar = $_POST['kurus_ayar'];
    
     if ( !$ayar_pk ) 
     	$mesaj = "Bilgiler eksik geldiği için işlem yapılamıyor..";
     
     if($mesaj)
          redirect('ayarlar-form.php?msj='.$mesaj);
      
     $db = new sirket_ayar();
     $sonuc = $db->guncelle($ayar_pk,$kurus_ayar,$extra);      
     
     if($sonuc)
     	$mesaj = "Ayarlar başarılı bir şekilde güncellendi..";
     else
     	$mesaj = "Ayarlar güncellenemedi..";
    
     redirect('ayarlar-form.php?msj='.$mesaj);
     
?>