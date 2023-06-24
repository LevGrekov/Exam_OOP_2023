<?php

namespace common;

use Exception;
use mysqli;

class DbHelper
{
    private const dbName = "matrix";
    private static ?DbHelper $instance = null;
    private $conn;

    public static function getInstance($host = null, $port = null, $user = null, $pass = null): DbHelper
    {
        if (self::$instance === null) self::$instance = new DbHelper($host, $port, $user, $pass);
        return self::$instance;
    }

    private function __construct($host, $port, $user, $pass)
    {
        $this->conn = new mysqli($host, $user, $pass, '', $port);

        if ($this->conn->connect_error) {
            die("Ошибка подключения: " . $this->conn->connect_error);
        }

        // Проверка наличия базы данных
        if (!$this->databaseExists(self::dbName)) {
            $this->createDatabase();
        }
        

        $this->conn->select_db(self::dbName);

        // Проверка наличия таблицы "system"
        if (!$this->tableExists('Users')) {
            $this->createUserTable();
        }

        // Проверка наличия таблицы "system"
        if (!$this->tableExists('system')) {
            $this->createSystemTable();
        }

        // Проверка наличия таблицы "coefficients"
        if (!$this->tableExists('coefficients')) {
            $this->createCoefficientsTable();
        }
    }

    private function tableExists($tableName)
    {
        $query = "SHOW TABLES LIKE '$tableName'";
        $result = $this->conn->query($query);
        return $result->num_rows > 0;
    }

    private function databaseExists($database)
    {
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";
        $result = $this->conn->query($query);
        return $result->num_rows > 0;
    }

    private function createDatabase()
    {
        $query = "CREATE DATABASE " . self::dbName;
        if (!$this->conn->query($query)) {
            die("Ошибка создания базы данных: " . $this->conn->error);
        }
    }

    private function createSystemTable()
    {
        $query = "CREATE TABLE `system` (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            varsAmount INT UNSIGNED NOT NULL,
            Answer VARCHAR(255) DEFAULT NULL
        )";

        if (!$this->conn->query($query)) {
            die("Ошибка при создании таблицы 'system': " . $this->conn->error);
        }
    }

    private function createCoefficientsTable()
    {
        $query = "CREATE TABLE coefficients (
            system_id INT(11) UNSIGNED,
            row_id INT(11) UNSIGNED NOT NULL,
            col_id INT(11) UNSIGNED,
            value DECIMAL(10,2),
            PRIMARY KEY (system_id, row_id, col_id),
            FOREIGN KEY (system_id) REFERENCES `system`(id)
        )";

        if (!$this->conn->query($query)) {
            die("Ошибка при создании таблицы 'coefficients': " . $this->conn->error);
        }
    }


    private function createUserTable()
    {   
        $query = "CREATE TABLE IF NOT EXISTS Users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            login VARCHAR(255) UNIQUE,
            password VARCHAR(255)
        );";

        if (!$this->conn->query($query)) {
            die("Ошибка при создании таблицы 'Users': " . $this->conn->error);
        }
    }


    public function saveUser(string $login, string $password): bool
    {
        $sql = "INSERT INTO `users` (login, password) VALUES(?, ?)";
        try {
            $this->conn->begin_transaction();
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $login, $password,);
            if (!$stmt->execute()) throw new Exception("Ошибка добавления пользователя");
            $this->conn->commit();
            return true;
        } catch (\Throwable $ex){
            $this->conn->rollback();
            return false;
        }
    }

    public function getUserPassword(string $user): ?string{
        $sql = "SELECT password FROM users WHERE login = ?";
        $this->conn->begin_transaction();
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $this->conn->commit();
        return ($row === null) ? $row : $row['password'];
    }

    public function addCoeff( $system_id,  $row_id,  $col_id, $value): bool
    {
        $sql = "INSERT INTO `coefficients` (system_id, row_id, col_id, value) VALUES(?, ?, ?, ?)";
        try {
            $this->conn->begin_transaction();
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiid", $system_id, $row_id, $col_id, $value);
            if (!$stmt->execute()) {
                throw new Exception("Ошибка добавления коэффициента:".$stmt->error);
            }
            $this->conn->commit();
            return true;
        } catch (\Throwable $ex) {
            $this->conn->rollback();
            echo $ex;
            return false;
        }
    }

    public function getAllSystems()
    {
        $sql = "SELECT * FROM `system`";
        try {
            $result = $this->conn->query($sql);
            $systems = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $systems[] = $row;
                }
            }
            return $systems;
        } catch (\Throwable $ex) {
            echo $ex;
            return null;
        }
    }

    public function getCoefficient($system_id, $row_id, $col_id)
    {
        $sql = "SELECT value FROM `coefficients` WHERE system_id = ? AND row_id = ? AND col_id = ?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $system_id, $row_id, $col_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['value'];
            } else {
                return null; 
            }
        } catch (\Throwable $ex) {
            echo $ex;
            return null;
        }
    }

    public function CreateNewSystem($amount): int
    {
        $sql = "INSERT INTO `system` (varsAmount) VALUES (?)";

        try {
            $this->conn->begin_transaction();
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $amount);
            if (!$stmt->execute()) {
                throw new Exception("Ошибка Создания новой системы");
            }
            $systemId = $this->conn->insert_id;
            $this->conn->commit();
            return $systemId;
        } catch (\Throwable $ex) {
            $this->conn->rollback();
            echo $ex;
            return 0;
        }
    }
   
}

