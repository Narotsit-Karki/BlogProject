
function validate_form(){
	let email = document.form.email.value;
	let password = document.form.password.value;
	let c_password = document.form.confirm_password.value;
	let username = document.form.username.value;
	let valid = true;
	const emailRegx = /^\w+([\.]?\w+)*@gmail([\.]?\w+)*(\.\w{2,3})$/

	if(username == ""){
		document.getElementById("error_3").innerHTML = 'enter a valid username'
		valid = false
	}

	if(email == "" || !email.match(emailRegx)){
		document.getElementById("error_4").innerHTML = 'enter a valid email'
		valid = false
	}

	if(password.length < 8){
		document.getElementById("error_5").innerHTML = 'enter a valid password length must be greater than 8'
		valid = false
	}
	if(password != c_password){
		document.getElementById("error_6").innerHTML = 'password donot match'
		valid = false
	}

	if(valid){
			return {
				'username':username,
				'email':email,
				'password':password,
				'confirm_password':c_password
			}
		}
	return valid;

}



function clear_error(){
	let  spans  = document.getElementsByTagName("span"); 
	for(let span of spans){
		span.innerHTML = "";
	}
}