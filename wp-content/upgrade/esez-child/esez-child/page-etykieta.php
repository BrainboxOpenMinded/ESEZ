<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta name="robots" content="noindex">   
<?php wp_head(); ?>
</head>
<body>

<?php
$ewidencja_id = $_GET['ewidencja_id'];

$author_id = get_post_field( 'post_author', $ewidencja_id );
$user = get_the_author_meta( 'ID' );
global $current_user;
wp_get_current_user();


// Zmarły
$kod_opaski = get_the_title( $ewidencja_id );
$numer_opaski = get_field( 'numer_opaski', $ewidencja_id );
$imie_zmarlego = get_field( 'imie_zmarlego', $ewidencja_id );
$nazwisko_zmarlego = get_field( 'nazwisko_zmarlego', $ewidencja_id );
$pesel = get_field( 'pesel', $ewidencja_id );
$waga = get_field( 'waga', $ewidencja_id );
$adres_odbioru = get_field( 'adres_odbioru', $ewidencja_id );
$data_odbioru_ciala = get_field( 'data_odbioru_ciala', $ewidencja_id );
$notatki_do_druku = get_field( 'notatki_do_druku', $ewidencja_id );
$godzina__data_pogrzebu = get_field( 'godzina__data_pogrzebu', $ewidencja_id );
$data_pogrzebu = get_field( 'data_pogrzebu', $ewidencja_id );
$godzina_pogrzebu = get_field( 'godzina_pogrzebu', $ewidencja_id );
$ceremonia_pozegnalna = get_field( 'ceremonia_pozegnalna', $ewidencja_id );
$ceremonia_pozegnalna_data = $ceremonia_pozegnalna['data'];
$ceremonia_pozegnalna_godzina = $ceremonia_pozegnalna['godzina'];
$ceremonia_pozegnalna_miejsce = $ceremonia_pozegnalna['miejsce'];
$ceremonia_pozegnalna_adres = $ceremonia_pozegnalna['adres'];



if ( !empty( $ewidencja_id ) ) {
    if (is_user_logged_in() && $current_user->ID == $author_id) {
?>
<!-- Tabelka start -->
<table class="table tabela-druk" style="width: 600px; font-size: 18px;">
  <tr>    
    <td width="25%">
      <div class="showQRCode"></div>
    </td>
    <td width="75%">
      <h2><?php echo $imie_zmarlego . ' ' . $nazwisko_zmarlego; ?></h2>
      <?php if ($numer_opaski) { ?>
        <strong>Opaska nr</strong> <?php echo $numer_opaski; ?><br />
      <?php } ?>
	  <?php if ($ceremonia_pozegnalna_data || $ceremonia_pozegnalna_godzina) { ?>
        <strong>Pożegnanie:</strong> <?php echo $ceremonia_pozegnalna_data . ' ' . $ceremonia_pozegnalna_godzina; ?><br />
      <?php } ?>
      <?php if ($data_pogrzebu || $godzina_pogrzebu) { ?>
        <strong>Pogrzeb:</strong> <?php echo $data_pogrzebu . ' ' . $godzina_pogrzebu; ?><br />
      <?php } ?>
    </td>    
  </tr>

</table>
<!-- Tabelka koniec -->

<button class="acf-button button button-primary button-large button-drukuj" onclick="window.print()">Drukuj etykietę</button>

<?php 
}
}

wp_footer();
?>
<script>
    jQuery(document).ready(function ($) {
      $.ajax({
        url: '/generate_code.php',
        type: 'POST',
        data: {
          formData: 'https://esez.pl/z/<?php echo get_the_title($ewidencja_id); ?>'
        },
        success: function (response) {
          $(".showQRCode").html(response);
        },
      });
    });
</script>
</body>
</html>