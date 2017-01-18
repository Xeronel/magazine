<?php
require '/includes/Database.class.php';

/**
 * Provide user functions
 */
class User
{
    private static $db = Database::getInstance();

    public static function login($username, $password)
    {
        $user = $this->db->fetch('SELECT * FROM user WHERE username = ?', array($username))
        if (password_verify($password, $user['pwhash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username']
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            header('Location: $_SERVER[HTTP_HOST]');
            exit();
        }
    }
}
?>
