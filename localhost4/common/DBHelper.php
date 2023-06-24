<?php

namespace common;

use Exception;
use mysqli;

class DbHelper
{
    private const dbName = "SimsonIntegralDBWithHttpRequest";
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
    }

    private function tableExists($tableName)
    {
        $query = "SHOW TABLES LIKE '$tableName'";
        $result = $this->conn->query($query);
        return $result->num_rows > 0;
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
   
}

