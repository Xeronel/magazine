<?php
include_once 'includes/header.php';
require_once 'includes/User.class.php';

// If the user isn't an admin send them back to the home page
if (!User::inGroup('admin')) {
    header('Location: /');
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                        foreach (Log::getAccessLog() as $log) {
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
</div>

<?php
include_once 'includes/footer.html';
?>
