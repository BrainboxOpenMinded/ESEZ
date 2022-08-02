<?php 
get_header();
global $post;
global $current_user;
$post_id = $post->ID;
get_currentuserinfo();
$authorID = $current_user->ID;
$user_info = get_userdata($authorID);
$first_name = $user_info->first_name;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$query = new WP_Query( array(
    'post_type' => array( 'post', 'ewidencjazgonow' ),
    'posts_per_page'=> 8,
    'paged' => $paged,
    'author' => $authorID,
    'no_found_rows' => true, 
	'update_post_meta_cache' => false, 
	'update_post_term_cache' => false,
    'fields' => 'ids',
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key'     => 'zrealizowano_pogrzeb',
            'value'   => '0',
            'compare' => '=',
        ),
        array(
            'key'     => 'zrealizowano_pogrzeb',
            'compare' => 'NOT EXISTS',
            )
        ),
    )
);
if(is_user_logged_in()) : ?>
<div class="esez-container">
    <div class="row">
    <h1 class="esez-title">Konto: <?php echo $first_name; ?></h1>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="/konto/" class="nav-link active">W trakcie</a>
        </li>
        <li class="nav-item">
            <a href="/konto/all/" class="nav-link">Wolne</a>
        </li>
        <li class="nav-item">
            <a href="/konto/ended/" class="nav-link">Zrealizowane</a>
        </li>
    </ul>
    <div class="card no-padding mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Ewidencji Zgonów
            </div>
            <div class="card-body table-responsive-xxl">
                <table class="table" id="datatablesWTrakcie">
                    <thead>
                        <tr>
                            <th>Nr</th>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>PESEL</th>
                            <th>Data odbioru</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nr</th>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>PESEL</th>
                            <th>Data odbioru</th>
                        </tr>
                    </tfoot>
                    <tbody>
<?php
    if ( $query->have_posts() ) {
        		
        while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php if(get_field('imie_zmarlego')) : ?>
                <tr>
                    <td><?php echo '<a href="' . get_permalink() . '">' . get_field('numer_opaski') . '</a>'; ?></td>
                    <td><?php echo get_field('imie_zmarlego') ?></td>
                    <td><?php echo get_field('nazwisko_zmarlego')?></td>
                    <td><?php if(!empty(get_field('pesel'))) : echo get_field('pesel'); else : echo 'Nie podano'; endif;?></td>
                    <td><?php echo get_field('data_odbioru_ciala'); ?></td>
                </tr>

                <?php endif; ?>
        <?php endwhile;
        
        $total_pages = $loop->max_num_pages;

        if ($total_pages > 1){

            $current_page = max(1, get_query_var('paged'));

            echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => '/s/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text'    => __('« poprzednia'),
                'next_text'    => __('nstępna »'),
            ));
        }
        wp_reset_postdata();
    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br>
<?php endif;
echo do_shortcode( '[wp-datatable id="datatablesWTrakcie" fat="1"]
paging: true,
responsive: true,
search: true,
[/wp-datatable]');
get_footer();
?>