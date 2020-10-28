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
if(isset($_POST['btnaddfrm'])){
    $catid = $_POST['cat'];
    $status = $_POST['status'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $order = $_POST['order'];
    $image = $_POST['image'];
    if($catid!="" && $status!=""&& $title!="" && $description!="" && $order!="" && $image!=""){
        $result = forums_add($status , $title , $description , $order , $image , $catid);
        if($result == false) echo 'error';
        else echo 'ajouter bien';
    }
}

if(isset($_GET['delete'])){

    $id_f =  $_GET['delete'];
$result = forums_delete($id_f);
if($result == false) echo 'error';
else echo'forum was deleted ';

}
if(isset($_GET['update'])){
$f_id = $_GET['update'];
$result = forums_get_by_id($f_id);
}

if(isset($_POST['btnupdatefrm'])){

   $r =  forums_update($_GET['update'] , $_POST['status'] , $_POST['title'] , $_POST['description'] , $_POST['order'] , $_POST['image'] , $_POST['cat']);
   if($r == true) echo 'true';
   else echo 'false';
}
?>




<h1>FORUMS</h1>

<?php

if(isset($_GET['update'])){

    require_once('update_forums.php');
}else{
    require_once('add_forums.php');
}

?>






<h1> modifier / supprimer categories</h1>
<div class="row">
<div class="col-12 text-center">
    <?php
    $categories = cat_get();
    foreach($categories as $categorie){

        echo '<h3 class="bg-primary">'.$categorie['cat_name'].'</h3>';
        $forums = forums_get_by_cat_id($categorie['cat_id']);
        echo'<div class="row">';
            foreach($forums as $forum){
                echo '<div class="col-8 text-left"> <span>'.$forum['f_title'].'</span></div>  <div class="col-4"><a href="admin.php?id=2&update='.$forum['f_id'].'">update</a>  <a class="text-danger" href="admin.php?id=2&delete='.$forum['f_id'].'">delete</a></div>';

            }
        echo'</div>';
    }


    ?>
</div>
<!--<div class="col-9">Nom de forum</div> <div class="col-3">Operation</div>-->





</div>