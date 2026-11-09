"use strict"
// ADDING TO SCART

$(document).ready(function () {
    $("#noUser").hide();
    $("#checkoutUser").hide();
})

$(window).on("load", function (){
    $.ajax({  
        type: 'GET',  
        url: './php/startPHPsession.php', 
        success: function (response){
            controlbtns(response);
        },
        error: function(xhr){
            alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
        }
    });


    displayCart();

    $("#cancelOrder").click(function(){
        localStorage.clear();
        displayCart();
    })

    $("#confirmOrder").click(function(){
        updateDatabase();
    })

    $("#proceedCheckout").click(function(){
        if(localStorage.basketItems === undefined || localStorage.basketItems === ""){
            return false;
        }else{
            displayConfirmModal();
        }
    })
})

function controlbtns(username){
    if (username){
        $("#checkoutUser").show();
        $("#noUser").hide();
    }else{
        $("#noUser").show();
        $("#checkoutUser").hide();
    }

    
}



let basketItems;
function getBasket(){
    if(localStorage.basketItems === undefined || localStorage.basketItems === ""){
        basketItems = [];
        let today = new Date();
        let dd = String(today.getDate()).padStart(2, '0');
        let mm = String(today.getMonth() + 1).padStart(2, '0');
        let yyyy = today.getFullYear();
        today = dd + '/' + mm + '/' + yyyy;
        localStorage.basketDate = today;

        localStorage.basketTotal = 0;
        localStorage.basketTotalItems = 0;

    }
    else {
        basketItems = JSON.parse(localStorage.basketItems);
    }
    return basketItems;
}

// called from ADD to cart buttons
function addProduct(id, name, brand, price, category){
    console.log(id, name, brand, price, category);

    basketItems = getBasket();

    basketItems.push({
        proID: id,
        prodName: name,
        prodBrand: brand,
        prodPrice: price,
        prodQuantity: 1,
        prodSubtotal: price,
        prodCat: category,
    });

    // increase count for every added product
    let prevCount = parseInt(localStorage.basketTotalItems)
    localStorage.basketTotalItems = prevCount + 1;

    //Store in local storage
    localStorage.basketItems = JSON.stringify(basketItems);
    console.log((localStorage.basketItems));
    displayCart();

}

let total = 0;

function displayCart(){
    console.log("Display");
    $("#basketDate").html(localStorage.basketDate)
    let itemDivs = "";
  
    basketItems = JSON.parse(localStorage.basketItems);
    // console.log(basketItems[1].prodName);
    for(let i =0; i < basketItems.length; i++){
        total += parseInt(basketItems[i].prodPrice)
        itemDivs += '<div class="cart-item row">';
        itemDivs += '<div class="cart-item-info col-5">';
        itemDivs += '<p class="item-name">'+ basketItems[i].prodName+'</p>'
        itemDivs += '<p class="item-brand">'+ basketItems[i].prodBrand + '</p>'
        itemDivs += '<p class="item-price">MUR' +basketItems[i].prodPrice+ '</p>'
        itemDivs += '</div>'
        itemDivs += '<div class="cart-item-amount col-3">'
        itemDivs += '<p class="item-quntity">Quantity:</p>'
        itemDivs += '<div class="form-outline" style="width: 150px;">' + basketItems[i].prodQuantity
        // itemDivs += '<input value="1" type="number" id="typeNumber" class="form-control" min="1" max="50"/>'
        itemDivs +=  '</div></div>'
        itemDivs += '<div class="cart-item-subtotal col-2"><p class="item-subtotal">Subtotal:</p>'
        itemDivs += '<p class="item-subtotal-amount">MUR' +basketItems[i].prodPrice+ '</p></div>'
        // itemDivs += '<div class="col-2"> <button class="cart-item-remove id=remove('+basketItems[i].prodID+')"><i class="fa-solid fa-trash"></i>'
        // itemDivs += '</button></div>'
        itemDivs += '</div><hr class="solid-line">';

    }
    $("#currentCartDisplay").html(itemDivs);
    $("#totalAmount").html(total);
};

function displayConfirmModal(){
    $("#modalDate").html(localStorage.basketDate)
    $("#modalPrice").html(total)
    $("#checkout-confirm").modal("show")
};


// inoperational
function updateDatabase(){
    basketItems = JSON.parse(localStorage.basketItems);
    let orderID = "OR"+ JSON.stringify(localStorage.basketDate);
    let data = {orderID : orderID, date : localStorage.basketDate,
		total: total, quantity: localStorage.basketTotalItems};

	$.ajax({
		type: 'POST',
		url: './php/updateOrder.php',
		data: data,
		success: function(response){
			updateResult(response);
		},
		error: function(xhr){
			// xhr.status = error code (eg 404)
			// xhr.statusText = name of error eg (Not Found)
			alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
		}
	});

}


