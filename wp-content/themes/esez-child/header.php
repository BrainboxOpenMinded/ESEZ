<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G1WE3SXCPR"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-G1WE3SXCPR');
    </script>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php wp_head(); ?>

    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
    <?php if ( current_user_can( 'administrator' ) ) { ?>
    <style>
        fixed-top,
        .sb-nav-fixed #layoutSidenav #layoutSidenav_nav,
        .sb-nav-fixed .sb-topnav {
            top: 32px !important;
        }
    </style>
    <?php } 
    if ( !is_user_logged_in() ) { ?>
    <style>
        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding-left: 0px;
        }
    </style>
    <?php } ?>

</head>

<?php
	$navbar_scheme   = get_theme_mod( 'navbar_scheme', 'navbar-light bg-light' ); // Get custom meta-value.
	$navbar_position = get_theme_mod( 'navbar_position', 'static' ); // Get custom meta-value.
	$search_enabled  = get_theme_mod( 'search_enabled', '1' ); // Get custom meta-value.

    acf_form_head();
    global $post;
    $author_id = $post->post_author;
?>

<body class="sb-nav-fixed">

    <?php wp_body_open(); ?>

    <a href="#main" class="visually-hidden-focusable"><?php esc_html_e( 'Skip to main content', 'esez' ); ?></a>

    <?php
    //if ( !is_page( 'login' ) ) : ?>
    <nav
        class="<?php if (is_user_logged_in()) : ?>sb-topnav<?php endif; ?> navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <?php if (is_user_logged_in()) : ?>
        <a class="navbar-brand" href="<?php if (is_user_logged_in()) : echo '/konto'; else : echo '/'; endif; ?>"><img
                src="/wp-content/plugins/ewidencja-zmarlych/public/img/eSEZ-medium-jasne.svg" /></a>
        <!-- Sidebar Toggle-->
        <?php endif; ?>
        <?php if (is_user_logged_in()) : ?>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <?php endif; ?>
        <!-- Navbar Search-->
        <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Szukaj..." aria-label="Szukaj..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form> -->
        <!-- Navbar-->
        <?php
            if (is_user_logged_in()) { ?>
        <ul class="navbar-nav ms-auto me-3 me-lg-4 ms-auto">
            <a href="/konto">
                <img class="header-zaklad-logo" src="<?php
            $current_user = wp_get_current_user(); 
            echo $current_user->image; ?>">
            </a>
        </ul>
        <?php } else { ?>

        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img
                    src="/wp-content/plugins/ewidencja-zmarlych/public/img/eSEZ-medium-jasne.svg" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/#galeria">Galeria</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#cennik">Cennik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/kontakt">Kontakt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Zaloguj</a>
                    </li>
                    <li class="nav-item flagi-header">
                        <?php echo do_shortcode('[gtranslate]'); ?>
                    </li>
                </ul>
            </div>
        </div>
        </div>



        <!-- <div class="navbar__button">
				<i class="navbar__icon fas fa-bars"></i>
			</div>
			<div class="navbar__container">
			<div class="navbar__links">
			<?php
			wp_nav_menu(array(
				'theme_location' => 'headerMenuLocation',
				'container' => NULL,
				'depth' => 2
			));
			?>
			</div>
		 -->
        <?php } ?>
    </nav>
    <?php if(get_field('imie_zmarlego') and get_field('nazwisko_zmarlego') || is_singular('ewidencjazgonow') ) : ?>
    <div id="fixed-name-area" class="fixed-name-area hide">
        <a
            href="#esez-top"><span><?php echo get_field('numer_opaski') . ' | ' . get_field('imie_zmarlego') . ' ' .  get_field('nazwisko_zmarlego'); ?></span></a>
    </div>
    <?php endif; ?>
    <?php if (is_user_logged_in()) : ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Panel użytkownika</div>
                        <a class="nav-link" href="/konto">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-bars-progress"></i></div>
                            Zlecenia w toku
                        </a>
                        <a class="nav-link" href="/konto/zakonczone">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                            Zlecenia zrealizowane
                        </a>
                        <a class="nav-link" href="/konto/wolne">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                            Wolne pakiety
                        </a>
                        <a class="nav-link" href="/konto/obce">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-square-minus"></i></div>
                            Pogrzeby obce
                        </a>
                        <a class="nav-link" href="/reset">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-key"></i></div>
                            ZMIANA HASŁA
                        </a>
                        <a class="nav-link" href="/pomoc">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-info"></i></div>
                            POMOC
                        </a>
                        <a class="nav-link"
                            href="<?php if (is_page('konto') || is_page('wolne') || is_page('zakonczone') || is_page('obce')) : echo wp_logout_url(get_permalink(33)); else : echo wp_logout_url( site_url( $_SERVER['REQUEST_URI'] ) ); endif; ?>">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-right-to-bracket"></i></div>
                            WYLOGUJ MNIE
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Zalogowany jako: </div>
                    <?php 
                        $current_user = wp_get_current_user();
                        echo $current_user->user_login; ?>
                </div>
                <?php endif; ?>
            </nav>
        </div>
        <?php //endif; ?>
        <?php if(is_page(33)) : ?>
        <?php
if ($_GET['login'] == 'failed') { ?>
        <style>
            .blad {
                padding: 20px;
                background-color: #f44336;
                color: white;
                opacity: 1;
                transition: opacity 0.6s;
                margin-bottom: 15px;
            }

            .closebtn {
                margin-left: 15px;
                color: white;
                font-weight: bold;
                float: right;
                font-size: 22px;
                line-height: 20px;
                cursor: pointer;
                transition: 0.3s;
            }

            .closebtn:hover {
                color: black;
            }
        </style>
        <div class="blad">
            <span class="closebtn">&times;</span>
            <strong>Błąd!</strong> Podałeś błędny login lub hasło. Spróbuj ponownie.
        </div>
        <script>
            var close = document.getElementsByClassName("closebtn");
            var i;

            for (i = 0; i < close.length; i++) {
                close[i].onclick = function () {
                    var div = this.parentElement;
                    div.style.opacity = "0";
                    setTimeout(function () {
                        div.style.display = "none";
                    }, 600);
                }
            }
        </script>
        <?php } ?>
        <?php endif; ?>
        <div id="layoutSidenav_content">
            <main>
                <div
                    class="container-fluid <?php if(!is_page('login')) : echo 'px-md-4 pt-3'; elseif(is_page('reset')) : echo 'px-md-4 pt-5'; endif; ?>">