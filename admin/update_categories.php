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
$res = cat_get_by_id($_GET['update']);
if($res==false) {
    echo'error there is no categorie with id '.$_GET['update'];
die();
}
else{
    $cat_id = $res['cat_id'];
    $cat_status = $res['cat_status'] ;
    $cat_name = $res['cat_name'];
    $cat_description = $res['cat_description'];
    $cat_order = $res['cat_order'];
    $cat_monitor= $res['cat_monitor'];

}


//click btn 
if( isset($_POST['updatecatbtn'] )){
    $cat_status = $_POST['status'];
    $cat_name = $_POST['name'];
    $cat_description = $_POST['description'];
    $cat_order = $_POST['order'];
    $cat_monitor= $_POST['monitor'];
    $res =  cat_update($cat_id,$cat_status,$cat_name,$cat_description,$cat_order,$cat_monitor);
    if($res ==false) echo'error'; else echo'<p style="color:red">update successfully</p>';

}

?>


<div class="row">
<h2>update categories :</h2><?php echo '<h2 class="text-primary">'.$cat_name.'</h2>'?>
</div>
<form action="<?php echo $_SERVER['PHP_SELF'].'?id=1&update='.$cat_id; ?>" method="post" onsubmit="return true">


      <span>status</span>
      <span><select id="" name="status" class="custom-select" style="width:200px;" value="<?php echo $cat_status;?>"> <option value="1">1</option> <option value="0">0</option></select></span>
      <br>
      <span>nom</span>
      <span> <input type="text" name="name" class="form-control" style="width:350px;" value ="<?php echo $cat_name;?>"></span>
      <br>
      <span>description</span>
      <span><textarea name="description" class="form-control" style="width:350px;"> <?php echo $cat_description;?></textarea></span>
      <br>
      <span>order</span>
      <span> <input type="text" name="order" class="form-control" style="width:350px;" value ="<?php echo $cat_order;?>"></span>
      <br>
      <span>monitor id</span>
      <span> <input type="text" name="monitor" class="form-control" style="width:350px;" value ="<?php echo $cat_monitor;?>" ></span>
      <br>
      <span><button type="submit" name="updatecatbtn" class="btn btn-warning">update</button></span>
 
</form>