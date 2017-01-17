<?php
class DB {
  private $config;
  public $db;

  public function __construct() {
    $this->config = parse_ini_file('config.ini');
    $this->db = new PDO("mysql:host={$this->config['db_host']};" .
                         "dbname={$this->config['db_name']};charset=utf8mb4",
                         $this->config['db_user'], $this->config['db_pass']);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function fetchAll($query) {
    return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetch($query) {
    return $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
  }
}

$db = new DB();
?>
