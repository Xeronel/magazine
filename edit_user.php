<?php
include_once 'includes/header.php';
require_once 'includes/User.class.php';

// If the user isn't an admin send them back to the home page
if (!User::inGroup('admin')) {
    header('Location: /');
    exit();
}

// If a user id isn't specified go to the userlist
if (!isset($_GET['uid'])) {
    header('Location: /userlist.php');
    exit();
}

$user = User::find($_GET['uid']);

if (isset($_POST['delete'])) {
    $result = User::delete($user->id);
    if ($result) {
        header('Location: /userlist.php');
    }
}
?>

<div class="container">
    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">Edit User - <?php echo $user->firstname . ' ' . $user->lastname; ?></div>
            </div>

            <div class="panel-body">
                <form id="edit_user_form" class="form-horizontal" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>" placeholder="Enter a username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user->firstname; ?>" placeholder="Enter a first name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user->lastname; ?>" placeholder="Enter a last name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $user->email; ?>" placeholder="Enter an email address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter a new password">
                        </div>
                    </div>

                    <div class="controls pull-right">
                        <button type="submit" name="submit" id="submit" value="submit" class="btn btn-primary pull-right">Submit</button>
                        <button type="submit" name="delete" id="delete" value="delete" class="btn btn-danger">Delete User</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<?php
include_once 'includes/footer.html';
?>
