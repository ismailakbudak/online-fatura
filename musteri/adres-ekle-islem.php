<?php 
    ob_start();
    require '../include/function.php';
    require_once '../my_class/adres.php';   
    require_once '../my_class/adres_musteri.php';   

    $baslik = $_POST['baslik'];
    $adres = $_POST['adres'];
    $aciklama = $_POST['aciklama'];
    $musteri_pk = $_GET['musteri_pk'];
    
    
    if ( !$musteri_pk) {
        $mesaj = 'Eksik bilgi geldiği için işlem yapılamadı..';
        redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
    }
    if (!$baslik || !$adres) {
        $mesaj = 'Başlık veya adres girmediniz..';
        redirect('../musteri/adres-ekle-form.php?musteri_pk='.$musteri_pk.'&msj='.$mesaj);
    }
    
    $db = new adres();
    $adres_pk = $db->ekle($adres,$baslik,$aciklama);
    
    
    if ($adres_pk){
      
        $db = new adres_musteri();
        $sonuc = $db->ekle($adres_pk,$musteri_pk);
        
        if ($sonuc > 0)
               $mesaj = 'Adres başarılı bir şekilde müşteri bilgilerine eklendi..';
              
        else 
            $mesaj = "Adres bilgileri müşteriye eklenemedi.. ";
        
    }
    else 
        $mesaj = 'Adres eklenemedi.. ';
      
     redirect('../musteri/adres-ekle-form.php?musteri_pk='.$musteri_pk.'&msj='.$mesaj);
          
?>