<?php
namespace Server;

use mysqli_sql_exception;

class Database {
    private $credentials = [
        'hostname' => "127.0.0.1",
        'username' => "root",
        'password' => "",
        'database' => "db_course"
    ];

    private \mysqli $conn;



    public function __construct() {
        try {
            $this->conn = new \mysqli(
                $this->credentials['hostname'],
                $this->credentials['username'],
                $this->credentials['password'],
                $this->credentials['database']
            );
        } catch (mysqli_sql_exception $e) {
            error_log("Error connecting to the database: " . $e->getCode());
        }
    }



    public function __unset($name) {
        $this->conn->close();
        unset($this->conn);
        unset($this->credentials);
    }



    public function returnQuery(string $query, string $mode = "assoc", array $params = []) {
        $result = $this->conn->execute_query($query, $params);
        if ($this->conn->error) {
            /* $result->free_result(); */
            error_log("Error executing SQL query: " . $this->conn->error);
            $output = false;
        } else {
            /* $output = $result->fetch_all(MYSQLI_ASSOC); */
            switch ($mode) {
            case "bool":
                if ($this->conn->affected_rows) {
                    $output = true;
                } else {
                    $output = false;
                }
                break;
            case "single":
                $output = $result->fetch_column();
                break;
            case "assoc":
            default:
                $output = $result->fetch_all(MYSQLI_ASSOC);
                break;
            }
            /* $result->free_result(); */
            return $output;
        }
    }
}
?>
