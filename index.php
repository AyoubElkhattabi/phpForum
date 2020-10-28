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
require_once('inc/top-header.php');
require_once('session.php'); 
require_once('inc/top-header.php');
?>

    <title>Forum ♡</title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>






 <!--START CATEGORIE AND FORUMS-->
 <div class="main ">
  
  <div class="categorie-container">


  <!-- hadi 5assa b categorie-->

<?php
$categories = cat_get(' ORDER BY cat_order');
$colaps=1;
foreach($categories as $categorie){
  $colaps++;
      echo '

    <div class="categorie">
      
    <h2>
      <a class="categorie-title" href="forum.php/id?='.$categorie['cat_id'].'"><i class="fas fa-laptop"></i> '.$categorie['cat_name'].' </a>
      <a class="collapsingbtn" data-toggle="collapse" data-target="#collapse'.$colaps.'" aria-expanded="false" aria-controls="collapse'.$colaps.'"  href="#" ><i class="fas fa-minus"></i></a>
    </h2>
    </div>
    ';




    // forums

    $forums = forums_get(sprintf("WHERE cat_id = %d ORDER BY f_order",$categorie['cat_id']));
    $type = gettype($forums);
    if($type=='array'){
    $x =0;
    echo '<div id="collapse'.$colaps.'" class="collapse show">';
    foreach($forums as $forum){
    echo '
    <div class="forums collapse show" id="">
    <div class="forum row">
      <div class="forum-logo col-lg-1 d-none d-md-none d-lg-block"><img src=".\img\newpostag.png" alt="" class="logo"> </div>
      <div class="forum-main col-lg-5 col-md-6">
        <div><h2><a href="forum.php?id='.$forum['f_id'].'">'.$forum['f_title'].'</a></h2></div>
        <div><h3>'.$forum['f_description'].'</h3></div>
      </div>
      <div class="forum-stats col-lg-2 d-none d-md-none d-lg-block">
        <span class="static-box"><i class="far fa-file-alt"></i> <div>'.forums_get_posts_number($forum['f_id']).'</div></span>
        <span class="static-box"><i class="far fa-comment"></i> <div>'.forum_get_comments_number($forum['f_id']).'</div></span>
      </div>
';


$lastpost = forum_get_last_post($forum['f_id']);

if($lastpost!=0){

$lastpostuser = users_get_by_id($lastpost['t_addby']);
$image = getRandomImageForUser($lastpost['t_addby']);

echo'

<div class="forum-extra  col-lg-4 col-md-6 d-none d-md-block " >
        <div class="row">
          <div class="last-post-img col-2">
            <a href="#"><img class="img-xd" src="'.$image.'" ></a>
          </div>
          <div class="last-post-title col-10">
            <div class="title"><a href="topic.php?id='.$lastpost['t_id'].'"> <i class="far fa-file-alt"></i> <span class="small-title">'.$lastpost['t_subject'].'</span> </a></div>
            <div class="by"><i class="far fa-user"></i> <span class=""> By <a class="" href="profile.php?id='.$lastpostuser['u_id'].'">'.$lastpostuser['u_username'].'</a></span>  </div>
            <div class="date"><i class="far fa-clock"></i> <span class="">'.$lastpost['t_createat'].'</span>  </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    ';
  }else{


    echo'

    <div class="forum-extra  col-lg-4 col-md-6 d-none d-md-block " >
            <div class="row">
              <div class="last-post-img col-2">
              </div>
              <div class="last-post-title col-10">
              </div>
           </div>
           </div>
           </div>
          </div>
        ';

  }


  }
}else{

echo '

no data
';

}

echo '</div>';

    }

    


?>
 


    <!-- hadi 5assa b forums d categories-->



  </div>
  
  
  </div>
  
  
  
    <!--END CATEGORIE AND FORUMS-->





<?php require_once('inc/footer.php');  db_close();?>