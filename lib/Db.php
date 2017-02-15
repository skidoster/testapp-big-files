<?php

namespace App;

use PDO;
use App\Interfaces\DbConnection;

class Db implements DbConnection
{
    private $connection;

    private static $instance;

    private function __construct() {
        $this->connection = new PDO('mysql:host=localhost;dbname=big_files', 'root', 'qwerty');
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone() { }

    public function getConnection() {
        return $this->connection;
    }

}