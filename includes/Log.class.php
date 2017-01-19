<?php
require_once 'includes/Database.class.php';
require_once 'includes/User.class.php';

class Log
{
    public $id;
    public $user_id;
    public $username;
    public $action;
    public $action_time;

    public function __construct($id, $user_id, $username, $action, $action_time)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->username = $username;
        $this->action = $action;
        $this->action_time = $action_time;
    }

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

    public static function getLog()
    {
        $db = Database::getInstance();
        $log = $db->fetchAll('SELECT access_log.*, users.username FROM access_log LEFT JOIN users ON access_log.user_id = users.id');

        $result = array();
        foreach ($log as $log_entry) {
            $result[] = self::createLog($log_entry);
        }
        return $result;
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

    private static function createLog($log_array)
    {
        return new Log(
            $log_array['id'],
            $log_array['user_id'],
            $log_array['username'],
            $log_array['action'],
            $log_array['action_time']
        );
    }
}
?>
