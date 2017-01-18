<?php
require 'includes/Database.class.php';

/**
 * Provide user functions
 */
class User
{
    private static $db;

    public function __construct()
    {
        $self->db = Database::getInstance();
    }

    public function register($username, $password, $password2, $firstname, $lastname, $email)
    {
    }

    public static function login($username, $password)
    {
        $user = $this->db->fetch('SELECT * FROM users  WHERE username = ?', array($username));
        if (password_verify($password, $user['pwhash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            header("Location: /");
            exit();
        }
    }

    public static function logout()
    {
        // Clear session variables
        $_SESSION = array();

        // Remove session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Redirect to home
        header("Location: /");
        exit();
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
