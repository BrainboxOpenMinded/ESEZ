<?php 
get_header();
?>
<?php
global $post;
global $current_user;
$post_id = $post->ID;
wp_get_current_user();
$authorID = $current_user->ID;
$user_info = get_userdata($authorID);
$first_name = $user_info->first_name;
$user = wp_get_current_user();
$allowed_roles = array( 'firma', 'firmapro', 'administrator' );
function dateV($format,$timestamp=null){
	$to_convert = array(
		'l'=>array('dat'=>'N','str'=>array('Pn','Wt','Śr','Cz','Pt','Sb','Nd')),
		'F'=>array('dat'=>'n','str'=>array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień')),
		'f'=>array('dat'=>'n','str'=>array('stycznia','lutego','marca','kwietnia','maja','czerwca','lipca','sierpnia','września','października','listopada','grudnia'))
	);
	if ($pieces = preg_split('#[:/.\-, ]#', $format)){	
		if ($timestamp === null) { $timestamp = time(); }
		foreach ($pieces as $datepart){
			if (array_key_exists($datepart,$to_convert)){
				$replace[] = $to_convert[$datepart]['str'][(date($to_convert[$datepart]['dat'],$timestamp)-1)];
			}else{
				$replace[] = date($datepart,$timestamp);
			}
		}
		$result = strtr($format,array_combine($pieces,$replace));
		return $result;
	}
}

if(is_user_logged_in()) : ?>
<div class="esez-container">
    <div class="row">
        <div id="esez">
            <h2 class="esez-title"><?php echo $first_name; ?></h2>
            <?php

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$query = new WP_Query( array(
    'post_type' => array( 'post', 'ewidencjazgonow' ),
    'posts_per_page'=> 100,
    'paged' => $paged,
    'author' => $authorID,
    'meta_key'			=> 'data_odbioru_ciala',
	'orderby'			=> 'meta_value',
	'order'				=> 'DESC',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'imie_zmarlego',
            'value'   => array(''),
            'compare' => 'NOT IN'
        ),
        array(
            'key'     => 'kto_organizuje_pogrzeb',
            'value'   => true,
            'compare' => '=',
        ),
    ),
),
);
    if ( $query->have_posts() ) : ?>

            <div class="table-navigation-container">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="/konto" class="nav-link active">
                            W trakcie
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/konto/wolne" class="nav-link">Wolne</a>
                    </li>
                    <?php if ( array_intersect( $allowed_roles, $user->roles ) ) : ?>
                    <li class="nav-item">
                        <a href="/konto/zakonczone" class="nav-link">Zrealizowane</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="/konto/obce" class="nav-link">Obce</a>
                    </li>
                </ul>
            </div>
            <div class="card no-padding mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Ewidencja Zgonów
                </div>
                <div class="card-body table-responsive-xxl">
                    <table class="table align-middle" id="datatablesWTrakcie">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Nr</th>
                                <th class="text-nowrap">Typ</th>
                                <th class="text-nowrap">Imię</th>
                                <th class="text-nowrap">Nazwisko</th>
                                <th class="text-nowrap">Eksportacja</th>
                                <th class="text-nowrap">Kremacja</th>
                                <th class="text-nowrap">Odbiór urny</th>
                                <th class="text-nowrap">Pożegnanie</th>
                                <th class="text-nowrap">Wyprowadzenie</th>
                                <th class="text-nowrap">Akcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-nowrap">Nr</th>
                                <th class="text-nowrap">Typ</th>
                                <th class="text-nowrap">Imię</th>
                                <th class="text-nowrap">Nazwisko</th>
                                <th class="text-nowrap">Eksportacja</th>
                                <th class="text-nowrap">Kremacja</th>
                                <th class="text-nowrap">Odbiór urny</th>
                                <th class="text-nowrap">Pożegnanie</th>
                                <th class="text-nowrap">Wyprowadzenie</th>
                                <th class="text-nowrap">Akcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                            <?php 
                            $ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
                            $ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
                            $ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
                            $data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
                            $dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
                            $dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));

                            $data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
                            $data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
                            $data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
                            $data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
                            $data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
                            $data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
                            $data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
                            $data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
                            $data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
                            $data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
                            $data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
                            $data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
                            
                            $adres_odbioru_inne = get_field('adres_odbioru_inne');
                            $adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
                            $adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
                            $adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];

                            $adres_odbioru_dom = get_field('adres_odbioru_dom');
                            $adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
                            $adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];

                            $adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
                            $adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];

                            $text_adres_inne = get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . ' | Adres odbioru: ' . $adres_odbioru_inne_nazwa . ' ' . $adres_odbioru_inne_miasto . ' ' . $adres_odbioru_inne_ulica . ' | Data odbioru: ' . $data_odbioru_ciala_wiadomosc . ' | ' . get_permalink();
                            $text_adres_dom = get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . ' | Adres odbioru: ' . $adres_odbioru_dom_nazwa . ' ' . $adres_odbioru_dom_miasto . ' ' . $adres_odbioru_dom_ulica . ' | Data odbioru: ' . $data_odbioru_ciala_wiadomosc . ' | ' . get_permalink();

                            $nastepna_klasa_css++

                            ?>
                            <?php if(strtotime(date('d-m-Y H:i')) < strtotime($dzien_po_pogrzebie) || empty(get_field('data_pogrzebu'))) : ?>
                            <?php $post_ids[] = get_the_ID(); ?>
                            <tr>
                                <td class="text-nowrap">
                                    <?php echo '<a class="number-link" href="' . get_permalink() . '">' . get_field('numer_opaski') . '</a>'; ?>
                                </td>
                                <td class="status-icon text-nowrap">
                                    <?php if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' and get_field('kremacja_wykonana') == false) : echo '<span class="tooltip-right" data-tooltip="Kremacja w toku"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/pogrzeb-kremacyjny-w-toku.svg" /></span>'; endif; if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' and get_field('kremacja_wykonana') == true) : echo '<span class="tooltip-right" data-tooltip="Kremacja zakończona" style="color:green;"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/pogrzeb-kremacyjny-zakonczony.svg"/>'; endif; if(get_field('rodzaj_pogrzebu_zmarly')=='Tradycyjny') : echo '<span class="tooltip-right" data-tooltip="Pogrzeb tradycyjny"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/pogrzeb-tradycyjny.svg" /></span>'; endif; if(get_field('rodzaj_pogrzebu_zmarly')=='Nieokreślony') : echo '-'; endif; ?>
                                </td>
                                <td class="text-nowrap"><?php if(get_field('imie_zmarlego')) : echo get_field('imie_zmarlego'); else : echo '-'; endif; ?></td>
                                <td class="text-nowrap"><?php if(get_field('nazwisko_zmarlego')) : echo get_field('nazwisko_zmarlego'); else : echo '-'; endif; ?></td>
                                <td class="text-nowrap">
                                    <?php if( !empty(get_field('data_odbioru_ciala'))) : echo date("d.m", strtotime(get_field('data_odbioru_ciala'))) . ' (' . dateV('l',strtotime(get_field('data_odbioru_ciala'))) . ") " . date("H:i", strtotime(get_field('data_odbioru_ciala'))); if(current_user_can('firmapro') || current_user_can('administrator')) : echo '<a class="tooltip-right" data-tooltip="Dodaj do kalendarza" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=E | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_odbioru_ciala. '/' . $data_odbioru_ciala_po_godzinie . '&details=Odebrać ciało zmarłego.<br><br><u><strong>DANE ZGŁASZAJĄCEGO</strong></u><br><strong>Miejsce:</strong> ' . get_field('miejsce_odbioru') . '<br><strong>Waga:</strong> ' . get_field('waga') . ' kg<br><strong>Zgłaszający:</strong> ' . get_field('imie_nazwisko_zglaszajacego') . '<br><strong>Tel:</strong> ' . get_field('telefon_zglaszajacego') . '<br>' . get_field('notatka') . '<br><br>________<br>' .  get_permalink() . '&location=' . $adres_odbioru_dom_miasto . $adres_odbioru_inne_miasto . ', ' . $adres_odbioru_dom_ulica . $adres_odbioru_inne_ulica . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>';endif; endif; if(empty(get_field('data_odbioru_ciala'))) : echo '-'; endif; ?>
                                    <?php 
                                    if(current_user_can('firmapro') || current_user_can('administrator')) :
                                    if(get_field('miejsce_odbioru') == 'Dom' && $adres_odbioru_dom_miasto) : ?>
                                    <a class="qrcode-icon" target="_blank"
                                        href="https://www.google.com/maps/dir//<?php echo $adres_odbioru_dom_ulica . ', ' . $adres_odbioru_dom_miasto; ?>"><i
                                            class="fa-solid fa-route"></i></a>
                                    <?php endif; ?>
                                    <?php if($adres_odbioru_inne_miasto && get_field('miejsce_odbioru') != 'Dom') : ?>
                                    <a class="qrcode-icon" target="_blank"
                                        href="https://www.google.com/maps/dir//<?php echo $adres_odbioru_inne_ulica . ', ' . $adres_odbioru_inne_miasto . ', ' . $adres_odbioru_inne_nazwa; ?>"><i
                                            class="fa-solid fa-route"></i></a>
                                    <?php endif; endif; ?>
                                </td>
                                <td class="text-nowrap">
                                    <?php if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' && !empty(get_field('data_kremacji'))) : echo date("d.m", strtotime(get_field('data_kremacji'))) . ' (' . dateV('l',strtotime(get_field('data_kremacji'))) . ") " . date("H:i", strtotime(get_field('data_kremacji'))); if(current_user_can('firmapro') || current_user_can('administrator')) : echo '<a class="tooltip-right" data-tooltip="Dodaj do kalendarza" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=K | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_kremacja . '/' . $data_kremacja_po_godzinie . '&details=Kremacja zwłok.<br><br>________<br>' .  get_permalink() . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>'; endif; else : echo '-'; endif; ?>
                                </td>
                                <td class="text-nowrap">
                                    <?php if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' && !empty(get_field('data_odebrania_urny'))) : echo date("d.m", strtotime(get_field('data_odebrania_urny'))) . ' (' . dateV('l',strtotime(get_field('data_odebrania_urny'))) . ") " . date("H:i", strtotime(get_field('data_odebrania_urny'))); if(current_user_can('firmapro') || current_user_can('administrator')) : echo '<a class="tooltip-right" data-tooltip="Dodaj do kalendarza" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=KO | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_kremacja_odbior_urny . '/' . $data_kremacja_odbior_urny_po_godzinie . '&details=Odebrać urnę z krematorium.<br><br>________<br>' .  get_permalink() . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>'; endif; else : echo '-'; endif; ?>
                                <td class="text-nowrap">
                                    <?php if (!empty($ceremonia_pogrzegnalna_data)) : echo date("d.m", strtotime($ceremonia_pogrzegnalna_data)) . ' (' . dateV('l',strtotime($ceremonia_pogrzegnalna_data)) . ") " . date("H:i", strtotime($ceremonia_pogrzegnalna_godzina)); if(current_user_can('firmapro') || current_user_can('administrator')) : echo '<a class="tooltip-top" data-tooltip="Dodaj do kalendarza" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=P | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_pozegnania . '/' . $data_pozegnania_po_godzinie . '&details=Ceremonia pożegnalna.<br><br>________<br>' .  get_permalink() . '&location=' . $adres_ceremoni_pozegnalnej_adres . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>'; endif; else : echo '-'; endif; ?>
                                </td>
                                <td class="text-nowrap">
                                    <?php if(get_field('godzina_pogrzebu')) : echo date("d.m", strtotime(get_field('data_pogrzebu'))) . ' (' . dateV('l',strtotime(get_field('data_pogrzebu'))) . ") " . date("H:i", strtotime(get_field('godzina_pogrzebu'))); if(current_user_can('firmapro') || current_user_can('administrator')) : echo '<a data-tooltip="Dodaj do kalendarza" class="tooltip-top" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=W | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_wyprowadzenie . '/' . $data_wyprowadzenie_po_godzinie . '&details=Wyprowadzenie do grobu.<br><br>________<br>' .  get_permalink() . '&location=' . get_field('adres_cmentarza') . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>'; endif; else : echo '-'; endif; ?>
                                </td>
                                <td class="text-nowrap">
                                    <a class="tooltip-top" data-tooltip="Drukowanie zestawienia" target="_blank"
                                        href="/drukuj?ewidencja_id=<?php the_ID(); ?>"><i class="fa fa-print"
                                            aria-hidden="true"></i></a>
                                    <a data-tooltip="Drukowanie etykiety" class="qrcode-icon tooltip-top"
                                        target="_blank" href="/etykieta?ewidencja_id=<?php the_ID(); ?>"><i
                                            class="fa-solid fa-barcode"></i></a>
                                    <a data-tooltip="Wyślij SMSa" class="qr-download qrcode-icon tooltip-top" href="sms:?&body=<?php if(get_field('miejsce_odbioru') == 'Dom' && $adres_odbioru_dom_miasto) : ?><?php echo $text_adres_dom; ?><?php endif; ?><?php if($adres_odbioru_inne_miasto && get_field('miejsce_odbioru') != 'Dom') : ?><?php echo $text_adres_inne; ?>
                                    <?php endif; ?>"><i class="fa-solid fa-comment-sms"></i></a>
                                    <?php if(current_user_can('firmapro') || current_user_can('administrator')) : ?>
                                    <a data-tooltip="Udostępnij opaskę" class="qr-download qrcode-icon tooltip-top share-button<?php echo $nastepna_klasa_css; ?>"><i
                                            class="fa-solid fa-share-nodes"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <script>
                                const shareButton<?php echo $nastepna_klasa_css; ?> = document.querySelector(
                                    '.share-button<?php echo $nastepna_klasa_css; ?>');
                                if (shareButton<?php echo $nastepna_klasa_css; ?> ) {
                                    shareButton<?php echo $nastepna_klasa_css; ?> .addEventListener('click', event => {
                                        if (navigator.share) {
                                            navigator.share({
                                                    title: '<?php echo get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego'); ?>',
                                                    text: '<?php if(get_field('miejsce_odbioru') == 'Dom' && $adres_odbioru_dom_miasto) : echo $text_adres_dom; elseif($adres_odbioru_inne_miasto && get_field('miejsce_odbioru') != 'Dom') : echo $text_adres_inne; endif;?>'
                                                }).then(() => {
                                                    console.log('Udostępniłeś nekrolog!');
                                                })
                                                .catch(console.error);
                                        }
                                    });
                                }
                            </script>
                            <?php endwhile; ?>
                            <div class="pagination">
                                <?php
            $big = 999999999;
            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $query->max_num_pages,
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;'
            ) );
            ?>
                            </div>
                            <?php
        wp_reset_postdata(); ?>
                            <?php else : ?>
                            <div class="table-navigation-container">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a href="/konto" class="nav-link active">W trakcie</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/konto/wolne" class="nav-link">Wolne</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/konto/zakonczone" class="nav-link">Zrealizowane</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/konto/obce" class="nav-link">Obce</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card no-padding mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Ewidencja Zgonów
                                </div>
                                <div class="card-body table-responsive-xxl">
                                    <table class="table" id="datatablesWTrakcie">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap">Nr</th>
                                                <th class="text-nowrap">Typ</th>
                                                <th class="text-nowrap">Imię</th>
                                                <th class="text-nowrap">Nazwisko</th>
                                                <th class="text-nowrap">Eksportacja</th>
                                                <th class="text-nowrap">Kremacja</th>
                                                <th class="text-nowrap">Odbiór urny</th>
                                                <th class="text-nowrap">Pożegnanie</th>
                                                <th class="text-nowrap">Wyprowadzenie</th>
                                                <th class="text-nowrap">Akcje</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-nowrap">Nr</th>
                                                <th class="text-nowrap">Typ</th>
                                                <th class="text-nowrap">Imię</th>
                                                <th class="text-nowrap">Nazwisko</th>
                                                <th class="text-nowrap">Eksportacja</th>
                                                <th class="text-nowrap">Kremacja</th>
                                                <th class="text-nowrap">Odbiór urny</th>
                                                <th class="text-nowrap">Pożegnanie</th>
                                                <th class="text-nowrap">Wyprowadzenie</th>
                                                <th class="text-nowrap">Akcje</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('#datatablesWTrakcie').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.12.0/i18n/pl.json'
                    },
                    paging: false,
                    responsive: true,
                    search: false,
                    dom: 'lrt',
                    type: 'date',
                    def: function () {
                        return Date();
                    },
                    dateFormat: "dd.MM"
                });
            });
        </script>
        <?php get_footer(); ?>