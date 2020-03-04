<?php 

include('db/connection.php');
include("Products.php");

class App {
    private $products;
    private $conn;

    function __construct($conn) {
        $this->conn = $conn;
        $this->products = new Products($conn); 
    }

    function getAllProducts() {
        $productArray = $this->products->getAll();
        if (is_array($productArray)) {
           return $productArray;
        } else {
            return [];
        }
    }

    function getProductsCount() {
        return $this->products->getAllProductsCount();
    }

    function getAllColors() {
        $sql = "SELECT * FROM colors";
        $result = $this->conn->query($sql);
        $data = array();

        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()){
                array_push($data, $row);
            }

            return $data;

        } else {
            return [];
        }
    }

    function getAllSizes() {
        $sql = "SELECT * FROM sizes";
        $result = $this->conn->query($sql);
        $data = array();
        
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()){
                array_push($data, $row);
            }

            return $data;

        } else {
            return [];
        }
    }
}

// start the app
$app = new App($conn);

// get base datas
$products = $app->getAllProducts();
$allProductsCount = $app->getProductsCount();
$colors = $app->getAllColors();
$sizes = $app->getAllSizes();
