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

error_reporting(0);
ini_set('display_errors', 0);

require_once('./api/db.php');
require_once('./api/usersapi.php');
require_once('./api/catapi.php');
require_once('./api/forumapi.php');
require_once('./api/topicsapi.php');
require_once('./api/commentsapi.php');
require_once('./api/moderatorapi.php');
require_once('./api/adminmessageapi.php');
require_once('./api/messageapi.php');
require_once('functions.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <!--Fontawsom CSS-->
    <link rel="stylesheet" href="style/all.css">
    <link rel="stylesheet" href="style/fontawesome.min.css">
    <!--Custom Style-->
    <link rel="stylesheet" href="style/style.css">
    <!--Title of page-->