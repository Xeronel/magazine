<?php
include_once 'includes/header.php';
require_once 'includes/User.class.php';
require_once 'includes/Stats.class.php';

// If the user isn't an admin send them back to the home page
if (!User::inGroup('admin')) {
    header('Location: /');
    exit();
}
?>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
        <div class="panel-heading">Stats Report</div>
        <div class="panel-body">
            <h3>Site Stats</h3>
            <div class="input-group">
                <label>Page Views:</label> <?php echo Stats::totalPageViews(); ?>
            </div>

            <div class="input-group">
                <label>Most Popular:</label> <?php echo Stats::totalUsers(); ?>
            </div>

            <h3>Users Stats</h3>
            <div class="input-group">
                <label>Total Logins:</label> <?php echo Stats::totalLogins(); ?>
            </div>
            <div class="input-group">
                <label>Total Admins:</label> <?php echo Stats::totalUsers(); ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.html';
?>
