<?php
//Include libraries
require __DIR__ . './vendor/autoload.php';
// use regex to match search keyword with products
use MongoDB\BSON\Regex;

$mongoClient = new MongoDB\Client(
    'mongodb://localhost:27017'
);

// select database and collection
$db = $mongoClient->ecommerce;
$productsCollection = $db->products;

// assign keyword and sort type to variables
$keyWordSearch = ($_POST['keyword']);
$sortType = ($_POST['sort']);

// create search criteria with regex
$criteria = ['$or' => [
    ["Product Name" => ['$regex' => new Regex($keyWordSearch),'$options' => 'si']],
    ["Brand" => ['$regex' => new Regex($keyWordSearch), '$options' => 'si']],
    ["Category" => ['$regex' => new Regex($keyWordSearch), '$options' => 'si']],
]];

// if sort type is category, create category array and create section for each of the category
if ($sortType == "category"){
    $products = $productsCollection->find($criteria);
    $categories = [];
    // create array of all categories
    foreach ($products as $cust){
        if (!in_array($cust['Category'], $categories, true)) {
            array_push($categories, $cust['Category']);
        };
    };

    // sections with products
    foreach ($categories as $this_category){
        $category_title = strtoupper($this_category);
        echo '<div class="products-section">
        <div class="section-title">
            <h2>'.$category_title.'</h2>
        </div>
        <div class="products-details">';
        $all_products = $productsCollection->find($criteria);
        // make a query everytime it loops through all products
        foreach (($all_products) as $this_product){
            if ($this_product['Category'] == $this_category){
                $prodID = "'".$this_product['Product ID']."'";
                echo '<div class="single-product card">
            <img src="'.$this_product['Image'].'" class="card-img-top"';
            if ($this_product['Stock Quantity'] < 1){
                echo 'style="filter: blur(1.3px);"';
            }
            echo '>
            <div class="card-body">
                <p class="card-text product-name text-wrap">'.$this_product['Product Name'].'</p>
                <p class="card-text product-brand ">'.$this_product['Brand'].'</p>
                <p class="card-text product-price ">MUR '.$this_product['Unit Price'].'</p>
            </div>';
            if ($this_product['Stock Quantity'] < 1){
                echo '<p class="no-stock">OUT OF STOCK</p>';
            }else{
                echo '<button onclick="addProduct('.$prodID.')">Add To Cart</button>';
            }
            echo '</div>';
            };
        };
        echo '</div> <!-- end of products-details -->
        </div> <!-- end of products-section -->
        <hr class="solid-line">';
    }
    
    // if sort type is name or price, create options to sort the products 
}else {
    if ($sortType == "nameAsc"){
        $options = [ 'sort' => ['Product Name' => 1]];
    }elseif ($sortType == "nameDesc"){
        $options = [ 'sort' => ['Product Name' => -1]];
    }elseif ($sortType == "priceAsc"){
        $options = [ 'sort' => ['Unit Price' => 1]];
    }elseif ($sortType == "priceAsc"){
        $options = [ 'sort' => ['Unit Price' => -1]];
    }else {
        $options = [ ];
    }
    // include options to query
    $products = $productsCollection->find($criteria, $options);

    // list all products
    foreach ($products as $this_product){
        $prodID = "'".$this_product['Product ID']."'";
        echo '<div class="single-product card">
        <img src="'.$this_product['Image'].'" class="card-img-top"';
        if ($this_product['Stock Quantity'] < 1){
            echo 'style="filter: blur(1.3px);"';
        }
        echo '>
        <div class="card-body">
            <p class="card-text product-name text-wrap">'.$this_product['Product Name'].'</p>
            <p class="card-text product-brand ">'.$this_product['Brand'].'</p>
            <p class="card-text product-price ">MUR '.$this_product['Unit Price'].'</p>
        </div>';
        if ($this_product['Stock Quantity'] < 1){
            echo '<p class="no-stock">OUT OF STOCK</p>';
        }else{
            echo '<button onclick="addProduct('.$prodID.')">Add To Cart</button>';
        }
        echo '</div>';
    };
};




