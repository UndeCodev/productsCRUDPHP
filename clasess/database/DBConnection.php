<?php 

    class DBConnection {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbname = 'products';
        private $conn;
    
        public function __construct() {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

            if($this->conn->connect_errno){
                die("Error de conexión" . $this->conn->connect_errno);
            }
        }
    
        public function query($sql) {
            return mysqli_query($this->conn, $sql);
        }
    
        public function close() {
            mysqli_close($this->conn);
        }
    }
  
?>