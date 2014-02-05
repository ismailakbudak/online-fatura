 <?php
    require '../include/function.php';
    require_once '../my_class/musteri_detay.php';   
  
    $musteri_pk = $_GET['musteri_pk'];
    $eposta = $_POST['eposta'];
    $web = $_POST['web'];
    $aciklama = $_POST['aciklama'];
    
    
    if ( !$musteri_pk) {
        $mesaj = 'Eksik bilgi geldiği için işlem yapılamadı..';
        redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
    }
    
	$db = new musteri_detay();
	$satir_sayisi = $db->guncelle_iletisim($musteri_pk, $eposta, $web, $aciklama);
	
	if ($satir_sayisi > 0)
         $mesaj = 'Müşteri bilgileri güncellendi..';
              
      else 
         $mesaj = "Müşteri bilgileri güncellenemedi.. ";
     
     redirect('../musteri/adres-ekle-form.php?musteri_pk='.$musteri_pk.'&msj='.$mesaj);
 
 
 ?>