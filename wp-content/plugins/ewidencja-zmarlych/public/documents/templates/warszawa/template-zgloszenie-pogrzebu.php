<?php 
 require('/home/esez/domains/dev.esez.pl/public_html/wp-content/plugins/ewidencja-zmarlych/public/documents/classes/class-dane-firmy.php');
 ?>
<style>
    page[size="A4"] {
                background: white;
                width: 21cm;
                height: 29.7cm;
                display: block;
                background-image: url('/wp-content/plugins/ewidencja-zmarlych/public/documents/templates/warszawa/zgloszenie-pogrzebu.png');
                background-size: contain;
                margin-bottom: 0.5cm;
                box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
                margin: 0
            }
</style>

<?php
 
 $daneFirmy = new Firma();

?>
<span><?php echo $daneFirmy->get_nazwa();?></span>
<span><?php echo $daneFirmy->get_ulica();?></span>
<span><?php echo $daneFirmy->get_kod_pocztowy();?></span>
<span><?php echo $daneFirmy->get_miejscowosc();?></span>