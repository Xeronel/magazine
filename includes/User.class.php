<?php
require_once 'includes/Database.class.php';
require_once 'includes/Log.class.php';

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

    private const ANONYMOUS_ID = 2;

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
        if ($password != $password2) {
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
            Log::register($username);
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
            Log::login();
            header("Location: /");
            exit();
        }
    }

    public static function logout()
    {
        session_start();
        Log::logout();

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

    public static function getList()
    {
        $db = Database::getInstance();
        $users = $db->fetchAll("SELECT * FROM users");
        $result = array();
        foreach ($users as $user) {
            $result[] = self::createUser($user);
        }
        return $result;
    }

    public static function find($user_id)
    {
        $db = Database::getInstance();
        $user = $db->fetch('SELECT * FROM users WHERE id = ?', array($user_id));
        if ($user) {
            $user = self::createUser($user);
        }
        return $user;
    }

    public static function delete($user_id)
    {
        // Don't allow the user to delete themself
        if (self::isAuthenticated() && $_SESSION['user_id'] == $user_id) {
            return false;
        }

        // Don't allow the anonymous user to be deleted
        if ($user_id == self::ANONYMOUS_ID) {
            return false;
        }

        $db = Database::getInstance();
        $result = $db->execute('DELETE FROM users WHERE id = ?', array($user_id));
        return $result;
    }

    public static function update($user_id, $username, $firstname, $lastname, $email, $password = NULL)
    {
        $db = Database::getInstance();

        // Do not allow the anonymous user to be edited
        if ($user_id == self::ANONYMOUS_ID) {
            return false;
        }

        // Don't use is_null() because if a post request is sent password may be passed as an empty string
        if ($password == NULL) {
            $query = "UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ? WHERE id = ?";
            $params = array($username, $firstname, $lastname, $email, $user_id);
        } else {
            $pwhash = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ?, pwhash = ? WHERE id = ?";
            $params = array($username, $firstname, $lastname, $email, $pwhash, $user_id);
        }

        return $db->execute($query, $params);
    }

    public static function getCurrentUser()
    {
        if (self::isAuthenticated()) {
            return self::find($_SESSION['user_id']);
        } else {
            return self::find(self::ANONYMOUS_ID);
        }
    }

    private static function createUser($user_array) {
        return new User(
            $user_array['id'],
            $user_array['username'],
            $user_array['first_name'],
            $user_array['last_name'],
            $user_array['email']
        );
    }
}
?>
