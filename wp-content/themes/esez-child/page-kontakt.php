<?php 
get_header();
?>

<?php if (is_user_logged_in()) { ?>
<div class="esez-container">
	<h1 class="entry-title">eSEZ - Elektroniczny System Ewidencji Zmarłych</h1>
	<p class="mt-3">Przejdź do zakładki "Ewidencja", aby zarządzać opaskami</p>
</div>
<?php } else { ?>
<style>
a {
	color: #009999;
	text-decoration: none;
}

a:hover {
	color: #04414d;
}
</style>
<div class="esez-container glowna">
	<div class="title-container">
		<h1><?php the_title();?></h1>
	</div>
	<div class="row py-lg-4 py-xs-2">
		<div class="col-lg-6 p-lg-4"><?php the_field('kolumna_1'); ?></div>
		<div class="col-lg-6 p-lg-4"><?php the_field('kolumna_2'); ?><div>
	</div>
</div>		<!-- container -->
<?php } ?>


<?php get_footer(); ?>
