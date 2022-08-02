<?php 
$dzien_pogrzebu = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
$dzien_pogrzebu =  date("d-m-Y H:i", strtotime($dzien_pogrzebu));  
$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_pogrzebu)));
$today = date( 'd-m-Y H:i' );
echo $dzien_po_pogrzebie;
$query = new WP_Query( array(
    'post_type' => array( 'ewidencjazgonow' ),
    'author' => $authorID,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'imie_zmarlego',
            'value'   => array(''),
            'compare' => 'NOT IN'
        ),
        array(
            'key'=> $dzien_pogrzebu,
            'value' => $dzien_po_pogrzebie,
            'compare' => '=',
            'type' => 'DATE', 
        ),
        array(
            'key'     => 'kto_organizuje_pogrzeb',
            'value'   => true,
            'compare' => '=',
        ),
    ),
),
);
if (!($query->have_posts())) : ?>
                            <div class="blob green"></div>
                            <?php else : ?>
                            <div class="blob red"></div>
                            <?php endif; ?>