<?php
require_once 'includes/Database.class.php';
require_once 'includes/User.class.php';

class Log
{
    public static function pageView()
    {
        $user = User::getCurrentUser();
        $db = Database::getInstance();
        $db->execute(
            "INSERT INTO web_log (page, user_id) VALUES (?, ?)",
            array($_SERVER['REQUEST_URI'], $user->id)
        );
    }

    public static function login()
    {
        self::logAccess('LOGIN');
    }

    public static function logout()
    {
        self::logAccess('LOGOUT');
    }

    public static function register($username)
    {
        self::logAccess("REGISTER: {$username}");
    }

    private static function logAccess($action)
    {
        $db = Database::getInstance();
        $user = User::getCurrentUser();
        $db->execute(
            "INSERT INTO access_log (user_id, action) VALUES (?, ?)",
            array($user->id, strtoupper($action))
        );
    }
}
?>
