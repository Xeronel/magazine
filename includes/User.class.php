<?php
require_once 'includes/Database.class.php';

/**
* Provide user functions
*/
class User
{
    public $id;
    public $username;
    public $firstname;
    public $lastname;
    public $email;

    public function __construct($id, $username, $firstname, $lastname, $email)
    {
        $this->id = $id;
        $this->username = strtolower($username);
        $this->firstname = ucfirst(strtolower($firstname));
        $this->lastname = ucfirst(strtolower($lastname));
        $this->email = strtolower($email);
    }

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
            // Normalize inputs
            $username = strtolower($username);
            $firstname = strtolower($firstname);
            $lastname = strtolower($lastname);
            $email = strtolower($email);

            // Add user to database
            $db = Database::getInstance();
            $db->execute(
                "INSERT INTO users (username, first_name, last_name, email, pwhash)" .
                "VALUES (?, ?, ?, ?, ?)",
                array($username, $firstname, $lastname, $email, $pwhash)
            );

            // Login after successful registration
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
        // Usernames are stored in lowercase
        $username = strtolower($username);

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
            $params["secure"], $params["httponly"]);
        }

        // Destroy the session
        session_destroy();

        // Redirect to home
        header("Location: /");
        exit();
    }

    public static function isAuthenticated()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public static function inGroup($group, $user_id = NULL)
    {
        // Groups are stored in lowercase
        $group = strtolower($group);

        // If the user isn't authenticated and a specific user_id wasn't requested
        // return false because the current user is anonymous
        if (!self::isAuthenticated() && is_null($user_id)) {
            return false;
        }

        // If a user id was not passed get it from the current session
        if (is_null($user_id)) {
            $user_id = $_SESSION['user_id'];
        }

        // Check if user_id is in the group
        $db = Database::getInstance();
        $result = $db->fetch(
            "SELECT * FROM permissions WHERE group_name = ? AND user_id = ?",
            array($group, $user_id)
        );

        // If a result is returned the user is in the group
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function userList()
    {
        $db = Database::getInstance();
        $users = $db->fetchAll("SELECT * FROM users");
        $result = array();
        foreach ($users as $user) {
            $result[] = new User(
                $user['id'],
                $user['username'],
                $user['first_name'],
                $user['last_name'],
                $user['email']
            );
        }
        return $result;
    }
}
?>
