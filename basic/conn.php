<?php
/* $hostname = "127.0.0.1"; */
/* $username = "root"; */
/* $password = ""; */
/* $database = "db_course"; */
/**/
/* $conn = new mysqli($hostname, $username, $password, $database); */

namespace Server;

class Database {
    private $credentials = [
        'hostname' => "127.0.0.1",
        'username' => "root",
        'password' => "",
        'database' => "db_course"
    ];

    private \mysqli $conn;

    public function __construct() {
        $this->conn = new \mysqli(
            $this->credentials['hostname'],
            $this->credentials['username'],
            $this->credentials['password'],
            $this->credentials['database']
        );
    }

    public function __unset($name) {
        $this->conn->close();
        unset($this->conn);
        unset($this->credentials);
    }

    public function returnQuery($query) {
        $result = $this->conn->query($query);
        if (!$this->conn->affected_rows) {
            $result->free();
            return null;
        } else {
            $output = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            return $output;
        }
    }
}
?>
