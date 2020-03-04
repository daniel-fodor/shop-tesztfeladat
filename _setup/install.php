<?php

include('../db/connection.php');
include('data.php');

/* Generated products into database - runned only once */

$sql = "SELECT * FROM products";
if ($conn->query($sql)->num_rows > 0) {
    echo "A mintaadatok már bekerültek az adatbázisba!";
    die;
}

$dataLength = count($products);
$isSuccess = false;

for ($i = 1; $i <= $dataLength; $i++) {
    
    $i = $i . "";
    $product = $products[$i];
    $startDate = time();
    $date = date('Y-m-d H:i:s', strtotime('+'.$i.' day', $startDate));

    $sql = "INSERT INTO products (name, price, sizes, color, isSale, salePrice, createdDate, image)
    VALUES ('".$product['name']."', '".$product['price']."', '". $product['sizes']."', '".$product['color']."', '".$product['isSale']."', '".$product['salePrice']."', '".$date."', '".$product['image']."')";

    if ($conn->query($sql) === TRUE) {
        $isSuccess = true;
    } else {
        $isSuccess = false;
       echo $conn->error;
    }
}

for ($i = 1; $i <= $dataLength; $i++) {
    
    $i = $i . "";
    $product = $products[$i];
    $startDate = time();
    $date = date('Y-m-d H:i:s', strtotime('+1'.$i.' day', $startDate));

    $sql = "INSERT INTO products (name, price, sizes, color, isSale, salePrice, createdDate, image)
    VALUES ('".$product['name']."', '".$product['price']."', '". $product['sizes']."', '".$product['color']."', '".$product['isSale']."', '".$product['salePrice']."', '".$date."', '".$product['image']."')";

    if ($conn->query($sql) === TRUE) {
        $isSuccess = true;
    } else {
        $isSuccess = false;
       echo $conn->error;
    }
}

for ($i = 1; $i <= $dataLength; $i++) {
    
    $i = $i . "";
    $product = $products[$i];
    $startDate = time();
    $date = date('Y-m-d H:i:s', strtotime('+2'.$i.' day', $startDate));

    $sql = "INSERT INTO products (name, price, sizes, color, isSale, salePrice, createdDate, image)
    VALUES ('".$product['name']."', '".$product['price']."', '". $product['sizes']."', '".$product['color']."', '".$product['isSale']."', '".$product['salePrice']."', '".$date."', '".$product['image']."')";

    if ($conn->query($sql) === TRUE) {
        $isSuccess = true;
    } else {
        $isSuccess = false;
       echo $conn->error;
    }
}

if ($isSuccess) {
    echo "A minta adatok bekerültek az adatbázisba!";       
}

include("../db/connection_close.php");

