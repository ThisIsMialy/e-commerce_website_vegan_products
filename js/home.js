"use strict"

let searchWord;

// "
$(document).ready(function () {
    // hide search results functions until called
    $("#search-section").hide();
    $("#sorting-items").hide();
    $("#searchAlert").hide();
});


// when page has loaded - get all products and display by categories
$(window).on("load", function loadProducts(){
    $.ajax({
        type: 'GET',
        url: './php/products.php',
        success: function(response){
            displayAllProducts(response);
        },
        error: function(xhr){
            console.log(xhr.status); // error code (eg 404)
            console.log(xhr.statusText); // name of error eg (Not Found)
            alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
        }
    });

});


function submitSearch(sortType){
    $("#searchAlert").hide();
    searchWord = $("#searchWord").val();
    if ((searchWord.length) < 3){
        $("#searchAlert").show();
    } else {
        let data = {keyword : searchWord, sort : sortType};
        $.ajax({
            type: 'POST',
            url: './php/searchProducts.php',
            data: data,
            success: function(response){
                displaySearchResults(response, searchWord)
            },
            error: function(xhr){
                console.log(xhr.status); // error code (eg 404)
                console.log(xhr.statusText); // name of error eg (Not Found)
                alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
            }
        });

    }


};

// FUNCTIONS

//dispaying search results into display_section
//displays no results message if no response
function displaySearchResults(foundResults, searchWord){
    $("#showAllProducts").hide();
    // foundResults is string type
    let result = (foundResults);
    $("#search-section").show();
    $("#searchKeyWord").html(searchWord)
    if (result.length == 0){
        result = "<h3>No results found</h3>";
    }else{
        $("#sorting-items").show();
    }

    $("#display_section").html((result));

}

// displays all products available
function displayAllProducts(jsonProducts){
    let prodArray = jsonProducts;
    let htmlStr = "";
    for (let i=1; i<prodArray.length; ++i){
        htmlStr += " " + prodArray[i]
    }

    $("#showAllProducts").html(prodArray);
};



