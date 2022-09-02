<?php
/**
 * The template for displaying content in the single.php template.
 *
 */
acf_form_head();
get_header();
if(isset($_POST['_acf_form']) && !empty($_POST['_acf_form'])){
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
<style>
    .esez-container {
        max-width: 900px;
        padding: 32px 0;
    }

    .acfe-phone-number .iti .iti__flag-container .iti__selected-flag {
        border-radius: 0;
        border-right: 1px solid #666;
    }

    .input {
        border: 1px solid #666;
    }

    .acf-field input[type="text"],
    .acf-field input[type="password"],
    .acf-field input[type="number"],
    .acf-field input[type="search"],
    .acf-field input[type="email"],
    .acf-field input[type="url"],
    .acf-field textarea,
    .acf-field select {
        border-radius: 0.3rem;
        border: 1px solid #666;
    }

    @media (max-width: 800px) {

        .fixed-top,
        .sb-nav-fixed #layoutSidenav #layoutSidenav_nav,
        .sb-nav-fixed .sb-topnav {
            position: absolute !important;
        }
    }

    .acf-fields {
        border: 1px solid #E1E1E1;
    }

    /* pola */
    #acf-field_627cfd56b1d15,
    #acf-field_627cf75e7e3f1,
    #acf-field_6290abafe4b82-field_6298b5e9de204 {
        text-align: start;
    }

    #acf-field_627cf75e7e3f1,
    #acf-field_627cf4e87e3ee,
    #acf-field_627cfd56b1d15,
    #acf-field_627cf6c87e3ef,
    #acf-field_62a1b642910f9,
    #acf-field_6059d4efa0515,
    #acf-field_60112e303f973,
    #acf-field_60112e573f974,
    #acf-field_6017dfc3d014f,
    #dp1659535698987,
    .acf-date-picker,
    .acf-time-picker,
    .acf-date-time-picker,
    #acf-field_6137462544bfd,
    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295e8f260432>div.acf-input>div>div.acf-field.acf-field-number.acf-field-6295e90b60435.hide-label.-r0>div.acf-input,
    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295e8f260432>div.acf-input>div>div.acf-field.acf-field-text.acf-field-6295e8f260433.hide-label.-r0>div.acf-input,
    #acf-field_60097abd5a117,
    #acf-field_601151613f976,
    #acf-field_62a1b70830cd5,
    #acf-field_62cd382a10d31,
    #acf-field_627cf8307e3f2,
    #acf-field_627cf8fc7e3f3,
    #acf-field_601429bd3ccb6-field_601429bd3ccb9,
    #acf-field_601429bd3ccb6-field_601429bd3ccba,
    #acf-field_60140a20aeae8-field_60140d77aeaeb,
    #acf-field_60140a20aeae8-field_6014134caeaec,
    #acf-field_629378ceae433,
    #acf-field_6310c0e47d0df,
    .acfe-phone-number .iti {
        width: 37.7%;
    }

    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-text.acf-field-62a1df2beb547>div.acf-input {
        width: 13%;
    }

    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6290abafe4b82>div.acf-input>div>div.acf-field.acf-field-number.acf-field-6298b5e9de204.hide-label.-r0>div.acf-input,
    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295e93060436>div.acf-input>div>div.acf-field.acf-field-number.acf-field-6295e93060438.hide-label.-r0>div.acf-input {
        width: 18%;
    }

    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-628e500b88425>div.acf-input>div>div.acf-field.acf-field-text.acf-field-628e501e88426.hide-label.-r0>div.acf-input,
    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6290a31e922b8>div.acf-input>div>div.acf-field.acf-field-text.acf-field-6290a33e922b9.hide-label.-r0>div.acf-input {
        width: 30%;
    }

    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-60140a20aeae8>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-60140c56aeae9.-r0>div.acf-input>div,
    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295c733be746>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-6295c85bebd40.-r0>div.acf-input>div,
    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295c733be746>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-6295ca92ebd41.-r0>div.acf-input>div,
    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295f58acdbfa>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-6295f58acdbfb.-r0>div.acf-input>div,
    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295f58acdbfa>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-6295f58acdbfc.-r0>div.acf-input>div,
    #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-601429bd3ccb6>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-601429bd3ccb7.-r0>div.acf-input>div {
        width: 78%;
    }

    .acf-field input[type=text],
    .acf-field input[type=password],
    .acf-field input[type=date],
    .acf-field input[type=datetime],
    .acf-field input[type=datetime-local],
    .acf-field input[type=email],
    .acf-field input[type=month],
    .acf-field input[type=number],
    .acf-field input[type=search],
    .acf-field input[type=tel],
    .acf-field input[type=time],
    .acf-field input[type=url],
    .acf-field input[type=week],
    .acf-field textarea,
    .acf-field select {
        font-size: 1em !important;
    }

    @media (max-width: 992px) {

        #acf-field_627cf75e7e3f1,
        #acf-field_627cf4e87e3ee,
        #acf-field_627cfd56b1d15,
        #acf-field_627cf6c87e3ef,
        #acf-field_62a1b642910f9,
        #acf-field_6059d4efa0515,
        #acf-field_60112e303f973,
        #acf-field_60112e573f974,
        #acf-field_6017dfc3d014f,
        #dp1659535698987,
        .acf-date-picker,
        .acf-time-picker,
        .acf-date-time-picker,
        #acf-field_6137462544bfd,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295e8f260432>div.acf-input>div>div.acf-field.acf-field-number.acf-field-6295e90b60435.hide-label.-r0>div.acf-input,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295e8f260432>div.acf-input>div>div.acf-field.acf-field-text.acf-field-6295e8f260433.hide-label.-r0>div.acf-input,
        #acf-field_60097abd5a117,
        #acf-field_601151613f976,
        #acf-field_62a1b70830cd5,
        #acf-field_62cd382a10d31,
        #acf-field_627cf8307e3f2,
        #acf-field_627cf8fc7e3f3,
        #acf-field_601429bd3ccb6-field_601429bd3ccb9,
        #acf-field_601429bd3ccb6-field_601429bd3ccba,
        #acf-field_60140a20aeae8-field_60140d77aeaeb,
        #acf-field_60140a20aeae8-field_6014134caeaec,
        .acfe-phone-number .iti {
            width: 100%;
        }

        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-text.acf-field-62a1df2beb547>div.acf-input {
            width: 100%;
        }

        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6290abafe4b82>div.acf-input>div>div.acf-field.acf-field-number.acf-field-6298b5e9de204.hide-label.-r0>div.acf-input,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295e93060436>div.acf-input>div>div.acf-field.acf-field-number.acf-field-6295e93060438.hide-label.-r0>div.acf-input {
            width: 100%;
        }

        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-628e500b88425>div.acf-input>div>div.acf-field.acf-field-text.acf-field-628e501e88426.hide-label.-r0>div.acf-input,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6290a31e922b8>div.acf-input>div>div.acf-field.acf-field-text.acf-field-6290a33e922b9.hide-label.-r0>div.acf-input {
            width: 100%;
        }

        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-60140a20aeae8>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-60140c56aeae9.-r0>div.acf-input>div,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-60140a20aeae8>div.acf-input>div>div.acf-field.acf-field-time-picker.acf-field-60140ce9aeaea.-r0>div.acf-input>div,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295c733be746>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-6295c85bebd40.-r0>div.acf-input>div,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295c733be746>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-6295ca92ebd41.-r0>div.acf-input>div,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295f58acdbfa>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-6295f58acdbfb.-r0>div.acf-input>div,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-6295f58acdbfa>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-6295f58acdbfc.-r0>div.acf-input>div,
        #acf-form>div.acf-fields.acf-form-fields.-left>div.acf-field.acf-field-group.acf-field-601429bd3ccb6>div.acf-input>div>div.acf-field.acf-field-date-picker.acf-field-601429bd3ccb7.-r0>div.acf-input>div {
            width: 100%;
        }
    }

    @media (min-width: 1640px) {
        .totalcost-container {
            right: 32rem;
        }

        .drukuj {
            right: 39rem;
        }

        .acf-form-submit input {
            right: 31.8rem;
        }

        .go-to-top {
            right: 29rem;
        }

        .location-direct {
            right: 43rem;
        }
    }
</style>
<div id="esez-top" class="esez-container">
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
    });
</script>
<?php get_footer(); ?>