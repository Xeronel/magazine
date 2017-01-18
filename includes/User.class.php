<?php
require_once 'includes/Database.class.php';

/**
 * Provide user functions
 */
class User
{
    public static function register($username, $password, $password2, $firstname, $lastname, $email)
    {
        // Enforce username max length in case mysql strict mode is not enabled
        if (strlen($username) > 30) {
            return "Username too long. Max length: 30 characters";
        }

        // Make sure passwords match
        if ($password != password2) {
            return "Passwords do not match!";
        }

        $pwhash = password_hash($password, PASSWORD_DEFAULT);

        // Try to add the user, return an error message on failure
        try {
            $db = Database::getInstance();
            $db->execute(
                "INSERT INTO users (username, first_name, last_name, email, pwhash)" .
                "VALUES (?, ?, ?, ?, ?)",
                array($username, $firstname, $lastname, $email, $pwhash)
            );
            self::login($username, $password);
        } catch (PDOException $e) {
            // Unique key violation
            if ($e->getCode() == Database::ERR_DUPLICATE_KEY) {
                return "User already exists!";
            }
            return "Error {$e->getCode()} occurred";
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
