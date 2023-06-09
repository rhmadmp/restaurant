<?php
class Config {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "restaurant";
    
    protected $connection;
    
    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->connection->connect_error) {
            die("Koneksi database gagal: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
    
    public function checkLoginStatus() {
        session_start();
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: login.php');
            exit;
        }
    }
    
}
?>
