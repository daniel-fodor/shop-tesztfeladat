<?php 

class Products {
    private $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    function getAll() {
        $sql = "SELECT * FROM products ORDER BY createdDate DESC LIMIT 8";
        $result = $this->conn->query($sql);
        $data = array();

        if ($result->num_rows > 0) {
    
            while($row =  $result->fetch_assoc()) {
                array_push($data, $row);
            }

            return $data;

        } else {
            return "0 results";
        }
    }

    function getAllProductsCount() {
        $sql = "SELECT * FROM products ORDER BY createdDate DESC";
        $result = $this->conn->query($sql);
        $data = array();

        if ($result->num_rows > 0) {
    
            while($row =  $result->fetch_assoc()) {
                array_push($data, $row);
            }

            return count($data);

        } else {
            return "0 results";
        }
    }
}