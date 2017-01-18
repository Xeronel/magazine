<?php
require_once 'includes/Database.class.php';

/**
 * Provide user functions
 */
class User
{
    public static function register($username, $password, $firstname, $lastname, $email)
    {
        $pwhash = password_hash($password, PASSWORD_DEFAULT);

        $db = Database::getInstance();
        try {
            $db->execute(
                "INSERT INTO users (username, first_name, last_name, email, pwhash)" .
                "VALUES (?, ?, ?, ?, ?)",
                array($username, $firstname, $lastname, $email, $pwhash)
            );
        } catch (PDOException $e) {
            return $e->getCode();
        }
    }

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
