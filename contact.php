<?php
include_once 'includes/header.php';

if (isset($_POST['email']) && isset($_POST['body'])) {

}
?>

<div class="row">
    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
        <div class="panel-heading">Contact Us</div>
        <div class="panel-body">

            <form id="contact_form" class="form-horizontal" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email address">
                    </div>
                </div>
                <div class="form-group">
                    <label for="body">Ask us a question</label>
                    <textarea class="form-control" id="body" rows="6" value="" placeholder="Message"></textarea>
                </div>
                <div class="controls">
                    <button type="submit" class="btn btn-primary pull-right">Send</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include_once 'includes/footer.html'; ?>
