<?php
include_once 'includes/header.php';
require_once 'includes/User.class.php';

// If try to login if the required post data exists
$requires = array('username', 'password', 'password2', 'first_name', 'last_name', 'email');
if (!array_diff($requires, array_keys($_POST))) {
    User::login($_POST['username'], $_POST['password']);
}
?>

<div class="container">
    <div id="registerbox" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">Sign Up</div>
            </div>

            <div class="panel-body">
                <form id="login_form" class="form-horizontal" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="username" name="username" value="" placeholder="Enter a username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password2">Verify Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="Enter your password again">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your email address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your email address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email address">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary pull-right">Register</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include_once('includes/footer.html'); ?>
