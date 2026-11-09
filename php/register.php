<?php

    //Include libraries
    require __DIR__ . './vendor/autoload.php';

    


    $mongoClient = new MongoDB\Client(
        'mongodb://localhost:27017'
    );
    
    // select database and collection
    $db = $mongoClient->ecommerce;
    $customerCollection = $db->customer;
    
    $userAlreadyExists = false;

    $username = ($_POST['username']);
    $fname = ($_POST['fname']);
    $lname = ($_POST['lname']);
    $address= ($_POST['address']);
    $tel= ($_POST['tel']);
    $email= ($_POST['email']);
    $dob= ($_POST['dob']);
    $password = ($_POST['password']);

    $allUsers = $customerCollection->find();

    foreach ($allUsers as $existing_user){
        if ($existing_user['Username'] === $username 
            || $existing_user['Email'] === $email ){
                $userAlreadyExists = true;
        }
    };

    if ($userAlreadyExists){
        echo "err";
    }else {
        $insertOneResult = $customerCollection->insertOne([
            'Username' => $username,
            'First Name' =>  $fname,
            'Last Name' => $lname,
            'Address' => $address,
            'Phone Number' => $tel,
            'Email' => $email,
            'DOB' =>  $dob,
            'Password' => $password
        ]);

        session_start(); // connect to session
        $_SESSION["loggedUser"] = $username;
        if($insertOneResult->getInsertedCount()==1){
            echo "inserted";
        }else {
            echo "err";
        }
        
    };



    