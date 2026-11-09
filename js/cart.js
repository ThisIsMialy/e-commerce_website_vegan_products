"use strict"


let loggedUser = "";

$(document).ready(function () {
    $("#pastOrdersbtn").hide();

    $("#pastOrdersbtn").click(function(){
        getPastOrders();
    })


});


$(window).on("load", function (){
    // check if logged in
    $.ajax({  
        type: 'GET',  
        url: './php/userDetails.php', 
        success: function(response){
            checkUser(response);
        },
        error: function(xhr){
            console.log(xhr.status); // error code (eg 404)
            console.log(xhr.statusText); // name of error eg (Not Found)
            alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
        }
    });


});

function checkUser(response){
    if (response){
        let parsedDetails = JSON.parse(response);
        loggedUser = parsedDetails["Username"];
        $("#pastOrdersbtn").show();

    }else{
        $("#pastOrdersbtn").hide();
    }
}

function getPastOrders(){
    $.ajax({ 
        type: 'GET',  
        url: './php/getPastOrders.php',
        success: function(response){
            displayPastOrders(response);
        },
        error: function(xhr){
            console.log(xhr.status); // error code (eg 404)
            console.log(xhr.statusText); // name of error eg (Not Found)
            alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
        }
    });
}

function displayPastOrders(response){
    if (response){
        $("#pastOrdersDetails").html(response);
        $("#pastOrdersDetails").show();
    }else{
        $("#pastOrdersDetails").html(response);
        $("#pastOrdersDetails").show();
    }
   

}
