<?php
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

// Username must match current user
$orderCriteria = ["Username" => $currentUser];
// get the (one) latest order made by the user by sorting id from highest
$orderOptions = ['sort' => ['_id' => -1], 'limit' => 1];

$pastOrder = $ordersCollection->find($orderCriteria, $orderOptions); 

foreach ($pastOrder as $this_order){
    $pastOrderID = $this_order["Order ID"];
}

// Select a orders details collection
$db = $mongoClient->ecommerce;
// collection has a hyphen so make it into string
$orderDetails = 'order-details';
$orderDetailsCollection = $db->$orderDetails;

// filter order-details collection, only get products bought with order
$orderDetailsCriteria =  ["Order ID" => $pastOrderID];
$purchases = $orderDetailsCollection->find($orderDetailsCriteria); 

// make arrays for all products and category 
$purchasesCategoryArray = [];
$purchasesProductArray = [];

// push data into array
foreach ($purchases as $this_purchase){
    if ((array_key_exists($this_purchase["Category"], $purchasesCategoryArray))==false){
        array_push($purchasesCategoryArray, $this_purchase["Category"]);
    };
    array_push($purchasesProductArray, $this_purchase["Product ID"]);
}


// //Select a collection 
$db = $mongoClient->ecommerce;
$productsCollection = $db->products;

// //find all products document 
$products = $productsCollection->find();


// each category is looped and all of its products are found 
// filter the products by removing products ordered in the last order 
// and remove out of stock items
// then call the randomizer function to recommend a random product from
// final array
// if the final array is empty, randomizeCateory
foreach($purchasesCategoryArray as $this_category){
    $possibleProductsArr=[];
    $criteria = ['$and' => [
        ["Category" => $this_category],
        ["Stock Quantity" => ['$gt' => 0]],
    ]];
    $products = $productsCollection->find($criteria);
    foreach ($products as $this_product){
        if (!in_array($this_product["Product ID"], $purchasesProductArray, true)){
            array_push($possibleProductsArr, $this_product["Product ID"]) ; 
        }
    }
    if ($possibleProductsArr){
        randomizeProducts($possibleProductsArr);
    }else{
        randomizeCategory($possibleProductsArr);
    }
}

// this function is called in the situation where
// the user has bought all products of a category in their last order
// get all in stock products for a category
// insert all in one array and randomize
// call randomizeProducts to randomize one item
function randomizeCategory($this_category){
    $mongoClient = new MongoDB\Client(
        'mongodb://localhost:27017'
    );
    $db = $mongoClient->ecommerce;
    $productsCollection = $db->products;
    $criteria = ['$and' => [
        ["Category" => $this_category],
        ["Stock Quantity" => ['$gt' => 0]],
    ]];
    $possibleProductsArr=[];
    $products = $productsCollection->find($criteria);
    foreach ($products as $this_product){
        array_push($possibleProductsArr, $this_product["Product ID"]) ;
    }
    randomizeProducts($possibleProductsArr);

};


// generate a random number depending on how many products
// can be recommended and get a random Product ID and pass it
// to constuctProductDiv function
function randomizeProducts($possibleProductsArr){
    $maxInt = count($possibleProductsArr) - 1;
    $randomInt = rand(0, $maxInt);
    $recommendThis = $possibleProductsArr[$randomInt];
    constuctProductDiv($recommendThis);
};


// open mongoclient in the function and get the product details
// findOne that matched the ID sent as parameter
// create a single-product card for the product
function constuctProductDiv($recommendProduct){
    $mongoClient = new MongoDB\Client(
        'mongodb://localhost:27017'
    );
    $db = $mongoClient->ecommerce;
    $productsCollection = $db->products;
    $criteria = ["Product ID" => $recommendProduct];
    $this_product = $productsCollection->findOne($criteria);
    $prodID = "'".$this_product['Product ID']."'";
    $name = "'".$this_product['Product Name']."'";
    $brand = "'".$this_product['Brand']."'";
    $price = "'".$this_product['Unit Price']."'";
    $category = "'".$this_product['Category']."'";
    echo '<div class="single-product card">
    <img src="'.$this_product['Image'].'" class="card-img-top">
    <div class="card-body">
        <p class="card-text product-name text-wrap">'.$this_product['Product Name'].'</p>
        <p class="card-text product-brand ">'.$this_product['Brand'].'</p>
        <p class="card-text product-price ">MUR '.$this_product['Unit Price'].'</p>
    </div>';
    echo '<button onclick="addProduct('.$prodID.','.$name.','.$brand.'
    ,'. $price .','.$category .')">Add To Cart</button>';
    echo '</div>';

}

