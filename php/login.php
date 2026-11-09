    <?php

    //Include libraries
    require __DIR__ . './vendor/autoload.php';

    $mongoClient = new MongoDB\Client(
        'mongodb://localhost:27017'
    );
    
    // select database and collection
    $db = $mongoClient->ecommerce;
    $customerCollection = $db->customer;

    // data from ajax
    $username = ($_POST['username']);
    $password = ($_POST['password']);

    $criteria = ['Username' => $username];

    $foundUser =  $customerCollection->findOne($criteria);

    // log user in and store into php session
    // send back a json message containing username if successful
    if ($foundUser){
        if ($foundUser['Password'] === $password){
            session_start(); // connect to session
            $_SESSION["loggedUser"] = $username;
            echo ('[{"msg":"'.$_SESSION["loggedUser"].'"}]');
        }else{
            echo '[{"msg": ""}]';
        }
    } else{
        echo '[{"msg": ""}]';
    }




    