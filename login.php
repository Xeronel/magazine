<?php include_once('includes/header.php'); ?>
<div class="container">
    <div id="loginbox" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">Sign In</div>
            </div>

            <div class="panel-body">
                <form id="login_form" class="form-horizontal" method="post">
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="username" value=""
                        placeholder="Enter your username">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="password"
                        placeholder="Enter your password">
                    </div>

                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <button type="submit" class="btn btn-primary pull-right">Login</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include_once('includes/footer.html'); ?>
