<?php
include_once 'includes/header.php';
require_once 'includes/User.class.php';

// If try to login if the required post data exists
$requires = array('username', 'password');
if (!array_diff($requires, array_keys($_POST))) {
    User::login($_POST['username'], $_POST['password']);
}
?>

<div class="container">
    <div id="loginbox" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">Sign In</div>
            </div>

            <div class="panel-body">
                <form id="login_form" class="form-horizontal" method="post">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="username" value=""
                        placeholder="Enter your username">
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="password"
                        placeholder="Enter your password">
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 controls">
                            <button type="submit" class="btn btn-primary pull-right">Login</button>
                        </div>
                    </div>
                </form>
                <span id="register" class="pull-right">
                    <a href="/register.php">Don't have an account?</a>
                </span>
            </div>

        </div>
    </div>
</div>

<?php include_once('includes/footer.html'); ?>
