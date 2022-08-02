<?php
/**
 * The template for displaying content in the single.php template.
 *
 */
acf_form_head();
get_header();

global $post;
$author_id = $post->post_author;
$user = get_the_author_meta( 'ID' );
global $current_user;
wp_get_current_user();

if (is_user_logged_in() && $current_user->ID == $post->post_author) : ?>
<div class="esez-container">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="esez-header">
            <h1 class="esez-title">Numer opaski: <?php the_field('numer_opaski'); ?></h1>
        </header><!-- /.entry-header -->
        <?php
			acf_form();
            if(get_field('uslugi_pogrzebowe')) :
            include('/home/esez/public_html/wp-content/plugins/ewidencja-zmarlych/public/templates/cennik-uslug-pogrzebowych.php');
            endif; ?>

        <?php 
        
        $images = get_field('zdjecia_dokumentow');
        if( $images ): ?>

        <div class="single-esez__gallery">
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
                <img class="profile-image" src="/wp-content/themes/esez-child/img/Sygnet ESEZ Ciemny.webp">
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
<?php if (is_user_logged_in() && $current_user->ID != $post->post_author) : ?>
<div style="margin: 80px 0;">
    <h2 style="color: red;">Brak dostępu do podanej opski</h2>
</div>
<?php endif; ?>
<?php get_footer(); ?>