<?php 
    
    require '../include/function.php';
    require '../my_class/telefon.php';       

    $adres_fk = $_POST['adresler'];
    $tel = $_POST['tel'];
    $faks = $_POST['fax'];
    $musteri_pk = $_GET['musteri_pk'];
    
    
    if ( !$musteri_pk) {
        $mesaj = 'Eksik bilgi geldiği için işlem yapılamadı..';
        redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
    }
    if (!$adres_fk || !$tel) {
        $mesaj = 'Adres seçmediniz veya telefon numarası girmediniz..';
        redirect('../musteri/adres-ekle-form.php?musteri_pk='.$musteri_pk.'&msj='.$mesaj);
    }
 
    $db = new telefon();
    $sonuc = $db->ekle($adres_fk,$tel,$faks);
    if ($sonuc > 0)
          $mesaj = "Telefon ve faks başarılı bir şekilde kayıt edildi..";
    
    else
         $mesaj = "Telefon ekleme işlemi başarısız....";
     
   redirect('../musteri/adres-ekle-form.php?musteri_pk='.$musteri_pk.'&msj='.$mesaj);
 ?>