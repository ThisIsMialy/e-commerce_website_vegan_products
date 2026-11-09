<?php
    //Connect to the current session
    session_start();

    //Remove all session variables, including username 
    session_unset(); 

    //Destroy the session but session ID will remain the same
    session_destroy(); 

    // echo success back to JS 
    echo 'logout_success';
    
    