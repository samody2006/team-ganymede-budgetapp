// SELECTING ALL TEXT ELEMENTS
var fname = document.forms['signupForm']['fname'];
var username = document.forms['signupForm']['username'];
var email = document.forms['signupForm']['email'];
var password = document.forms['signupForm']['password'];
var password_confirm = document.forms['signupForm']['confirmPassword'];
// SELECTING ALL ERROR DISPLAY ELEMENTS
var name_error = document.getElementById('name_error');
var username_error = document.getElementById('username_error');
var email_error = document.getElementById('email_error');
var password_error = document.getElementById('password_error');
var letters = /^[A-Za-z]+$/;
// SETTING ALL EVENT LISTENERS
fname.addEventListener('blur', nameVerify, true);
username.addEventListener('blur', usernameVerify, true);
email.addEventListener('blur', emailVerify, true);
password.addEventListener('blur', passwordVerify, true);
// validation function
function Validate() {
  // validate name
  if (fname.value == "") {
    fname.style.border = "2px solid red";
    document.getElementById('inputName').style.color = "red";
    name_error.textContent = "Name is required";
    fname.focus();
    return false;
  }
  //validate name is longer than 2
  if (fname.value.length <= 2) {
    fname.style.border = "2px solid red";
    document.getElementById('inputName').style.color = "red";
    name_error.textContent = "Name must be at least 3 characters";
    fname.focus();
    return false;
  }
  // if name contains number or other characters
  if(!(fname.value.match(letters))) {
    fname.style.border = "2px solid red";
    document.getElementById('inputName').style.color = "red";
    name_error.textContent = 'Please input alphabet characters only';
    fname.focus();
    return false;
  }

  // validate username
  if (username.value == "") {
    username.style.border = "2px solid red";
    document.getElementById('inputUsername').style.color = "red";
    username_error.textContent = "Username is required";
    username.focus();
    return false;
  }
  // validate username
  if (username.value.length < 3) {
    username.style.border = "2px solid red";
    document.getElementById('inputUsername').style.color = "red";
    username_error.textContent = "Username must be at least 3 characters";
    username.focus();
    return false;
  }
  // validate username for space
  if(username.value.indexOf(' ') !== -1){
    username.style.border = "2px solid red";
    document.getElementById('inputUsername').style.color = "red";
    username_error.textContent = "Space is not allowed";
    username.focus();
    return false;
  }
  // validate email
  if (email.value == "") {
    email.style.border = "1px solid red";
    document.getElementById('inputEmail').style.color = "red";
    email_error.textContent = "Email is required";
    email.focus();
    return false;
  }
  // validate password
  if (password.value == "") {
    password.style.border = "1px solid red";
    document.getElementById('inputPassword').style.color = "red";
    password_confirm.style.border = "1px solid red";
    password_error.textContent = "Password is required";
    password.focus();
    return false;
  }
  // check if the two passwords match
  if (password.value !== password_confirm.value) {
    password.style.border = "1px solid red";
    document.getElementById('confirmPassword').style.color = "red";
    password_confirm.style.border = "1px solid red";
    password_error.innerHTML = "The two passwords do not match";
    return false;
  }
}
// event handler functions
function nameVerify() {
  if((fname.value !== "") && (fname.value.match(letters))) {
   fname.style.border = "2px solid #46B32A";
   document.getElementById('inputName').style.color = "#46B32A";
   name_error.innerHTML = "";
   return true;
  }
}
function usernameVerify() {
  if ((username.value !== "") && (username.value.indexOf(' ') == -1)) {
   username.style.border = "2px solid #5e6e66";
   document.getElementById('inputUsername').style.color = "#46B32A";
   username_error.innerHTML = "";
   return true;
  }
}
function emailVerify() {
  if (email.value !== "") {
  	email.style.border = "2px solid #5e6e66";
  	document.getElementById('inputEmail').style.color = "#46B32A";
  	email_error.innerHTML = "";
  	return true;
  }
}
function passwordVerify() {
  if (password.value !== "") {
  	password.style.border = "1px solid #5e6e66";
  	document.getElementById('confirmPassword').style.color = "#46B32A";
  	document.getElementById('inputPassword').style.color = "#46B32A";
  	password_error.innerHTML = "";
  	return true;
  }
  if (password.value === password_confirm.value) {
  	password.style.border = "1px solid #5e6e66";
  	document.getElementById('confirmPassword').style.color = "#46B32A";
  	password_error.innerHTML = "";
  	return true;
  }
}