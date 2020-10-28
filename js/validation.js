

function validate_topic(){
    var sujet = document.getElementById("title");
    var titleerror = document.getElementById("titleerror");
    var textcontent  = document.getElementById("textcontent");

    if(sujet.value.trim()=="") { titleerror.textContent="Titre de Sujet Est Obligatoire" ;   return false;}
    //if(textcontent.value==""){titleerror.textContent="Le Sujet Est Vide" ;   return false;}

}

function validate_comments(){
var comment = document.getElementById("reply").value;
var errormessage = document.getElementById("commentserror");
if(comment.trim()==""){ errormessage.textContent="Le champ commentaire est vide"; return false;}

}

function validation_change_username(){
    var errmsg = document.getElementById("usernamemsgerr");
    var letterNumber = /^[0-9a-zA-Z]+$/;


    var username = document.getElementById("vusername").value;
    if(username.trim()==""){ errmsg.textContent="le champ est vide"; return false;}
    if((username.trim()).length<3) { errmsg.textContent="le nom est inferieur de 3 char"; return false}
    if((username.trim()).length>15) { errmsg.textContent="le nom est supérieur de 15 char"; return false}
    if(username.match(letterNumber)){}else { errmsg.textContent="le nom doit contenir just les lettres et les chiffres ";return false;}
    return true;
}

function validation_change_password(){


    var oldpassword = document.getElementById("password").value;
    var password1 = document.getElementById("npassword").value;
    var password2 = document.getElementById("rnpassword").value;
    var errmsg    = document.getElementById("errpasswordmsg");

    if(oldpassword.trim()==""){errmsg.textContent = "Mot de passe actuel est vide"; return false; }
    if(password1.trim()==""){errmsg.textContent = "Le Nouveau Mot de passe  est vide"; return false;}
    if(password2.trim()==""){errmsg.textContent = "Le Nouveau Re-Mot de passe  est vide"; return false;}
    if(password1!=password2){errmsg.textContent = "le mote de passe est Non compatible avec Le Re-Mote de passe"; return false;}
    if((password1.trim()).length<5) {errmsg.textContent ="password need to be more than 5 char"; return false;}
    return true;
}

function validation_change_email(){
    var email = document.getElementById("email").value;
    var errmsg = document.getElementById("erroremailmsg");
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(!email.trim()){ errmsg.textContent="e-mail vide"; return false;}
    if(!email.match(mailformat)){ errmsg.textContent="e-mail format est incorrect"; return false;}
return true;
}