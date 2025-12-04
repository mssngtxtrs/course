<?php
namespace Server;

class Database {
    private $credentials = [
        'hostname' => "127.0.0.1",
        'username' => "root",
        'password' => "",
        'database' => "db_course"
    ];

    private \PDO $conn;



    public function __construct() {
        try {
            $dsn = "mysql:dbname={$this->credentials['database']};host={$this->credentials['hostname']}";
            $this->conn = new \PDO(
                $dsn,
                $this->credentials['username'],
                $this->credentials['password']
            );
        } catch (\PDOException $e) {
            error_log("Error connecting to the database: " . $e->getCode());
        }
    }



    public function __unset($name) {
        unset($this->conn);
        unset($this->credentials);
    }



    public function returnQuery(string $query, string $mode = "assoc", array $params = []): bool|string|array {
        $output = false;

        try {
            $result = $this->conn->prepare($query);
            $result->execute($params);
        } catch (\PDOException $e) {
            error_log("Error executing SQL query: " . $e);
        }

        switch ($mode) {
        case "bool":
            if ($result->rowCount()) {
                $output = true;
            }
            break;
        case "single":
            $output = $result->fetchColumn();
            break;
        case "assoc":
        default:
            $output = $result->fetchAll();
            break;
        }

        return $output;
    }



    public function escape(string $data): string {
        return htmlspecialchars($data);
    }
}
?>
