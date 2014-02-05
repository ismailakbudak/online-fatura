 <?php
     
     require '../include/function.php';
     require '../my_class/urunler.php';
     
     $urun_pk = $_GET['urun_pk'];
     $grup_fk = $_POST['grup_fk'];
     $urun_kodu = $_POST['urun_kodu'];
     $urun_ismi = $_POST['urun_ismi'];
     $sinirsiz_stok = $_POST['sinir'];     
     $kritik_seviye = $_POST['kritik_seviye'];
     $kdv_orani = $_POST['kdv_orani'];
     $aciklama = $_POST['aciklama'];
     
     if (!$urun_pk) 
         $mesaj = 'Ürün için gerekli bilgiler alnamadı...';
 
     if (!$grup_fk || !$urun_kodu || !$urun_ismi || !$kdv_orani ) 
         $mesaj = 'Gerekli alanlları doldurmadınız...';
     
     if (!$grup_fk || !$urun_kodu || !$urun_ismi || !$kdv_orani ) 
         $mesaj = 'Gerekli alanlları doldurmadınız...';
     
     if ($sinirsiz_stok[0] == 0) {
         if (!$kritik_seviye) 
             $mesaj = 'Sınırlı ürüne Kritik Seviye girmelisiniz...';     
     }
     
     if($mesaj)
          redirect('../urun/guncelle-form.php?pk='.$urun_pk.'&msj='.$mesaj);
          
     $db = new urunler();
     $urun = $db->urun_getir_urunkodu($urun_kodu);
     
     if ($urun && $urun['pk'] != $urun_pk) {
        $mesaj = 'Bu ürün kodu başka bir ürüne ait..';
        redirect('../urun/guncelle-form.php?pk='.$urun_pk.'&msj='.$mesaj);   
     }
     
     $satir_sayisi = $db->guncelle($urun_pk,$grup_fk,strtoupper($urun_kodu),strtoupper($urun_ismi),$sinirsiz_stok[0],$kritik_seviye,$kdv_orani,$aciklama);
     if ($satir_sayisi > 0) 
         $mesaj = 'Ürün başarılı bir şekilde güncellendi ..';
     
     else
         $mesaj = 'Ürün güncellenemedi..';
 
     redirect('../urun/guncelle-form.php?pk='.$urun_pk.'&msj='.$mesaj);  
     
?>