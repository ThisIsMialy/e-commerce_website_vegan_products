
//
const signUpButton = document.getElementById('register');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('login-container');


signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
	});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");

});

$(document).ready(function () {
	$(loginErrorMsg).hide();
	// hide login error message when typing user/password
	$(loginUsername).keyup(function(){
		$(loginErrorMsg).hide();
	})

	$(loginPass).keyup(function(){
		$(loginErrorMsg).hide();
	})
})

$(window).on("load", function (){


})

function login(){
	let loginUsername = $("#loginUsername").val();
	let loginPwd = $(loginPass).val();
	if (loginUsername.length == "" || loginPwd.length == ""  ){
		return false;

	}else{
		$(loginErrorMsg).hide();
		let data = {username : loginUsername, password: loginPwd};
		$.ajax({
			type: 'POST',
			url: './php/login.php',
			data: data,
			success: function(response){
				loginResult(response);
			},
			error: function(xhr){
				alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
			}
		});

	}

	
}

// if error from server, show err message
// else reload automatic reload page to clear forms and update navigation
function loginResult(response){
	let parsed = JSON.parse(response);
	if (parsed[0]['msg']){
		$("#loginSuccessModal").modal("show");
	
		setTimeout(function() {
			location.reload(); }, 3000);

	}
	if (!(parsed[0]['msg'])){
		$("#loginErrorMsg").show();
	};
	
}
//validate username against regex
function validateUsername(regUsername){
	let usernameRegex = /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,13}[a-zA-Z0-9]$/;
	if (!(usernameRegex.test(regUsername))){
		return false;
	}else if (regUsername.length < 5 || regUsername.length > 15){
		return false;
	}else {
		return true;
	}
};
//validate phone number against regex
function validatePhone(regTel){
	let phoneRegex = /^[\+]?[(]?[0-9]{3,5}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{0,6}$/;
	if (!(phoneRegex.test(regTel))){
		return false;
	}else {
		return true;
	}
}

// get form values and validate them, if no invalid values, call ajax function

function register(){
	let regUsername = $("#regUsername").val();
	let regFname = $("#regFname").val();
	let regLname = $("#regLname").val();
	let regAddress = $("#regAddress").val();
	let regTel = $("#regTel").val();
	let regEmail = $("#regEmail").val();
	let regDOB = $("#regDOB").val();
	let regPass = $("#regPass").val();
	let regConPass = $("#regConPass").val();


	if (regUsername.length == "" || regFname.length == "" ||
	regLname.length == ""  || regAddress.length == ""  || 
	regTel.length == ""  || regEmail.length == "" || regDOB == ""||
	regPass.length == ""  || regConPass.length == "" ){
		return false;
	}else {
		if (validateUsername(regUsername) == false){
			$("#regErrBody").html("Invalid username.");
			$("#regErrToast").toast("show");
			return false;
		}
		if (validatePhone(regTel) == false ){
			$("#regErrBody").html("Invalid phone number.");
			$("#regErrToast").toast("show");
			return false;
		}
		if (regPass != regConPass){
			$("#regErrBody").html("Passwords don't match.");
			$("#regErrToast").toast("show");
			return false;
		}
	
		else{
			registerAjax(regUsername, regFname, regLname, regAddress, regTel, regEmail, regDOB, regPass);
		}
	}
}


function registerAjax(regUsername, regFname, regLname, regAddress, regTel, regEmail, regDOB, regPass){
	let data = {username : regUsername, fname : regFname,
		lname: regLname, address: regAddress, tel: regTel, 
		email: regEmail, dob: regDOB, password: regPass};

	$.ajax({
		type: 'POST',
		url: './php/register.php',
		data: data,
		success: function(response){
			registerResult(response);
		},
		error: function(xhr){
			// xhr.status = error code (eg 404)
			// xhr.statusText = name of error eg (Not Found)
			alert("Error communicating with server: " + xhr.status + " " + xhr.statusText);
		}
	});
}

// after server responds, display error during register
function registerResult(response){
	if (response == "err"){
		$("#regErrToast").toast("show");
	}
	if (response == "inserted"){
		$("#loginModalLabel").html("Registration was successful, you are logged in.");
		$("#loginSuccessModal").modal("show");
		setTimeout(function() {
			location.reload(); }, 3000);

	}
};


