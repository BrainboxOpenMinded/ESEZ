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

if(is_user_logged_in()) : ?>
<div class="esez-container">
    <div class="row">
        <div id="esez">
            <h2 class="esez-title"><?php echo $first_name; ?></h2>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="/konto"
                        class="nav-link">W trakcie</a>
                </li>
                <li class="nav-item">
                    <a href="/konto/wolne" class="nav-link active">Wolne</a>
                </li>
                <?php if ( array_intersect( $allowed_roles, $user->roles ) ) : ?>
                <li class="nav-item">
                    <a href="/konto/zakonczone" class="nav-link">Zrealizowane</a>
                </li>
                <?php endif; ?>
                <?php if(get_field('kto_organizuje_pogrzeb') == false) : ?>
                <li class="nav-item">
                    <a href="/konto/obce" class="nav-link">Obce</a>
                </li>
                <?php endif; ?>
            </ul>
            <div class="card no-padding mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Ewidencja Zgonów
                </div>
                <div class="card-body table-responsive-xxl">
                    <table class="table" id="datatablesWolneOpaski">
                        <thead>
                            <tr>
                                <th>Nr</th>
                                <th>Aktywacja</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nr</th>
                                <th>Aktywacja</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $query = new WP_Query( array(
            'post_type' => array( 'post', 'ewidencjazgonow' ),
            'posts_per_page'=> 20,
            'paged' => $paged,
            'author' => $authorID,
            'post_status' => 'publish',
            'fields' => 'ids',
            'cache_results' => false,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'orderby'			=> 'meta_value',
            'order'				=> 'DESC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'imie_zmarlego',
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key' => 'nazwisko_zmarlego',
                    'compare' => 'NOT EXISTS'
                ),
            ),
            )
        );
    if ($query->have_posts()) :

        while ( $query->have_posts() ) : $query->the_post(); ?>
                            <tr>
                                <td><?php echo '<a class="number-link" href="' . get_permalink() . '">' . get_field('numer_opaski') . '</a>'; ?></td>
                                <td><?php echo '<a class="number-link" href="' . get_permalink() . '">Aktywuj opaskę</a>'; ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <div class="pagination">
                                <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links( array(
                'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $query->max_num_pages
                ) );
            ?>
                            </div>
                            <br>
                            <?php wp_reset_postdata(); else : ?> 
                            <tr>
                                <td>
                                    Brak danych...
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;
get_footer();
?>