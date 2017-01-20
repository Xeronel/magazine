<?php
session_start();
require_once 'includes/User.class.php';
require_once 'includes/Log.class.php';

Log::pageView();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Some Magazine!</title>
</head>

<body>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Some Magazine!</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li id="home">
                        <a href="/">Home</a>
                    </li>
                    <li id="contact">
                        <a href="/contact.php">Contact Us</a>
                    </li>
                    <?php if(User::inGroup('admin')) {
                        // Statistics link
                        echo '<li id="stats">';
                        echo '<a href="/stats.php">Statistics</a>';
                        echo '</li>';

                        // User list link
                        echo '<li id="user_list">';
                        echo '<a href="/userlist.php">User List</a>';
                        echo '</li>';

                        // Access log link
                        echo '<li id="access_log">';
                        echo '<a href="/accesslog.php">Access Log</a>';
                        echo '</li>';

                        // Web log link
                        echo '<li id="web_log">';
                        echo '<a href="/weblog.php">Web Log</a>';
                        echo '</li>';
                    } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if (User::isAuthenticated()) {
                        echo '<li id="logout"><a href="/logout.php">Logout</a></li>';
                    } else {
                        echo '<li id="login"><a href="/login.php">Login</a></li>';
                    }
                    ?>
                </ul>
            </div>

        </div>
    </nav>
