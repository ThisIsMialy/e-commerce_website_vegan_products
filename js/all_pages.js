// Mainly used to control navigation bars for all pages 
"use strict"


// every page is ready for when user clicks logout button
$(document).ready(function () {


    $("#logoutbtn").click(function(){
        userOut();
    })
    

    
})

// always check the php session every time any page loads
// change navigation user if a user is already connected
$(window).on("load", function (){
    $.ajax({  
        type: 'GET',  
        url: './php/startPHPsession.php', 
        success: function (response){
            setNavUsername(response);
        },
        error: function(xhr){
            alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
        }
    });

})

// changes nav user name
// change redirectiion of the dropdown options
function setNavUsername(username){
    if (username){
        $("#usernameNav").html(username);
        $("#viewProfile").attr("href", "profile.html"); 
        $("#changeUser").attr("href", "login.html"); 
        $("#viewOrders").attr("href", "cart.html"); 
    }
    
}

// call server to terminate session
function userOut(){
    $.ajax({  
        type: 'GET',  
        url: './php/logout.php', 
       
        success: function (response){
            logoutSuccess(response);
        },
        error: function(xhr){
            console.log(xhr.status); // error code (eg 404)
            console.log(xhr.statusText); // name of error eg (Not Found)
            alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
        }
    });
};

// display logout modal and reload page to update navigation after 2.5 seconds
// reloading will then create a brand new session 
function logoutSuccess(response){
    if (response == "logout_success"){
        $("#logoutSuccessModal").modal("show");
        setTimeout(function() {
            location.reload(); }, 2000);
    }else{
        // return false;
        $("#loginModalLabel").html("There was a problem logging you out.");
        $("#logoutSuccessModal").modal("show");
    }
}
