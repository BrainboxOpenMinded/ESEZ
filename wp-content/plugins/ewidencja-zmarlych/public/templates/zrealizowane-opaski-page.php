<?php 
get_header();

global $post;
global $current_user;
$post_id = $post->ID;
wp_get_current_user();
$authorID = $current_user->ID;
$user_info = get_userdata($authorID);
$first_name = $user_info->first_name;
$user = wp_get_current_user();
$allowed_roles = array( 'firma', 'firmapro', 'administrator' );

if(is_user_logged_in() ) : ?>
<div class="esez-container">
    <div class="row">
        <div id="esez">
        <?php if ( array_intersect( $allowed_roles, $user->roles ) ) : ?>    
        <h2 class="esez-title"><?php echo $first_name; ?></h2>
            <div class="table-navigation-container">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="/konto"
                            class="nav-link">W trakcie</a>
                    </li>
                    <li class="nav-item">
                        <a href="/konto/wolne" class="nav-link">Wolne</a>
                    </li>
                    <li class="nav-item">
                        <a href="/konto/zakonczone" class="nav-link active">Zrealizowane</a>
                    </li>
                    <?php if(get_field('kto_organizuje_pogrzeb') == false) : ?>
                    <li class="nav-item">
                        <a href="/konto/obce" class="nav-link">Obce</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="card no-padding mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Ewidencja Zgonów
                </div>
                <div class="card-body table-responsive-xxl">
                    <table class="table" id="datatablesZrealizowaneOpaski">
                        <thead>
                            <tr>
                                <th>Nr</th>
                                <th>Zasiłek</th>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>Pogrzeb</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nr</th>
                                <th>Zasiłek</th>
                                <th>Imię</th>
                                <th>Nazwisko</th>
                                <th>Pogrzeb</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $query = new WP_Query( array(
        'post_type' => array( 'post', 'ewidencjazgonow' ),
        'posts_per_page'=> 16,
        'paged' => $paged,
        'author' => $authorID,
        'fields' => 'ids',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'imie_zmarlego',
                'value'   => array(''),
                'compare' => 'NOT IN'
            ),
            array(
                'key' => 'kto_organizuje_pogrzeb',
                'value'   => true,
                'compare' => '=',
            ),
        ),
    ),
    );
    ?>
                            <?php
    if ( $query->have_posts() ) {
        		
        while ( $query->have_posts() ) : $query->the_post(); ?>
        <?php 
            $zasilek_pogrzebowy = get_field('zasilek_pogrzebowy_inne');
            $zasilek_pogrzebowy_odebrany = $zasilek_pogrzebowy['odebrac_zasilek_pogrzebowy'];
            $zasilek_pogrzebowy_zaksiegowany = $zasilek_pogrzebowy['zasilek_zaksiegowany'];
            $ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
            $ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
            $ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
            $dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
            $dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
                            ?>
                            <?php if(strtotime(date('d-m-Y H:i')) > strtotime($dzien_po_pogrzebie) && !empty(get_field('data_pogrzebu'))) : ?>
                            <tr>
                                <td class="text-nowrap"><?php echo '<a class="number-link" href="' . get_permalink() . '">' . get_field('numer_opaski') . '</a>'; ?></td>
                                <td class="status-icon">
                                    <?php if($zasilek_pogrzebowy_odebrany == true and $zasilek_pogrzebowy_zaksiegowany == 'tak') : echo '<span class="tooltip-right" data-tooltip="Zasiłek odebrany"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/zus-zielony.svg" /></span>'; endif; if($zasilek_pogrzebowy_odebrany == true and $zasilek_pogrzebowy_zaksiegowany == 'nie') : echo '<span class="tooltip-right" data-tooltip="Zasiłek niezaksięgowany"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/zus-czerwony.svg" /></span>'; endif; if($zasilek_pogrzebowy_odebrany == false) : echo '<span  class="tooltip-right" data-tooltip="Pogrzeb opłacony gotówką"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/dolar-zielony.svg" /></span>'; endif; ?>
                                </td>                                
                                <td class="text-nowrap"><?php if(get_field('imie_zmarlego')) : echo get_field('imie_zmarlego'); else : echo '-'; endif; ?></td>
                                <td class="text-nowrap"><?php if(get_field('nazwisko_zmarlego')) : echo get_field('nazwisko_zmarlego'); else : echo '-'; endif; ?></td>
                                <td class="text-nowrap"><?php if (!empty($ceremonia_pogrzegnalna_data)) : echo $ceremonia_pogrzegnalna_data . ' ' . $ceremonia_pogrzegnalna_godzina; else : echo '-'; endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
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
                            <?php wp_reset_postdata();
    } else { ?>
    <tr>
        <td>
            Brak danych...
        </td>
    </tr>
    <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php else :  ?>
        <div style="margin: 40px 0;">
            <h2 style="color: red;">Brak dostępu do zakładki..</h2>
        </div>
<?php endif; ?>
        </div>
    </div>
</div>
<?php endif;
get_footer();
?>