<?php 
get_header();
?>

<?php if (is_user_logged_in()) { ?>
<div class="esez-container">
	<h1 class="entry-title">eSEZ - Elektroniczny System Ewidencji Zmarłych</h1>
	<!--<p class="mt-3">Przejdź do zakładki "Ewidencja", aby zarządzać opaskami</p>-->
</div>
<?php } else { ?>
<!--<style>
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


@keyframes fadeInLeft {
  from {
    opacity: 0;
    transform: translate3d(-100%, 0, 0);
  }

  to {
    opacity: 1;
    transform: translate3d(0, 0, 0);
  }
}

.fadeInLeft {
  animation-name: fadeInLeft;
  animation-duration: 1s;
}

@keyframes fadeInRight {
  from {
    opacity: 0;
    transform: translate3d(100%, 0, 0);
  }

  to {
    opacity: 1;
    transform: translate3d(0, 0, 0);
  }
}

.fadeInRight {
  animation-name: fadeInRight;
  animation-duration: 1s;
}

img {max-width: 100%;}

.tak {
	color: green;
}

.nie {
	color: red;
}

.formularz-glowna {
	margin: auto;
	max-width: 800px;
}

.formularz-glowna input {
	max-width: 400px;
}

#tabelaCennik {
	font-size: 0.8em;
}

#tabelaCennik td {
	vertical-align: middle;
}

#tabelaCennik a {
	font-weight: 700;
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

</style>-->
<div class="esez-container glowna">
	<div class="title-container">
		<h1><?php the_title();?></h1>
	</div>
	<div class="row py-lg-4 py-xs-2">
		<div class="col-lg-6 p-lg-4"><?php the_field('tekst_1'); ?></div>
		<div class="col-lg-6 p-lg-4 mb-4 fadeInRight">
		<?php 
		$zdjecie_1 = get_field('zdjecie_1');	
         if ($zdjecie_1) { ?>
            <img src="<?php echo $zdjecie_1['url']; ?>" alt="<?php echo $zdjecie_1['alt']; ?>" />
        <?php } ?>
		</div>
	</div>
	<div class="row py-lg-4 py-xs-2">
		<div class="col-lg-6 p-lg-4 mb-4">
		<?php 
		$zdjecie_2 = get_field('zdjecie_2');	
         if ($zdjecie_2) { ?>
            <img src="<?php echo $zdjecie_2['url']; ?>" alt="<?php echo $zdjecie_2['alt']; ?>" />
        <?php } ?>
		</div>
		<div class="col-lg-6 p-lg-4"><?php the_field('tekst_2'); ?></div>	
	</div>
	<div class="row py-lg-4 py-xs-2">
		<div class="col-lg-6 p-lg-4"><?php the_field('tekst_3'); ?></div>
		<div class="col-lg-6 p-lg-4 mb-4">
		<?php 
		$zdjecie_3 = get_field('zdjecie_3');	
         if ($zdjecie_3) { ?>
            <img src="<?php echo $zdjecie_3['url']; ?>" alt="<?php echo $zdjecie_3['alt']; ?>" />
        <?php } ?>
		</div>
	</div>
	<div class="row py-lg-4 py-xs-2">
		<div class="col-lg-6 p-lg-4 mb-4">
		<?php 
		$zdjecie_4 = get_field('zdjecie_4');	
         if ($zdjecie_4) { ?>
            <img src="<?php echo $zdjecie_4['url']; ?>" alt="<?php echo $zdjecie_4['alt']; ?>" />
        <?php } ?>
		</div>
		<div class="col-lg-6 p-lg-4"><?php the_field('tekst_4'); ?></div>	
	</div>
		<div class="row py-lg-4 py-xs-2">
		<div class="col-lg-6 p-lg-4"><?php the_field('tekst_5'); ?></div>
		<div class="col-lg-6 p-lg-4 mb-4">
		<?php 
		$zdjecie_5 = get_field('zdjecie_5');	
         if ($zdjecie_5) { ?>
            <img src="<?php echo $zdjecie_5['url']; ?>" alt="<?php echo $zdjecie_5['alt']; ?>" />
        <?php } ?>
		</div>
	</div>
	<!--<div class="row py-lg-4 py-xs-2">
		<div class="col-lg-6 p-lg-4 mb-4">
		<?php 
		$zdjecie_6 = get_field('zdjecie_6');	
         if ($zdjecie_6) { ?>
            <img src="<?php echo $zdjecie_6['url']; ?>" alt="<?php echo $zdjecie_6['alt']; ?>" />
        <?php } ?>
		</div>
		<div class="col-lg-6 p-lg-4"><?php the_field('tekst_6'); ?></div>	
	</div>-->
	
	<div class="title-container" id="cennik">
		<h2>Cennik</h2>
	</div>
	
	<!-- Tabelka -->
	<div class="card-body table-responsive-xxl">
		<table class="table dataTable" id="tabelaCennik">
			<thead>
				<tr>
					<th style="width: 20%">Liczba eksportacji miesięcznie</th>
					<th style="width: 20%; text-align: center;">Do 10</th>
					<th style="width: 20%; text-align: center;">Do 15</th>
					<th style="width: 20%; text-align: center;">Do 25</th>
					<th style="width: 20%; text-align: center;">Powyżej 25</th>					
				</tr>
			</thead>
			<tbody>
			<?php

			// Check rows exists.
			if( have_rows('tabela') ):

				// Loop through rows.
				while( have_rows('tabela') ) : the_row();

				echo '<tr>';
				
					echo '<td>';
					the_sub_field('etykieta_kolumny');
					echo '</td>';
					
					echo '<td style="text-align: center;">';
					the_sub_field('do_10');
					echo '</td>';
					
					echo '<td style="text-align: center;">';
					the_sub_field('do_15');
					echo '</td>';
					
					echo '<td style="text-align: center;">';
					the_sub_field('do_25');
					echo '</td>';
					
					echo '<td style="text-align: center;">';
					the_sub_field('pow_25');
					echo '</td>';
					
				echo '</tr>';

				// End loop.
				endwhile;

			// No value.
			else :
				// Do something...
			endif;
			
			?>
			</tbody>
		</table>
	</div>
	
	<div id="zapytaj" class="ukryj py-4">	
		<div class="row">
			<div class="col-md-6">
				<h3>Zapytaj o cenę</h3>
				<?php echo do_shortcode( '[ninja_form id=4]' ); ?>
			</div>
		</div>
	</div>
	
	<div id="zapytaj2" class="ukryj py-4">
		<div class="row">
			<div class="col-md-6">
				<h3>Zapytaj o cenę</h3>
				<?php echo do_shortcode( '[ninja_form id=5]' ); ?>
			</div>
		</div>
	</div>
	
	<div id="zapytaj3" class="ukryj py-4">
		<div class="row">
			<div class="col-md-6">
				<h3>Zapytaj o cenę</h3>
				<?php echo do_shortcode( '[ninja_form id=6]' ); ?>
			</div>
		</div>
	</div>
	
	<div class="title-container" id="galeria">
		<h2>Galeria</h2>
	</div>
	<?php echo do_shortcode( '[pgc_simply_gallery id="261022"]' ); ?>
	

	
</div> <!-- container -->
<?php } ?>


<?php get_footer(); ?>
