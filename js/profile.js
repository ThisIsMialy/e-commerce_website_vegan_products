"use strict"

$(document).ready(function (){

})

$(window).on("load", function (){
    $.ajax({  
        type: 'GET',  
        url: './php/userDetails.php', 
        success: function(response){
            changeValues(response);
        },
        error: function(xhr){
            console.log(xhr.status); // error code (eg 404)
            console.log(xhr.statusText); // name of error eg (Not Found)
            alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
        }
    });
 
})

// display the values from the database to the page
function changeValues(response){
    let parsedDetails = JSON.parse(response);
    $("#editUsername").val(parsedDetails["Username"]);
    $("#editFname").val(parsedDetails["First Name"]);
    $("#editLname").val(parsedDetails["Last Name"]);
    $("#editAddress").val(parsedDetails["Address"]);
    $("#editPhone").val(parsedDetails["Phone Number"]);
    $("#editEmail").val(parsedDetails["Email"]);
    $("#editDOB").val(parsedDetails["DOB"]);
    $("#editPassword").val(parsedDetails["Password"]);

}

//validate phone number against regex
function validatePhone(phone){
	let phoneRegex = /^[\+]?[(]?[0-9]{3,5}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{0,6}$/;
	if (!(phoneRegex.test(phone))){
		return false;
	}else {
		return true;
	}
}


// validate the values passed first
// check for presence and password matchings
// validate phone 
// username cannot be edited
function validateChanges(){
    let editUser = $("#editUsername").val();
    let editfname = $("#editFname").val();
    let editlname = $("#editLname").val();
    let editaddress = $("#editAddress").val();
    let editphone = $("#editPhone").val();
    let editemail = $("#editEmail").val();
    let editdob = $("#editDOB").val();
    let editpassword = $("#editPassword").val();
    let editconpwd = $("#editConfPwd").val();

    if (editUser.length == "" || editfname.length == "" ||
	editlname.length == ""  || editaddress.length == ""  || 
	editphone.length == ""  || editemail.length == "" || editdob.length == ""||
	editpassword.length == ""  || editconpwd.length == "" ){
		return false;
	}else {
		if (validatePhone(editphone) == false ){
			$("#editErrBody").html("Invalid phone number.");
			$("#editErrToast").toast("show");
			return false;
		}
		if (editpassword != editconpwd){
			$("#editErrBody").html("Passwords don't match.");
			$("#editErrToast").toast("show");
			return false;
		}
	
		else{
			submitEdit(editUser, editfname, editlname, editaddress,
                editphone, editemail, editdob, editpassword);
		}
}
}


// send edited data to php and store on database
function submitEdit(editUser, editfname, editlname, editaddress,editphone, editemail, editdob, editpassword){

	let data = {username : editUser, fname : editfname,
		lname: editlname, address: editaddress, tel: editphone, 
		email: editemail, dob: editdob, password: editpassword};

	$.ajax({
		type: 'POST',
		url: './php/updateUserDetails.php',
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

// reload page if successfully edited
function updateResult(response){
    if (response == 'edited'){

        setTimeout(function() {
			location.reload(); }, 3000);
    }else{
        return false;
    }
}
