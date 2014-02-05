

<script>
     $(function() {
         $( "#combobox2" ).combobox();
     });
</script>
 
       
<?php
    error_reporting(0);
    require_once '../my_class/musteri_detay.php';
          
    $sirket_pk = $_GET['sirket_pk'];
    if ($sirket_pk) {
          echo ' <select id="combobox2" name="musteri_fk" class="musteri_fk"  >
                          <option value="0"></option>'; 
          $db = new musteri_detay();
          $musteriler = $db->listele($sirket_pk);
          if ($musteriler) {
            foreach ($musteriler as  $row) {
                  echo "  <option value='{$row['pk']}' > {$row['musteri_unvan']} </option> "; 
            }
          }
       echo "</select>";
    }
    
?>   
 