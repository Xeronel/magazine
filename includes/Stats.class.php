<?php
require_once 'includes/Database.class.php';
require_once 'includes/WebPage.class.php';

/**
* Statistics functions
*/
class Stats
{
    public static function pageViews()
    {
        $pageviews = self::fetchAll(
            "SELECT CASE
            WHEN page LIKE '%\?%' THEN LEFT(page, LOCATE('?', page)-1)
            ELSE page
            END AS GroupPage, COUNT(page) AS total
            FROM web_log
            GROUP BY GroupPage
            ORDER BY total desc"
        );

        $result = array();
        foreach ($pageviews as $page) {
            $result[] = new WebPage($page['GroupPage'], $page['total']);
        }
        return $result;
    }

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

    public static function mostPopularPage()
    {
        $query = "SELECT page, total FROM
        (SELECT id, page, COUNT(page) AS total
        FROM web_log
        GROUP BY page
        ORDER BY total desc) a
        LIMIT 1";

        return self::fetch($query);
    }

    public static function totalAdmins()
    {
        return self::fetch("SELECT COUNT(*) FROM permissions WHERE group_name = 'admin'")['COUNT(*)'];
    }

    private static function fetch($query)
    {
        $db = Database::getInstance();
        return $db->fetch($query);
    }

    private static function fetchAll($query)
    {
        $db = Database::getInstance();
        return $db->fetchAll($query);
    }
}

?>
