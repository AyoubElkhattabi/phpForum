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

//localhost/forum/all.php?type=topics&id=37
require_once('session.php'); 
require_once('inc/top-header.php');




?>



    <title>Utilisateur</title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>






 <!--START CATEGORIE AND FORUMS-->
 <!--START forum-->

 <div class="forumpage">


 <form class="form-inline" method='POST'>
     <div style="width:50%; margin:auto" >
  <i class="fas fa-search" aria-hidden="true"></i>
  <input class="form-control form-control-sm ml-3 w-75" type="text" name="search" placeholder="Recherche"
    aria-label="Search">
    <button type="submit" class="btn btn-primary" style="margin-left:5px;">Rechercher</button>
    </div>
</form>

<div class="forum-main-forum">







     <!--posts normale-->


     <table class="table table-striped">
  <thead>
    <tr>
        <th scope="col">Avatar</th>
        <th scope="col">ID</th>
        <th scope="col">Utilisateur</th>
        <th scope="col">Role</th>
        <th scope="col">Date d'inscription</th>
    </tr>
  </thead>
  <tbody>


<?php
$numofusersinonepage = 15;

$user = NULL;
if(!isset($_GET['page'])){
    $users = users_get_by_page($numofusersinonepage,1);
}
else if(isset($_GET['page']) && !empty($_GET['page'])){
      $users = users_get_by_page($numofusersinonepage,$_GET['page']);  
    }else{
        exit('error');
    }
    
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!empty($_POST['search'])){
        $condition = " WHERE u_username LIKE '%".trim($_POST['search'])."%' OR u_email LIKE '%".trim($_POST['search'])."%'";
        $users =  users_get($condition);
    }
    
}

if($users!=NULL){

    foreach($users as $user){
        $image = $user['u_image'];
        if(is_null($user['u_image']) || empty($user['u_image']) || $user['u_image'] =="") $image = getRandomImageForUser($user['u_id']);
        

        echo '
    <tr>
      <td><img src="'.$image.'" style="width:80px;height:80px; border-radius:100px;display:block; margin:auto"></td>
      <td>'.$user['u_id'].'</td>
      <td><a href="profile.php?id='.$user['u_id'].'">'.$user['u_username'].'</a></td>
      <td>'.get_user_role($user['u_id']).'</td>
      <td>'.$user['u_createAt'].'</td>
    </tr>  

';


    }
}







?>


</tbody>
</table>


    </div>
    <!--end post NORMALE-->




</div>
  <!--</div>-->


  <!--END forum-->
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php
        $numOfPage = users_get_count_pagination($numofusersinonepage);;
        $page = 1;
        if(isset($_GET['page'])) $page = $_GET['page'];
        if($page==1){
            echo'
            <li class="page-item disabled">
        <a class="page-link" href="users.php" tabindex="-1">Previous</a>
      </li>
            ';
        }else{
            $previous = $_GET['page']-1;
            echo"
            <li class='page-item'>
        <a class='page-link' href='users.php?page=$previous' tabindex='-1'>Previous</a>
      </li>";

        }
        
        for($x=1;$x<=$numOfPage;$x++){
            echo"<li class='page-item'><a class='page-link' href='users.php?page=$x'>$x</a></li>";
        }

        if($numOfPage==1 || $numOfPage==$page){
        echo"
        <li class='page-item disabled'>
        <a class='page-link' href='#'>Next</a>
        </li>
        ";
        }else if($numOfPage!=1 && $numOfPage!=$page ){

            $next = $page+1;
            echo"
            <li class='page-item'>
            <a class='page-link' href='users.php?page=$next'>Next</a>
            </li>
            ";
        }
        ?>
    </ul>
  </nav>
  
    <!--END CATEGORIE AND FORUMS-->





<?php require_once('inc/footer.php');  db_close();?>