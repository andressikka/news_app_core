<?php
namespace admin\DatabaseClass;
use mysqli;
use FFI\Exception;

class DatabaseClass{

    private $connection = null;

    public function __construct($dbHost, $dbUsername, $dbPassword, $dbTable)
    {
        try {
            $this->connection = new mysqli($dbHost, $dbUsername, $dbPassword, $dbTable);
            if( mysqli_connect_errno()){
                throw new Exception("Could not connect to the database");
            }
        } catch (Exception $e) {
            throw new Exception ($e->getMessage());
        }
    }

    public function insert($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $stmt->close();
            return $this->connection->insert_id;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function select($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            // $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $result = $stmt->get_result();
            $resultArray = [];
            while($resultData = $result->fetch_assoc()){
                array_push($resultArray, $resultData);
            }
            $stmt->close();
            return $resultArray;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function update($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params)->close();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function remove($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params)->close();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    private function executeStatement($query = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            if($stmt === false){
                throw new Exception("Unable to do prepared statement" . $query);
            }
            if($params){
                $tmp = Array();
                foreach ($params as $key => $value){
                    $tmp[$key] = &$params[$key];
                }
                call_user_func_array(array($stmt, 'bind_param'), $tmp);
            }
            $stmt->execute();

            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
