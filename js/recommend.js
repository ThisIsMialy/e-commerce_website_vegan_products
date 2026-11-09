"use strict";

// hide the recommendation section when home is loaded
$(document).ready(function () {
    $("#userRecommendations").hide();
  
})

// after page loads, use ajax to get the recommendation
$(window).on("load", function (){
    $.ajax({  
        type: 'GET',  
        url: './php/recommendation.php',
        success: function (response){
            displayRecommendations(response);
        },
        error: function(xhr){
            alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
        }
    });

})

// if there is a response, place them on the recommendations div
function displayRecommendations(recommendations){
    if (recommendations){

        $("#recommendedProducts").html(recommendations);
        $("#userRecommendations").show();
       
    }else{
        return false;
    }


};