<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private $connection;
    private static $instance = null;

    public function __construct(array $config)
    {
        if (self::$instance === null) {
            self::$instance = $this;
        }

        try {
            $this->connection = new PDO($config['dsn'], $config['username'], $config['password']);
            $this->connection->exec($this->applicationsTable());
            $this->connection->prepare($this->dealsTable())->execute(['status' => 'ask']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance($config)
    {
        return self::$instance ?? new Database($config);
    }

    public function connection()
    {
        return $this->connection;
    }

    private function applicationsTable()
    {
        return 'CREATE TABLE applications(
	    id INT(11) AUTO_INCREMENT PRIMARY KEY,
	    email VARCHAR (255) NOT NULL,
	    sum INT(11) NOT NULL)';
    }

    private function dealsTable()
    {
        return 'CREATE TABLE deals(
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        application_id INT(11) NOT NULL,
        recipient VARCHAR(255) NOT NULL,
        status VARCHAR(255) DEFAULT :status,
        FOREIGN KEY (application_id)
        REFERENCES applications(id)
        ON DELETE CASCADE)';
    }
}