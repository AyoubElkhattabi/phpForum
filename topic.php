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

require_once('session.php'); 
require_once('inc/top-header.php');







// get topic
// check if url conatine ?id=
 if(!isset($_GET['id'])){
    header('location: index.php');
    exit();
 }
$topic = topics_get_by_id($_GET['id']);
// check if topic exist
 if($topic==0 || $topic == NULL){
  header('location: index.php');
  exit();
 }

 //check if topic hidden
 if($topic['t_isHidden'] == 1){
   //check if user have permission
   $_user_id = $_SESSION['user_info']['u_id'];
   if(empty($_user_id)) $_user_id =0;
   $canShowTpic = can_show_hidden_topic($_user_id,$_GET['id']);
   if($canShowTpic == false){
    header("location: message.php?message=tu n'as pas le droit pour consulter ce sujet&link=index.php");
    exit();
   }
  
 }
 /*increment view*/ 
 topics_views_increment($topic['t_id']);
 $topicUser = users_get_by_id($topic['t_addBy']);
 $image = getRandomImageForUser($topicUser['u_id']);
 $role = get_user_role($topic['t_addBy']);
 $numberTopic = users_get_topics_number($topicUser['u_id']);
 $numberComments = users_get_comments_number($topicUser['u_id']);
 $country='';
 if(empty($topicUser['u_country'])){$country = 'La Terre';}  else{$country = $topicUser['u_country'];} 
 $age='o_O';
 if(!empty($topicUser['u_birthDay']))$age = getAge($topicUser['u_birthDay']);
 ?>


    <title><?php echo $topic['t_subject'];?></title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>






 <!--START CATEGORIE AND FORUMS-->
 <!--START forum-->

 

 <div class="bread_crumb"> 
<?php echo breadcrumb('topic',$_GET['id']); ?>
</div>

 <div class="forumpage">

<h2 class="headtotle text-center"><?php echo $topic['t_subject']; ?></h2>
<div class="main-post row">
<div class="author-info col-2">

<div class="post-img-author">
<a href="profile.php?id=<?php echo $topicUser['u_id']; ?>">
<img class="post-img-author-x" src="<?php echo $image;?>" alt="admin">
<span class="username-author"><?php echo $topicUser['u_username']; ?></span>
</a>
</div>
<div class="author-info-details">
<div class="m-title"> <?php echo $role;?></div>


<div class="more-info"><span><i class="far fa-calendar"></i>joindre a : </span><span class="xbt"><?php echo $topicUser['u_createAt'];?></span></div>
<div class="more-info"><span><i class="fas fa-clipboard"></i>Sujets : </span><span class="xbt"><?php echo $numberTopic; ?></span></div>
<div class="more-info"><span><i class="far fa-comment"></i>Commentaires : </span><span class="xbt"><?php echo $numberComments;?></span></div>
<div class="more-info"><span><i class="fas fa-map-marker-alt"></i>Pays :</span><span class="xbt"><?php echo $country;?></span></div>
<div class="more-info"><span><i class="far fa-user"></i>Age :</span><span class="xbt"><?php echo $age;?></span></div>

</div>
</div>
<?php
 //echo $topic['']; 
 ?>  
<div class="postcontent col-10">
<div class="post-date">
  <span class="dateofpost">Ajouter À : <?php echo $topic['t_createAt']; ?></span> <?php topic_edite_pin_hide_remove($u_id,$topic['t_id']);?><hr>
  
</div>

<!--content-->

<?php echo $topic['t_text'];  ?>
<!-- end content-->
</div>

</div>

</div>




<!-------- add users to hidden topics---------->



<?php

if($topic['t_isHidden'] == 1 && can_add_users_to_hidden_topic($u_id,$topic['t_id'])==true){


  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_from_hidden_topic']) && $_POST['delete_user_from_hidden_topic']>0){

    $removeUserFromHiddenTopic = topics_remove_user_from_hide_topic($_POST['delete_user_from_hidden_topic'] , $_GET['id']);
    if($removeUserFromHiddenTopic!=NULL && $removeUserFromHiddenTopic!=false){
      echo '<div class="text-center"><p style="color:blue">Utilisateur est enleve</p></div>';
    }else{
      echo '<div class="text-center"><p style="color:red">Error</p></div>';
    }
      

  }


  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addusertohiddenpost']) && $_POST['addusertohiddenpost'] ==1){

    $users_id = string_to_users_array_id($_POST['users_list']);
    if(!empty($users_id)){
        $addUsersToHiddenTopic = topics_add_multiple_users_to_hide_topic($users_id,$_GET['id'],$u_id);
        if($addUsersToHiddenTopic == true) {echo'<div class="text-center"><p style="color:green">dakchi howa hadak</p></div>';}
        else{echo'<div class="text-center"><p style="color:green">kayn chi mouchkil</p></div>';}
      
    }else{
      echo'<div class="text-center"><p style="color:red">Aucun utilisateur ajouter</p></div>';
    }
    
  }

echo '

<form method="POST">
<input type="hidden" name="addusertohiddenpost" value="1">
<p class="text-center">
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2"><i class="fas fa-low-vision"></i></button>
</p>
<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample2">
      <div class="card card-body">
        <p class="text-center">Ajouter un utilisateur au Sujet : <p>
        <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text input-group-texttt" id="basic-addon3"  >exemple : user1,user2,user3</span>
  </div>
        <input type="text" class="form-control" name="users_list" id="basic-url" aria-describedby="basic-addon3">
</div>
        <div class="text-center"><button type="submit" class="btn btn-warning" style="width:250px;">Ajouter</button> <button type="button" class="btn btn-danger" style="width:250px;">ENLEVER TOUT</button></div>

            
        </form>

            <p class="text-center">Membres</p>
            <table style="width:500px; margin:auto;">
                <tr>
                  <th>ID</th>
                  <th>USER</th> 
                  <th>AJOUTER PAR</th>
                  <th>OPERATION</th>
                </tr>';

                $users_has_permission = topics_get_users_who_can_see_hidden_topic($_GET['id']);
                if($users_has_permission!=NULL && $users_has_permission!=0){

                  foreach($users_has_permission as $row){
                    $user = users_get_by_id($row['u_id']);
                    $addedby = users_get_by_id($row['addedby']);
                    echo '
                          <tr>
                            <td><a href="profile.php?id='.$user['u_id'].'">'.$user['u_id'].'</a></td>
                            <td><a href="profile.php?id='.$user['u_id'].'">'.$user['u_username'].'</a></td>
                            <td><a href="profile.php?id='.$addedby['u_id'].'">'.$addedby['u_username'].'</a></td>
                            <form method="POST">
                            <td class="text-center"><button type="submit" class="btn btn-danger" name="delete_user_from_hidden_topic" value="'.$user['u_id'].'">Enlever</button></td>
                            </form>
                            </tr>
                    
                    ';

                  }

                }
                
    echo'
          </table>

<br />
<div class="text-center"></div>


      </div>
    </div>
  </div>

</div>
<br>


';

}




?>




<!-------- end add users to hidden topics---------->

<!--start comments-->


<?php


  $comments = comments_get_by_post($_GET['id']);
  if($comments !=0){

      foreach($comments as $comment){
        //get user comment info 
        
        $commentUser = users_get_by_id($comment['u_id']);
        $image = getRandomImageForUser($comment['u_id']);
        $role = get_user_role($comment['u_id']);
        $numberTopic = users_get_topics_number($comment['u_id']);
        $numberComments = users_get_comments_number($comment['u_id']);
        $country='';
        if(empty($commentUser['u_country'])){$country = 'La Terre';}  else{$country = $commentUser['u_country'];} 
        $age='o_O';
        if(!empty($commentUser['u_birthDay']))$age = getAge($commentUser['u_birthDay']);

    echo '

    <div class="forumpage" id="comment'.$comment['r_id'].'">
    <div class="main-post row">
    <div class="author-info col-2">
    <div class="post-img-author">
    <a href="profile.php?id='.$commentUser['u_id'].'">
    <img class="post-img-author-x" src="'.$image.'" alt="'.$commentUser['u_username'].'">
    <span class="username-author">'.$commentUser['u_username'].'</span>
    </a>
    </div>
    <div class="author-info-details">
    <div class="m-title">'.$role.'</div>
    <div class="more-info"><span><i class="far fa-calendar"></i>joindre a : </span><span class="xbt">'.$commentUser['u_createAt'].'</span></div>
    <div class="more-info"><span><i class="fas fa-clipboard"></i>Sujets : </span><span class="xbt">'.$numberTopic.'</span></div>
    <div class="more-info"><span><i class="far fa-comment"></i>Commentaires : </span><span class="xbt">'.$numberComments.'</span></div>
    <div class="more-info"><span><i class="fas fa-map-marker-alt"></i>Pays :</span><span class="xbt">'.$country.'</span></div>
    <div class="more-info"><span><i class="far fa-user"></i>Age :</span><span class="xbt">'.$age.'</span></div>
    </div>
    </div>
    <div class="postcontent col-10">
    <div class="post-date">
    <span class="dateofpost">Ajouter À : '.$comment['r_date'].'</span>';
    can_update_delete_reply($comment['r_id']);
    echo'
    <hr>
    </div>'.$comment['r_text'].'</div>
    </div>
    </div>


    ';


      }
    }//end foreach


?>

<!-- end  comments-->



<!-- Add Comment-->

<?php


if($u_id!=0){
  
  $canAddReply = can_add_reply($u_id,$_GET['id']);
  if($canAddReply == true){

            echo '
        <div class="forumpage">
        <div class="main-post row">
        <div class="author-info col-2">
        <div class="post-img-author">
        <img class="post-img-author-x" src=".\img\user.png" alt="admin">
        </div>

        </div>
        <div class="postcontent col-10 add-comment">
        <form method = "post" action="addreply.php" onsubmit="return validate_comments()">
          
        <input type="hidden" id="idpost" name="idpost" value="'.$_GET['id'].'"><!--hadi hidden bach tsift liya id post l add comment bach yraja3ni l page -->
        <textarea class="form-control" id="reply" name="reply"  rows="3"></textarea> 
        <button type="submit" class="btn btn-primary commenter-button">Commenter</button> <span style="color:red; font-size:16px;" id="commentserror"></span>
        </form>
        </div>
        </div>
        </div>
          ';
  }else{

    echo '
    <div class="forumpage">
        <div class="main-post row">
        <div class="author-info col-2">
        <div class="post-img-author">
        <img class="post-img-author-x" src=".\img\user.png" alt="admin">
        </div>

        </div>
        <div class="postcontent col-10 add-comment">
        <p class="text-center">
        <i class="fas fa-exclamation-triangle"></i>
        Vous ne pouvez pas ajouter de commentaire car ce Sujet est fermé</p>
        </div>
        </div>
        </div>
    
    ';
  }
  
  
}else{


    echo '
    <div class="forumpage">
        <div class="main-post row">
        <div class="author-info col-2">
        <div class="post-img-author">
        <img class="post-img-author-x" src=".\img\user.png" alt="admin">
        </div>

        </div>
        <div class="postcontent col-10 add-comment">
        <p class="text-center">
        <i class="fas fa-exclamation-triangle"></i>
        Vous devez vous <a href="signup.php">inscrire</a> / <a href="login.php">Authentifier <a/> pour pouvoir ajouter un commentaire</p>
        </div>
        </div>
        </div>
    
    ';

}


?>






<!--end Add Comment-->





  <!--END forum-->
  
  
  
    <!--END CATEGORIE AND FORUMS-->



<script src="js/validation.js"></script>

<?php require_once('inc/footer.php');  db_close();?>