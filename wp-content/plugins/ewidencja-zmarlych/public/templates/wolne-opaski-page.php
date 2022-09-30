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

if(is_user_logged_in()) : ?>
<div class="esez-container">
    <div class="row">
        <div id="esez">
            <h2 class="esez-title"><?php echo $first_name; ?></h2>
            <div class="table-navigation-container">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="/konto" class="nav-link">
                            W trakcie
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/konto/wolne" class="nav-link active">Wolne</a>
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
                    <span class="header-table-title">Wolne opaski</span>
                    <a type="button" id="btn-reload"><i class="fa-solid fa-arrows-rotate"></i></a>
                </div>
                <div class="card-body table-responsive-xxl">
                    <table class="table align-middle hover order-column" id="datatablesWTrakcie">
                    <thead>
                            <tr>
                                <th class="text-nowrap">Nr</th>
                                <th class="text-nowrap">Aktywacja</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-nowrap">Nr</th>
                                <th class="text-nowrap">Aktywacja</th>
                            </tr>
                        </tfoot>
                        <tbody>
                    </tbody>
                    </table>
                    </div>
                    </div>
                    </div>
<script>
jQuery(document).ready(function ($) {

    var table = $('#datatablesWTrakcie').DataTable({
        ajax: {
            url: datatablesajax.url + '?action=getpostsfordatatableswolne'
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
        columns: [{
                data: 'nr'
            },
            {
                data: 'aktywacja'
            },
        ],
        processing: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "columnDefs": [{
                className: "text-nowrap",
                targets: "_all"
            },
            {
                "targets": [1],
                "searchable": false,
                "orderable": false,
                "visible": true
            }
        ]
    });
    $('#btn-reload').on('click', function () {
        table.ajax.reload();
    });
    setInterval(function () {
        table.ajax.reload();
    }, 60000);
});
</script>
<?php endif; ?>
<?php get_footer(); ?>