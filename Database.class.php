<?php
/**
 * Connect to the database and provide easy access to common functions
 */
class Database {
  public $db;

  // Used for singleton pattern
  private static $db_instance;

  public function __construct() {
    // Config should be a copy of config-exmaple.ini
    // all entries are assumed to exist and be correct
    $config = parse_ini_file('config.ini');
    // Create a new conncetion to the database
    $this->db = new PDO("mysql:host={$config['db_host']};" .
                         "dbname={$config['db_name']};charset=utf8mb4",
                         $config['db_user'], $config['db_pass']);
    // Throw exceptions on SQL error
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  /**
  * Get all query result rows
  *
  * @return array[]
  */
  public function fetchAll($query) {
    /** @var $query string */
    return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
  * Get single query result row
  *
  * @return array[]
  */
  public function fetch($query) {
    return $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
  }

  /**
  * Get or create the single instance of this class
  *
  * @return DB
  */
  public static function getInstance() {
    // If an instance doesn't exist create one, else return it
    if (!self::$db_instance) {
      self::$db_instance = new DB();
    }
    return self::$db_instance;
  }
}
?>
