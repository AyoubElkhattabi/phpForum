<h1>CATEGORIES</h1>
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


//button diyal ajouter
if(isset($_POST['addcatbtn'])){
  $status = $_POST['status'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $order = $_POST['order'];
  $monitor = $_POST['monitor'];


  
    if($status!="" && $name!="" && $description!=""){
      $res = cat_add($status,$name,$description,$order,$monitor);
      if($res == true){
        echo 'ajouter bien';
      }else{
        echo'error';
      }
      
    }
    

}


// update 






// delete cat
if(isset($_GET['delete'])){

$res = cat_delete($_GET['delete']);
if($res==true) echo'categorie supprimer';



}

?>

<?php
if(isset($_GET['update'])){
     require_once('update_categories.php');
}else{
   require_once('add_categories.php');
}
?>  


<h1> modifier / supprimer categories</h1>

<div class="row" style="background-color: #007BFF;padding: 10px 0;color: white;border-radius: 10px 10px 0px 0px;">
<div class="col-1">id</div><div class="col-1">status</div><div class="col-3">nom</div><div class="col-3">description</div><div class="col-1">order</div><div class="col-1">monitor</div><div class="col-2">operation</div>
</div>
<hr>
<?php 

$_categories =  cat_get();

foreach($_categories as $cat){

    echo '
    <div class="row">
    <div class="col-1">'.$cat['cat_id'].'</div>
    <div class="col-1">'.$cat['cat_status'].'</div>
    <div class="col-3">'.$cat['cat_name'].'</div>
    <div class="col-3">'.$cat['cat_description'].'</div>
    <div class="col-1">'.$cat['cat_order'].'</div>
    <div class="col-1">'.$cat['cat_monitor'].'</div>
    <div class="col-2"><a href="admin.php?id=1&update='.$cat['cat_id'].'" class="text-success">update</a> <a href="admin.php?id=1&delete='.$cat['cat_id'].'" class="text-danger">delete</a></div>
    </div>
    <br>
    <hr>
    <br>
    ';
}


?> 


