<?php

require_once __DIR__ . '\main.php';

class ServiceLog extends SelfServiceDesk {

  public $db_dir = __DIR__ . '\\';
  public $db_file = "servicelog.db";

  private function getDatabase() {
    $db_path = $this->db_dir . $this->db_file;

    if(!file_exists($db_path)) {
      $database = new SQLite3($db_path);
      $database->exec('CREATE TABLE servicelog (time DATETIME NOT NULL, source TEXT NOT NULL, event TEXT NOT NULL)');
    } else {
      $database = new SQLite3($db_path);
    }

    return $database;
  }

  public function logEvent($event) {
    $database = $this->getDatabase();

    $stmt = $database->prepare('INSERT INTO servicelog (time, source, event) VALUES (:time, :source, :event)');

    $stmt->bindValue(':time', date("Y-m-d H:i:s"), SQLITE3_TEXT);
    $stmt->bindValue(':source', $_SERVER['SERVER_ADDR'], SQLITE3_TEXT);
    $stmt->bindValue(':event', $event, SQLITE3_TEXT);
    $stmt->execute();
    $stmt->close();

    $database->close();
  }

  public function getEvents($limit = 25, $offset = 0) {
    $database = $this->getDatabase();

    $stmt = $database->prepare('SELECT * FROM servicelog ORDER BY time DESC LIMIT :limit OFFSET :offset');
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
    $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    $results = $stmt->execute();

    $logs = [];

    while($row = $results->fetchArray())
      $logs[] = $row['time'] . "\t" . $row['source'] . "\t" . $row['event'];

    $stmt->close();

    $database->close();

    return $logs;
  }

  public function getEventCount() {
    $count = 0;

    $database = $this->getDatabase();

    $stmt = $database->prepare('SELECT * FROM servicelog');
    $results = $stmt->execute();

    while($row = $results->fetchArray())
      $count++;

    $stmt->close();

    $database->close();

    return $count;
  }

}