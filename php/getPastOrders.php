<?php
// connect to session
session_start();


//Include libraries
require __DIR__ . './vendor/autoload.php';

if(array_key_exists("loggedUser", $_SESSION) ){
    $currentUser = $_SESSION["loggedUser"];
}
else{
    echo '';
    return false;
}

// connect to default local client port
$mongoClient = new MongoDB\Client(
    'mongodb://localhost:27017'
);


// select database and collection
$db = $mongoClient->ecommerce;
$ordersCollection = $db->orders;

$orderCriteria = ["Username" => $currentUser];

// sort all orders in descending order
$orderOptions = ['sort' => ['_id' => -1]];

$allPastOrders = $ordersCollection->find($orderCriteria, $orderOptions); 

foreach ($allPastOrders as $this_order){
    echo '<tr>
    <th scope="row">'.$this_order["Date Created"].'</th>
    <td>'.$this_order["Order ID"].'</td>
    <td class="past-items">';
    orderDetails($this_order["Order ID"]);
    echo '</td>
    <td class="past-total">MUR'.$this_order["Total Price"].'</td>
    </tr>';

}

function orderDetails($orderID){

    $mongoClient = new MongoDB\Client(
        'mongodb://localhost:27017'
    );
    $orderDetails = 'order-details';
    $db = $mongoClient->ecommerce; 
    $orderDetailsCollection = $db->$orderDetails;

    $orderDetailsCriteria =  ["Order ID" => $orderID];
    $purchases = $orderDetailsCollection->find($orderDetailsCriteria); 

    foreach ($purchases as $item){

        $itemName = getItemName($item["Product ID"]);
        echo ''.$item["Quantity"].' X '.$itemName.' @ MUR '.$item["Unit Price"].'<br/>';
    }

}

function getItemName($id){
    $mongoClient = new MongoDB\Client(
        'mongodb://localhost:27017'
    );
    $db = $mongoClient->ecommerce;
    $productsCollection = $db->products;
    $product = $productsCollection->findOne(["Product ID" => $id]);
    return $product["Product Name"];
}
