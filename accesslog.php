<?php
include_once 'includes/header.php';
require_once 'includes/User.class.php';

// If the user isn't an admin send them back to the home page
if (!User::inGroup('admin')) {
    header('Location: /');
    exit();
}
?>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
        <div class="panel-heading">Access Log</div>
        <div class="panel-body">
            <table id="accesslog">
                <thead>
                    <tr>
                        <td>User id</td>
                        <td class="user">Username</td>
                        <td>Action</td>
                        <td>Time</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach (Log::getLog() as $log) {
                        echo '<tr>';
                        echo "<td>{$log->user_id}</td>";
                        echo "<td>{$log->username}</td>";
                        echo "<td>{$log->action}</td>";
                        echo "<td>{$log->action_time}</td>";
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.html';
?>
