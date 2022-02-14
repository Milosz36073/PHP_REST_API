<?php
/*
file structure
config - hold our database class core connection to database using PDO
models folder has our post model and category model
api folder where we actually hit a http client
*/
class Database {
    private $host = 'localhost';
    private $db_name = 'myblog';
    private $username = 'root';
    private $password = '123456';
    private $conn;

    //db connect
    public function connect(){
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo 'Connection Error' . $e->getMessage();
        }

        return $this->conn; 
    }
}


?>