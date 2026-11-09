<?php

// technically does not work - tried functionality


// connect to session
session_start();

// include library for mongodb/php driver
require __DIR__ . './vendor/autoload.php';


// connect to default local client port
$mongoClient = new MongoDB\Client(
    'mongodb://localhost:27017'
);

// check that there is a user logged in the session
// if not, return nothing to JS and end PHP
if(array_key_exists("loggedUser", $_SESSION) ){
    $currentUser = $_SESSION["loggedUser"];
}
else{
    echo '';
    return false;
}

// select ecommerce database
$db = $mongoClient->ecommerce;
//Select orders collection
$ordersCollection = $db->orders;

$orderID = ($_POST['orderID']);
$date = ($_POST['date']);
$total = ($_POST['total']);
$quantity= ($_POST['quantity']);


$customerCollection->insertOne([
    "Order ID" => $orderID,  
    "Username" =>  $currentUser,
    "Date Created" => $date ,
    "Total Price" => $total,
    "Quantity" => $quantity
])
