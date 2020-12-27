<?php
namespace config;

class config{

    private $host = "localhost";
    private $username="root";
    private $password="root";
    private $db = "newsapp";


    public function establishConnection(){
        $conn = new mysqli($this->host, $this->username, $this->password, $this->db);
        if($conn->connect_error){
            die ("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

}
?>