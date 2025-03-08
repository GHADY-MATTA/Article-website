<?php
class Database
{
    private $host = "localhost";   // MySQL server
    private $dbname = "usersignupwallet"; // Your database name
    private $username = "root";    // Database username
    private $password = "";        // Database password
    private $connection;           // PDO connection variable

    // Constructor to establish the connection
    public function __construct()
    {
        try {
            // PDO connection to the MySQL database
            $this->connection = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                $this->username,
                $this->password
            );
            // Set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // If connection fails, catch error and display it
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Method to get the PDO connection
    public function getConnection()
    {
        return $this->connection;
    }
}
