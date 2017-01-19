<?php
require_once 'includes/Database.class.php';

/**
* Statistics functions
*/
class Stats
{
    public static function totalPageViews()
    {
        return self::fetch("SELECT COUNT(*) AS total_views FROM web_log")['total_views'];
    }

    public static function totalUsers()
    {
        return self::fetch("SELECT COUNT(*) AS total_users FROM users")['total_users'];
    }

    public static function totalLogins()
    {
        $query = "SELECT COUNT(*) AS total_logins FROM access_log WHERE action = 'LOGIN'";
        return self::fetch($query)['total_logins'];
    }

    private static function fetch($query)
    {
        $db = Database::getInstance();
        return $db->fetch($query);
    }
}

?>
