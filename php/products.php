<?php
// if( empty(session_id()) && !headers_sent()){
//     session_start();
// }
// $_SESSION["user"] = "hello";

// include library for mongodb/php driver
require __DIR__ . './vendor/autoload.php';

// connect to default local client port
$mongoClient = new MongoDB\Client(
    'mongodb://localhost:27017'
);

// select database
$db = $mongoClient->ecommerce;

//Select a collection 
$productsCollection = $db->products;

//find all products document 
$products = $productsCollection->find();

// empty array to store all types of categories
$categories = [];


// fill array with all categories
foreach ($products as $cust){
    if (!in_array($cust['Category'], $categories, true)) {
        array_push($categories, $cust['Category']);
    };
};


// create a section for each category found and display respective
// products under the category sections
// out of stock products will be displayed and cant be added to cart
foreach ($categories as $this_category){
    $category_title = strtoupper($this_category);
    echo '<div class="products-section">
    <div class="section-title">
        <h2>'.$category_title.'</h2>
    </div>
    <div class="products-details">';
    $all_products = $productsCollection->find();
    // make a query everytime it loops through all products
    foreach (($all_products) as $this_product){
        if ($this_product['Category'] == $this_category){
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
                $prodID = "'".$this_product['Product ID']."'";
                $name = "'".$this_product['Product Name']."'";
                $brand = "'".$this_product['Brand']."'";
                $price = "'".$this_product['Unit Price']."'";
                $category = "'".$this_product['Category']."'";
                echo '<button onclick="addProduct('.$prodID.','.$name.','.$brand.'
                ,'. $price .','.$category .')">Add To Cart</button>';

            }
            echo '</div>';
        };
    };
    echo '</div> <!-- end of products-details -->
    </div> <!-- end of products-section -->
    <hr class="solid-line">';
}



