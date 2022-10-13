<?php
/**
 * The template for displaying content in the single.php template.
 *
 */
acf_form_head();
get_header(); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css" integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php if(isset($_POST['_acf_form']) && !empty($_POST['_acf_form'])){
    echo 'Success!';
}
global $post;
$author_id = $post->post_author;
$user = get_the_author_meta( 'ID' );
$adres_odbioru = get_field('adres_odbioru_inne');
$adres_odbioru_miasto = $adres_odbioru['adres_odbioru_inne-miasto'];
$adres_odbioru_adres = $adres_odbioru['adres_odbioru_inne-ulica-nr-domu'];
$adres_odbioru_nazwa = $adres_odbioru['adres_odbioru_inne-nazwa'];
$adres_odbioru_dom = get_field('adres_odbioru_dom');
$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
$adres_odbioru_dom_adres = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
global $current_user;
wp_get_current_user();
$items = array();

foreach( get_multiple_authors() as $coauthor ) {
     $items[] = $coauthor->ID;
}

if (is_user_logged_in() && in_array($current_user->ID, $items) || current_user_can('administrator')) : ?>
<div id="esez-top" class="esez-container single-esez">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="esez-header">
            <h1 class="esez-title">Numer opaski: <?php the_field('numer_opaski'); ?></h1>
        </header><!-- /.entry-header -->
        <?php
			acf_form(array(
                'label_placement' => 'left',
                'updated_message' => __("Zaktualizowano dane!", 'acf'),
                'uploader' => 'basic'
            ));
            if(get_field('uslugi_pogrzebowe')) :
                if(!current_user_can('pracownik')) :
                    include('/home/esez/public_html/wp-content/plugins/ewidencja-zmarlych/public/templates/cennik-uslug-pogrzebowych.php');
                endif;
            endif;
		?>
        <?php 
        
        $images = get_field('zdjecia_dokumentow');
        if( $images ): ?>

        <div id="pogladZdjec" class="single-esez__gallery">
            <h4 class="single-esez__gallery__title">Podgląd dodanych zdjęć</h4>
            <?php foreach( $images as $image ): ?>
            <a href="<?php echo $image['url']; ?>" data-lightbox="galeria"><img  
                    class="single-ewidencjazgonow__gallery__img"
                    src="<?php echo $image['sizes']['ewidencja-zdjecie']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
            <?php endforeach; ?>

        </div>
        <?php endif; ?>
</div><!-- /.entry-content -->
</article><!-- /#post-<?php the_ID(); ?> -->
<a href="#dane_zmarlego" class="go-to-top">&#8593;</a>
<a target="_blank" href="/drukuj?ewidencja_id=<?php the_ID(); ?>" class="drukuj"><i class="fa fa-print" aria-hidden="true"></i></a>
<?php 
        if(get_field('miejsce_odbioru') == 'Dom' && $adres_odbioru_dom_miasto) : ?>
            <a class="location-direct" target="_blank" href="https://www.google.com/maps/dir//<?php echo $adres_odbioru_dom_adres . ', ' . $adres_odbioru_dom_miasto; ?>"><i class="fa-solid fa-route"></i></a>
        <?php endif; ?>
        <?php if($adres_odbioru_miasto && get_field('miejsce_odbioru') != 'Dom') : ?>
            <a class="location-direct" target="_blank" href="https://www.google.com/maps/dir//<?php echo $adres_odbioru_adres . ', ' . $adres_odbioru_miasto . ', ' . $adres_odbioru_nazwa; ?>"><i class="fa-solid fa-route"></i></a>
        <?php endif; ?>
<?php endif; ?>
<?php if(!is_user_logged_in()) : ?>
<style>
    .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
        padding-left: 0px;
    }
    @media (max-width: 800px) {
        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding-left: 225px;
            top: 56px;
        }
    }
</style>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="esez-content">
        <?php if(!empty(get_field('imie_zmarlego')) || !empty(get_field('nazwisko_zmarlego'))) : ?>
        <div class="profile-card">
            <div class="profile-card-header">
                <?php if(get_field('kto_organizuje_pogrzeb') == true ) : ?>
                <img class="profile-image" src="<?php echo get_the_author_meta( 'image', $author_id ); ?>">
                <?php else : ?>
                <img class="profile-image" src="/wp-content/plugins/ewidencja-zmarlych/public/img/logo-obcy-esez.webp">
                <?php endif; ?>
                <div class="profile-info">
                    <h3 class="profile-name">
                        <?php echo get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego'); ?></h3>
                    <p class="profile-desc">
                        <?php if(get_field('kto_organizuje_pogrzeb') == true ) : echo 'Odbiór: ' . get_field('data_odbioru_ciala'); else : echo 'wydanie: ' . get_field('data_wydania_ciala'); endif; if(get_field('firma_organizujaca_pogrzeb') && get_field('kto_organizuje_pogrzeb') == false ) : echo '<br>' . 'dla ' . get_field('firma_organizujaca_pogrzeb'); endif; ?>
                    </p>
                    <?php $link = get_field('link_do_nekrologu');
				if ($link) {
					echo 'Link do nekrologu:<br><a href="' . $link . '" target="_blank" rel="noopener">' . $link . '</a>';
				} ?>
                </div>
            </div>

            <div class="profile-card-body">
                <br>
                <h6>Zaloguj się, aby edytować</h6>
                <?php 
                                        $args = array(
                                            'echo'           => true,
                                            'redirect'       => site_url( $_SERVER['REQUEST_URI'] ),
                                            'placeholder_username' => __( 'Podaj login...' ),
                                            'placeholder_password' => __( 'Podaj hasło...' ),
                                            'label_log_in'   => __( 'Zaloguj się' ),
                                            'form_id'        => 'seminar-login',
                                            'label_username' => __( 'Login' ),
                                            'label_password' => __( 'Hasło' ),
                                            'label_remember' => __( 'Zapamiętaj mnie' ),
                                            'id_username'    => 'user_login',
                                            'id_password'    => 'user_pass',
                                            'id_submit'      => 'wp-submit',
                                            'remember'       => true,
                                            'value_username' => NULL,
                                            'value_remember' => true
                                        );
                                        wp_login_form($args);
                                    ?>
            </div>
        </div>

        <?php else: ?>
        <div class="profile-card">
            <div class="profile-card-header">
                <?php if(get_field('kto_organizuje_pogrzeb') == true ) : ?>
                <img class="profile-image" src="<?php echo get_the_author_meta( 'image', $author_id ); ?>">
                <?php else : ?>
                    <img class="profile-image" src="<?php echo get_the_author_meta( 'image', $author_id ); ?>">
                <?php endif; ?>
                <div class="profile-info">
                    <p class="profile-desc"><?php echo get_the_author_meta( 'first_name', $author_id ); ?></p>
                    <h3 style="color: green;" class="profile-name">Pakiet gotowy do aktywacji</h3>
                </div>
            </div>

            <div class="profile-card-body">
                <br>
                <h6>Zaloguj się, aby uzupełnić dane</h6>
                <?php 
                                        $args = array(
                                            'echo'           => true,
                                            'redirect'       => site_url( $_SERVER['REQUEST_URI'] ),
                                            'label_log_in'   => __( 'Zaloguj się' ),
                                            'form_id'        => 'seminar-login',
                                            'placeholder_username' => __( 'Podaj login...' ),
                                            'placeholder_password' => __( 'Podaj hasło...' ),
                                            'label_username' => __( 'Login' ),
                                            'label_password' => __( 'Hasło' ),
                                            'label_remember' => __( 'Zapamiętaj mnie' ),
                                            'id_username'    => 'user_login',
                                            'id_password'    => 'user_pass',
                                            'id_submit'      => 'wp-submit',
                                            'remember'       => true,
                                            'value_username' => NULL,
                                            'value_remember' => true
                                        );
                                        wp_login_form($args);
                                    ?>
            </div>
        </div>
        <?php endif; ?>
    </div><!-- /.entry-content -->
</article><!-- /#post-<?php the_ID(); ?> -->
<?php endif; ?>
<?php if (is_user_logged_in() && !in_array($current_user->ID, $items)) : ?>
<div style="margin: 80px 0;">
    <h2 style="color: red;">Brak dostępu do podanej opski</h2>
</div>
<?php endif; ?>
<script>
    jQuery(document).ready(function ($) {
        // handle links with @href started with '#' only
        $(document).on('click', 'a[href^="#"]', function (e) {
            // target element id
            var id = $(this).attr('href');

            // target element
            var $id = $(id);
            if ($id.length === 0) {
                return;
            }

            // prevent standard hash navigation (avoid blinking in IE)
            e.preventDefault();

            // top position relative to the document
            var pos = $id.offset().top - 100;

            // animated top scrolling
            $('body, html').animate({
                scrollTop: pos
            });
        });
        if ($(window).width() < 992) {
            $(document).scroll(function () {

                myID = document.getElementById("fixed-name-area");

                var myScrollFunc = function () {
                    var y = window.scrollY;
                    if (y >= 300) {
                        myID.className = "fixed-name-area show"
                    } else {
                        myID.className = "fixed-name-area hide"
                    }
                };

                window.addEventListener("scroll", myScrollFunc);
            });
        }
        $("#pogladZdjec").appendTo("#dodajDokumenty");
        lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true,
      'albumLabel' : "Zdjęcie %1 z %2"
    })
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php get_footer(); ?>