<?php
//--------------------- Copyright Block ----------------------
/* 

KechForum: forum (ver 0.1)
Copyright (C) 2019-2020 PrayTimes.org

Developer: ELKHADDARI AYOUB
License: GNU LGPL v3.0

TERMS OF USE:
	Permission is granted to use this code, with or 
	without modification

This program is distributed in the hope that it will 
be useful, but WITHOUT ANY WARRANTY. 

PLEASE DO NOT REMOVE THIS COPYRIGHT BLOCK.
 
*/ 
echo '<h1 class="text-center">Admin Message</h1>';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['state'])){
    
    $update = adminmessage_update($_POST['state'],$_POST['text'],$_POST['backgroundcolor'],$_POST['fontcolor']);

    if($update==true)echo '<h3 style="color:red;">mise a jour terminé</h3>';
    else echo '<h3 style="color:red;">Error</h3>';

}


//checked="checked"
$activer='';
$desactiver = '';
if(adminmessage_check_exist() == 0){

    adminmessage_add(0 , '','#C0392B','#FFFFFF');
}

$msg = adminmessage_get();
if($msg['state']== 0) $desactiver = 'checked="checked"';else $activer='checked="checked"';




echo'
    <form method="POST">
    <label style="font-size:33px; margin-right:40px;"> Etat : </label>  activer <input  type="radio" name="state"  value="1" style="margin-right:40px;" '.$activer.'>  désactiver  <input type="radio" name="state" value="0" '.$desactiver.'>
    <br><br>
    <label>Text : </label>
    <br>
    <textarea class="form-control" name="text" row="3" style="width:700px;">'.$msg['message'].'</textarea>
    <br>
    <label>Background Coleur : </label> <input type="color" name="backgroundcolor" value="'.$msg['backgroundcolor'].'">
    <br>
    <label>Font Coleur : </label> <input type="color" name="fontcolor" value="'.$msg['fontcolor'].'">
    <br>
    <button class="btn btn-warning text-center" style="width:300px;">Mise A Jour</button>
    </form>
';







?>