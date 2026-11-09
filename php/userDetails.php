<?php
    // connect to session
    session_start();

    if(array_key_exists("loggedUser", $_SESSION) ){
        $currentUser = $_SESSION["loggedUser"];
    }
    else{
        echo '';
        return false;
    }

    //Include libraries
    require __DIR__ . './vendor/autoload.php';

    $mongoClient = new MongoDB\Client(
        'mongodb://localhost:27017'
    );

    // select database and collection
    $db = $mongoClient->ecommerce;
    $customerCollection = $db->customer;

    $userCriteria = ["Username" => $currentUser];

    $userResult = $customerCollection->findOne($userCriteria);
    // send logged user's information as a json
    echo json_encode($userResult);
