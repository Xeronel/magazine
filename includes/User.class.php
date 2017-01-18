<?php
require 'includes/Database.class.php';

/**
 * Provide user functions
 */
class User
{
    public static function login($username, $password)
    {
        $db = Database::getInstance();
        $user = $db->fetch('SELECT * FROM users  WHERE username = ?', array($username));
        if (password_verify($password, $user['pwhash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            header("Location: /");
            exit();
        }
    }

    public static function is_authenticated()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }
}
?>
