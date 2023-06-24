<?php

class DbHelper
{
    private const dbName = "IntegralExam";
    private static ?DbHelper $instance = null;
    private $conn;


    public static function getInstance($host = null, $port = null, $user = null, $pass = null): DbHelper
    {
        if (self::$instance === null) self::$instance = new DbHelper($host, $port, $user, $pass);
        return self::$instance;
    }

    private function __construct(
        $host, $port, $user, $pass
    ){
        $this->conn = new mysqli();
        $this->conn->connect(
            hostname: $host,
            username: $user,
            password: $pass,
            database: self::dbName,
            port: $port
        );
    }


    public function getAllIntegrals(): array {
        $sql = "SELECT * FROM integral";
        $this->conn->begin_transaction();
        $result = $this->conn->query($sql);
        $integrals = $result->fetch_all(MYSQLI_ASSOC);
        $this->conn->commit();
        return $integrals;
    }

    public function getIntegralsByDateTimeRange($startDateTime, $endDateTime): array {
        $sql = "SELECT * FROM integral WHERE creation_date BETWEEN ? AND ?";
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $startDateTime, $endDateTime);
            $stmt->execute();
            $result = $stmt->get_result();
            $integrals = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $integrals;
        } catch (\Throwable $ex) {
            echo "Ошибка при выполнении запроса: " . $ex->getMessage();
            return [];
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

