<?php 

    require '../include/function.php';
	require '../my_class/musteri_detay.php';

	/**
	 * kullanıcı bilgileri gelmiş mi kontrol ediliyor
	 */
	$musteri_pk = $_GET['pk'];
	if (!$musteri_pk) {
		$mesaj = "Müşteri bilgileri eksik....";
        redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
	}
	
	/**
	 * silme işlemi
	 */
	 
	 $db = new musteri_detay();
	 $sonuc = $db->sil($musteri_pk);
	
     if ($sonuc > 0) 
		 $mesaj = "Müşteri başarılı bir şekilde silindi....";
	 
	 else 
		 $mesaj = "Müşteri silinemedi....";
	 
     redirect('../anasayfa.php?page=musteriler&msj='.$mesaj);
	
	
?>