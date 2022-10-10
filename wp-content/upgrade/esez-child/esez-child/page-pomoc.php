<?php 
get_header();
?>

<?php if (is_user_logged_in()) { ?>
<div class="esez-container" style="max-width: 1000px;">
	<h1 class="entry-title"><?php the_title();?></h1>
	<?php the_content(); ?>
</div>
<?php } else { 
 wp_redirect(home_url());
 exit();
} ?>


<?php get_footer(); ?>
