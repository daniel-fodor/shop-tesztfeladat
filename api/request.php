<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('../db/connection.php');

$db = $conn;

if (!empty($_POST)) {

    $colorVal = $_POST['colorVal'];
    $sizeVal = $_POST['sizeVal'];
    $orderVal = $_POST['orderVal'];
    $page = $_POST['page'];

    echo getFilterItems($colorVal, $sizeVal, $orderVal, $page, $db);
    
    $db->close();

} else {
    echo "Hiba, nem küldött adatot!";
}

function getFilterItems($colorVal, $sizeVal, $orderVal, $page, $conn) {
    $colorVal = trim($colorVal . "");
    $sizeVal = trim($sizeVal . "");
    $sql = null;

    if ($page !== null) {
        $recordsPerPage = 8;
        $offset = ($page - 1) * $recordsPerPage;
        $limitSql = "LIMIT $offset, $recordsPerPage";
    } else {
        $limitSql = "LIMIT 8";
    }

    if ($orderVal === "1") {
        $orderSql = "ORDER BY createdDate DESC";
    } else if($orderVal === "2") {
        $orderSql = "ORDER BY createdDate ASC";
    } else if($orderVal === "3") {
        $orderSql = "ORDER BY price DESC";
    } else if($orderVal === "4") {
        $orderSql = "ORDER BY price ASC";
    }

    $sizeSQL = "sizes LIKE '%".$sizeVal."%'";
    $colorSQL = "color = '".$colorVal."'";

    if ($colorVal !=="all" && $sizeVal !== "all") {
        $sql = "SELECT * FROM products WHERE ".$sizeSQL." and ".$colorSQL." ".$orderSql." ".$limitSql."";
    }

    if ($colorVal !== "all" && $sizeVal == "all") {
        $sql = "SELECT * FROM products WHERE ".$colorSQL." ".$orderSql." ".$limitSql."";
    }

    if ($colorVal == "all" && $sizeVal !== "all") {
        $sql = "SELECT * FROM products WHERE ".$sizeSQL." ".$orderSql." ".$limitSql."";
    }

    if ($colorVal == "all" && $sizeVal == "all") {
        $sql = "SELECT * FROM products ".$orderSql." ".$limitSql."";
    }

    $total = productsNumbers($colorVal, $sizeVal, $orderVal, $conn);

    return generateDatasReturn($conn, $sql, $total);
}

function productsNumbers($colorVal, $sizeVal, $orderVal, $conn) {
    if ($orderVal === "1") {
        $orderSql = "ORDER BY createdDate DESC";
    } else if($orderVal === "2") {
        $orderSql = "ORDER BY createdDate ASC";
    } else if($orderVal === "3") {
        $orderSql = "ORDER BY price DESC";
    } else if($orderVal === "4") {
        $orderSql = "ORDER BY price ASC";
    }

    $sizeSQL = "sizes LIKE '%".$sizeVal."%'";
    $colorSQL = "color = '".$colorVal."'";

    if ($colorVal !=="all" && $sizeVal !== "all") {
        $sql = "SELECT * FROM products WHERE ".$sizeSQL." and ".$colorSQL." ".$orderSql."";
    }

    if ($colorVal !== "all" && $sizeVal == "all") {
        $sql = "SELECT * FROM products WHERE ".$colorSQL." ".$orderSql."";
    }

    if ($colorVal == "all" && $sizeVal !== "all") {
        $sql = "SELECT * FROM products WHERE ".$sizeSQL." ".$orderSql."";
    }

    if ($colorVal == "all" && $sizeVal == "all") {
        $sql = "SELECT * FROM products ".$orderSql."";
    }

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return $result->num_rows;
    } else {
        return 0;
    }
}
        
function generateDatasReturn($conn, $sql, $total) {
    $result = $conn->query($sql);
    $data = "";

    if ($result->num_rows > 0) {

        while($row =  $result->fetch_assoc()) {
            $isSale = $row['isSale'] == 1 ? " isSale" : "";

            $data .= '<div class="products__item">'.
                  '<div class="item-img">' .
                    '<img src="img/'.$row['image'].'" alt="product name">' .
            '</div>' .
            '<div class="item-data">' .
              '<h2 class="item-name">'.$row['name'].'</h2>' .
              '<div class="item-price">' .
             ' <span class="normal-price '. $isSale .'">'.number_format($row['price'], 0, '', ' ') .' Ft</span>';
                if($row['isSale'] == 1) {
                  $data .= '<span class="sale-price">'.number_format($row['price'], 0, '', ' ').' Ft</span>';
                }

              $data .= '</div>' .
             '</div>' .
          '</div>';
        }

        $obj = array(
            "data" => $data,
            "total" => $total
        );

        return json_encode($obj);

    } else {
        return "0 results";
    }
}