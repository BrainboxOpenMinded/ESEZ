<?php 
global $current_user;
wp_get_current_user();
$items = array();

foreach( get_multiple_authors() as $coauthor ) {
     $items[] = $coauthor->ID;
}
?>
<div class="esez-container">
    <h1 class="entry-title">eSEZ - Elektroniczny System Ewidencji Zmarłych</h1>
</div>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Zalogowani</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
<p><?php echo do_shortcode('[lastlogin user_id=13,1]'); ?></p>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Warning Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Success Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Danger Card</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-pie me-1"></i>
                Przykład 1
            </div>
            <div class="card-body">
                <div class="chart-container-one">
                    <?php include '/home/esez/domains/dev.esez.pl/public_html/wp-content/plugins/ewidencja-zmarlych/public/partials/chart-one.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-1"></i>Przykład 2
            </div>
            <div class="card-body">
                <div class="chart-container-two">
                    <?php include '/home/esez/domains/dev.esez.pl/public_html/wp-content/plugins/ewidencja-zmarlych/public/partials/chart-two.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/wp-content/plugins/ewidencja-zmarlych/public/js/chart-one.js"></script>
<script src="/wp-content/plugins/ewidencja-zmarlych/public/js/chart-two.js"></script>