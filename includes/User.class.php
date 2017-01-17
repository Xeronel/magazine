<?php
require_once('Database.class.php');

/**
 * Provide user functions
 */
class User
{
    private static $db = Database::getInstance();

    public static function login()
    {
        $requires = array('username', 'password');
        if (!array_diff($requires, array_keys($_POST))) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            self::db->fetch('SELECT id FROM user WHERE username = ?')
            $_SESSION[]
        } else {
            die("Missing required fields");
        }
    }
}
