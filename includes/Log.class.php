<?php
require_once 'includes/Database.class.php';
require_once 'includes/User.class.php';

class AccessLog
{
    public $id;
    public $user_id;
    public $username;
    public $action;
    public $action_time;

    public function __construct($log_array)
    {
        $this->id = $log_array['id'];
        $this->user_id = $log_array['user_id'];
        $this->username = $log_array['username'];
        $this->action = $log_array['action'];
        $this->action_time = $log_array['action_time'];
    }
}

class WebLog
{
    public $id;
    public $user_id;
    public $username;
    public $page;
    public $viewed;

    public function __construct($log_array)
    {
        $this->id = $log_array['id'];
        $this->user_id = $log_array['user_id'];
        $this->username = $log_array['username'];
        $this->page = $log_array['page'];
        $this->viewed = $log_array['viewed'];
    }
}

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

    public static function getAccessLog()
    {
        $query = 'SELECT access_log.*, users.username FROM access_log LEFT JOIN users ON access_log.user_id = users.id';
        return self::createLog($query, 'AccessLog');
    }

    public static function getWebLog()
    {
        $query = 'SELECT web_log.*, users.username FROM web_log LEFT JOIN users ON web_log.user_id = users.id';
        return self::createLog($query, 'WebLog');
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

    private static function createLog($query, $classname)
    {
        $db = Database::getInstance();
        $log = $db->fetchAll($query);

        $log_object_array = array();
        foreach ($log as $log_entry) {
            $log_object_array[] = new $classname($log_entry);
        }

        return $log_object_array;
    }
}
?>
