 <style>
#project-label {
display: block;
font-weight: bold;
margin-bottom: 1em;
}
#project-description {
margin: 0;
padding: 0;
}
</style>
<script>
<?php
      error_reporting(0);
      
      echo " var projects = [  ";
      
        session_start();
        require_once '../my_class/musteri_kod.php';
        $db = new musteri_kod();
        $sirket_fk = $_SESSION['sirket_pk'];
        
        $musteri_kodlari = $db->listele($sirket_fk);
        if ($musteri_kodlari) {
          
            foreach ($musteri_kodlari as  $row) {
                 echo " {
                           value: '{$row['kod']}',
                           label:  '{$row['kod']}',
                           desc: '{$row['aciklama']}',
                        },";
           }
         }
      echo " ]" ;
?>   

$(function() {
 $( "#musteri_kod" ).autocomplete({
  minLength: 0,
  source: projects,
  focus: function( event, ui ) {
     $( "#musteri_kod" ).val( ui.item.label );
      return false;
  },
   
   select: function( event, ui ) {
      $( "#musteri_kod" ).val( ui.item.label );
      $( "#project-id" ).val( ui.item.value );
      $( "#project-description" ).html( ui.item.desc );
         return false;
       } 
    })
       .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
       return $( "<li>" )
       .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
       .appendTo( ul );
     };
});
</script>

<?php  

      $data = $_GET['data']; 
     if ($data) {
         echo ' <input id="musteri_kod" value="'.$data.'" name="musteri_kod" placeholder="Müşteri kodu" />
                <input type="hidden" id="project-id" /> ';
     }
     else {
         echo ' <input id="musteri_kod" name="musteri_kod" placeholder="Müşteri kodu" />
                <input type="hidden" id="project-id" /> ';    
     }

?>



