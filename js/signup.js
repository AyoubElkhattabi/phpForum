
var username = document.getElementById("username"); 
var password = document.getElementById("password");
var repassword = document.getElementById("repassword");
var email = document.getElementById("email");
var username_error = document.getElementById("username_error");
var password_error = document.getElementById("password_error");
var repassword_error = document.getElementById("repassword_error");
var email_error = document.getElementById("email_error");
function vaidate_signup(){

    //username 
    if(username.value.trim() == "")      {username_error.textContent = "username is required"; return false}else{username_error.textContent="";}
    if((username.value.trim()).length<3) {username_error.textContent = "username need 3 char or more"; return false}else{username_error.textContent="";}
    if((username.value.trim()).length>15) {username_error.textContent = "username is big"; return false}else{username_error.textContent="";}
    // password 
    if(password.value.trim() == "") {password_error.textContent ="password is required"; return false;}else{password_error.textContent="";}
    if((password.value.trim()).length<5) {password_error.textContent ="password need to be more than 5 char"; return false;}else{password_error.textContent="";}
    // repassword
    if(repassword.value.trim() != password.value.trim()) {repassword_error.textContent="password not like repassword"; return false;}else{repassword_error.textContent="";}
    //email
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(!email.value.match(mailformat)){ email_error.textContent="You have entered an invalid email address!"; return false;}else{email_error.textContent="";}

return true;

}