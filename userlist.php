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
            <div class="panel-heading">User List</div>
            <div class="panel-body">
                <table id="userlist">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td class="user">Username</td>
                            <td>First Name</td>
                            <td>Last Name</td>
                            <td>Email</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (User::getList() as $user) {
                            echo '<tr>';
                            echo "<td>{$user->id}</td>";
                            echo "<td>{$user->username}</td>";
                            echo "<td>{$user->firstname}</td>";
                            echo "<td>{$user->lastname}</td>";
                            echo "<td>{$user->email}</td>";
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
