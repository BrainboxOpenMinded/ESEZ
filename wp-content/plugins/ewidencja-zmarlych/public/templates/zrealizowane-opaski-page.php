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
                    <span class="header-table-title">Zlecenia zrealizowane</span>
                    <a type="button" id="btn-reload"><i class="fa-solid fa-arrows-rotate"></i></a>
                </div>
                <div class="card-body table-responsive-xxl">
                    <table class="table hover order-column" id="datatablesZrealizowaneOpaski">
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
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<?php endif; ?>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function($) {
 
  var table = $('#datatablesZrealizowaneOpaski').DataTable({
    ajax: {
        url: datatablesajax.url + '?action=getpostsfordatatableszrealizowane'
    },
    language: {
        'loadingRecords': '&nbsp;',
        'processing': '<div class="loader-div"><div class="loader-pulse"></div></div>',
        "search": "Szukaj:",
        "lengthMenu": "Pokaż _MENU_ pozycji",
        "info": "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
        "infoEmpty": "Pozycji 0 z 0 dostępnych",
        "infoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
        "zeroRecords": "Nie znaleziono pasujących pozycji",
        "paginate": {
            "first": "Pierwsza",
            "previous": "Poprzednia",
            "next": "Następna",
            "last": "Ostatnia"
        },
    },
    columns: [
        { data: 'nr' },
        { data: 'zasilek' },
        { data: 'imie' },
        { data: 'nazwisko' },
        { data: 'pogrzeb' },
    ],
    processing: true,
    rowReorder: {
            selector: 'td:nth-child(2)'
        },
    responsive: true,
  });
  $('#btn-reload').on('click', function(){
        table.ajax.reload();
    });
    setInterval(function(){
        table.ajax.reload();
}, 60000);
});

</script>
<?php endif;
get_footer();
?>