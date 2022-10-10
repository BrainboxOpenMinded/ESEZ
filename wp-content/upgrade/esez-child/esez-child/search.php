<?php
/**
 * The Template for displaying Search Results pages.
 */

get_header();
if (is_user_logged_in()) :
if ( have_posts() ) :
?>
<h2 style="color: green; padding-top: 80px;">Chwilowo niedostępne</h2>
<?php
endif;
wp_reset_postdata();
else : ?>
<h2 style="color: red">Brak dostępu dla osoby niezalogowanej</h2>
<?php endif; get_footer(); ?>
