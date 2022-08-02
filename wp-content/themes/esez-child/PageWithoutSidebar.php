<?php /* Template Name: kolumny */

get_header();
?>

<?php if (is_user_logged_in()) { ?>
<div class="esez-container">
	<h1 class="entry-title">eSEZ - Elektroniczny System Ewidencji Zmarłych</h1>
	<p class="mt-3">Przejdź do zakładki "Ewidencja", aby zarządzać opaskami</p>
</div>
<?php } else { ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300&display=swap');
.esez-container.glowna {
	font-family: 'Montserrat', sans-serif;
	max-width: 1400px;
	margin: auto;
}

.title-container {
	text-align: center;
	margin-top: 60px;
	margin-bottom: 60px;
}

.title-container h1:after, .title-container h2:after  {
	content: '';
    position: absolute;
    display: block;
    border-bottom: 3px solid #00635A;
    width: 120px;
    margin: auto;
    left: 0;
    right: 0;
    margin-top: 25px;
}

.glowna ul li {
	margin-top: 0.25em;
}

.glowna h2, .podstrona h2 {
	margin-bottom: 1em;
}


.grecaptcha-badge { 
    visibility: hidden;
}

@media (min-width: 768px) {
	.esez-container.glowna, .esez-container.podstrona {
	    font-size: 1.3em;
	  }
	  
	.formularz-glowna textarea {
		width: 800px;
	}
}

@media (min-width: 992px) {
	.title-container {
		margin-bottom: 80px;
	}
}
	
	
@media (max-width: 991px) {	
	.glowna h2, .podstrona h2 {
	    font-size: calc(1.15rem + .9vw);
	  }
	}

</style>
<div class="esez-container glowna">
	<div class="title-container">
		<h1><?php the_title();?></h1>
	</div>
	<div class="row py-lg-4 py-xs-2">
		<div class="col-lg-6 p-lg-4"><?php the_field('kolumna_1'); ?></div>
		<div class="col-lg-6 p-lg-4><?php the_field('kolumna_2'); ?></div>
	</div>

</div> <!-- container -->
<?php } ?>


<?php get_footer(); ?>
