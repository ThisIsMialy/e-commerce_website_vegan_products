<?php

// start new session if none created yet
// resume session if it already exists
session_start();

//Find out if session exists
// if a user is already logged in, send the username data as 
// responde to js
// else return empty string (null)
if(array_key_exists("loggedUser", $_SESSION) ){
    echo $_SESSION["loggedUser"];
}
else{
    echo '';
}