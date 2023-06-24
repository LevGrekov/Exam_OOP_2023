<?php

class DbHelper
{
    private const dbName = "MyDataBaseForExam";
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


    public function getIntegralsByDateTimeRange($startDateTime, $endDateTime): array {
        $sql = "SELECT * FROM IntegralGraph  WHERE dateOfCreation BETWEEN ? AND ?";
        
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
}
