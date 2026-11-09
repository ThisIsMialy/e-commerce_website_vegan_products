<?php
//Include libraries
require __DIR__ . './vendor/autoload.php';

$mongoClient = new MongoDB\Client(
    'mongodb://localhost:27017'
);

// select database and collection
$db = $mongoClient->ecommerce;
$customerCollection = $db->customer;

$username = ($_POST['username']);
$fname = ($_POST['fname']);
$lname = ($_POST['lname']);
$address= ($_POST['address']);
$tel= ($_POST['tel']);
$email= ($_POST['email']);
$dob= ($_POST['dob']);
$password = ($_POST['password']);

$userCriteria = ["Username" => $username];

// update fields 
$editedData = ['$set' =>[
    'First Name' =>  $fname,
    'Last Name' => $lname,
    'Address' => $address,
    'Phone Number' => $tel,
    'Email' => $email,
    'DOB' =>  $dob,
    'Password' => $password
]];

// update fields that match the username, not replaced
$updateUser = $customerCollection->updateOne($userCriteria, $editedData);


if($updateUser->getModifiedCount() == 1)
    echo "edited";
else
    echo 'err';

