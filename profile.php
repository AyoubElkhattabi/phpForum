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

    <title>index</title>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>



  <?php
  if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && !empty($_GET['id'])){
        $profile = users_get_by_id($_GET['id']);
        if($profile==NULL || $profile ==0) {
            header('location: index.php');
            exit();
        }else{
           // print_array($profile);


        }

  }else{
      header('location: index.php');
      exit();
  }
  
  
  ?>



 <!--START CATEGORIE AND FORUMS-->
 
 <div class="main ">
   <div class="pfl">
    <div class="profile-headline">profile <?php
    
    // hna les condition imta yban l9alam
    if ($u_id == $_GET['id']){
        echo '<a href="editeprofile.php" style="color: #fff;"><i class="fas fa-pen"></i></a>';

    }
    if($u_id!=0 &&(user_can_control_user($u_id,$_GET['id']) == true )){

        echo '<a href="editeprofile.php?id='.$_GET['id'].'" style="color: #fff;"><i class="fas fa-pen"></i></a>  ';
        echo '<a href="banusers.php?id='.$_GET['id'].'" style="color: #fff;"><i class="fas fa-ban"></i></a>';

        

    }else 
    
    
    
    
    ?></div>
<div class="profile row">
<div class="profile-right-box col-12 col-sm-12 col-md-12 col-lg-4">
<div class="profile-headline">Image</div>
<img class="imgprofile" src="<?php if(empty($profile['u_image'])) echo '.\img\user.png'; else echo $profile['u_image']; ?>">
<div class="profile-headline">Titre</div>
<div class="prftitle  text-center"><?php echo get_user_role($profile['u_id']);?></div>
<div class="profile-headline">Option</div>
<div class="row text-center rowl">
    <div class="col-4"><a href="messages.php?m=send&uid=<?php echo $_GET['id']; ?>"><i class="far fa-envelope"></i><br><span>Message</span></a></div>
    <div class="col-4"><a href="#"><i class="far fa-sticky-note"></i><br><span>Sujets</span></a></div>
    <div class="col-4"><a href="#"><i class="far fa-comments"></i><br> <span>Commentaires</span></a></div>
</div>
<div class="profile-headline">Informations</div>
<div class="row rowl">
    <?php 
    if(!empty($profile['u_realName']))  echo '<div class="col-6"><span>Nom réel :</span></div> <div class="col-6"><span>'.$profile['u_realName'].'</span></div>';
    if(!empty($profile['u_id']))        echo '<div class="col-6"><span>Compte ID :</span></div> <div class="col-6"><span>'.$profile['u_id'].'</span></div>';
    if(!empty($profile['u_username']))        echo '<div class="col-6"><span>UserName :</span></div> <div class="col-6"><span>'.$profile['u_username'].'</span></div>';
    if(!empty($profile['u_country']))   echo '<div class="col-6"><span>Pays :</span></div> <div class="col-6"><span>'.$profile['u_country'].'</span></div>';
    if(!empty($profile['u_city']))      echo '<div class="col-6"><span>Ville :</span></div> <div class="col-6"><span>'.$profile['u_city'].'</span></div>';
    if(!empty($profile['u_birthDay']))  echo '<div class="col-6"><span>Age :</span></div> <div class="col-6"><span>'.getAge($profile['u_birthDay']).'</span></div>';
    if($profile['u_gender']==0 || $profile['u_gender']==1  ) echo '<div class="col-6"><span>Sexe :</span></div> <div class="col-6"><span>'; if($profile['u_gender'] == 1) echo '<i class="fas fa-male"></i>'; else echo '<i class="fas fa-female"></i>'; echo '</span></div>';
    ?>
    
    
    
</div>
<div class="profile-headline">Statistics</div>
<div class="row rowl">
    <div class="col-6"><span>Nombre de postes :</span></div> <div class="col-6"><span><?php echo users_get_topics_number($profile['u_id']);?></span></div>
    <div class="col-6"><span>Nombre de Commentaires :</span></div> <div class="col-6"><span><?php echo users_get_comments_number($profile['u_id']);?></span></div>
    <div class="col-6"><span>Date D'inscription :</span></div> <div class="col-6"><span><?php echo $profile['u_createAt']; ?></span></div>
    <div class="col-6"><span>Dernier Sujet :</span></div> <div class="col-6"><span><?php echo users_get_date_last_post($profile['u_id']);?></span></div>
    <div class="col-6"><span>Dernier Commentaire :</span></div> <div class="col-6"><span><?php echo users_get_date_last_comment($profile['u_id']);?></span></div>
</div>


<?php
// hadi les info diyal l ban dl user
if($u_id!=0){
    $userRole = get_user_role($u_id);
        if($userRole!='Membre régulier'){
            echo '

            <div class="profile-headline">Plus d information</div>
            <div class="row rowl">
                <div class="col-6"><span>Est interdite :</span></div> <div class="col-6"><span>'.$profile['u_isBanned'].'</span></div>';
                $bannedby = users_get_by_id($profile['u_bannedBy']);
                if(empty($bannedby)) $bannedby='';else $bannedby = $bannedby['u_username'];
                echo'
                <div class="col-6"><span>interdite Par :</span></div> <div class="col-6"><span>'.$bannedby.'</span></div>
                <div class="col-6"><span>Raison :</span></div> <div class="col-6"><span>'.$profile['u_banReason'].'</span></div>
                <div class="col-6"><span>date d interdit :</span></div> <div class="col-6"><span>'.$profile['u_banDate'].'</span></div>
            </div>
            ';
            
            /*
            $canControl = user_can_control_user($u_id,$profile['u_id']);
            if($canControl == true){
                echo '
                <div class="profile-headline">Operation</div>
                <div class="" style="width: 86%;margin: auto;">';
                if($profile['u_isBanned'] == 1){
                    
                    
                    echo '<div><button type="button" class="btn btn-primary">Bébloquer</button></div>';
                }else{
                    echo '<p>Raison de bloque :</p><textarea></textarea> <br>';
                    echo '<div><button type="button" class="btn btn-danger">Bloquer</button></div>';
                }
                    echo'
                    
    
                </div>
    ';
            }*/
           






        }
}


?>





</div>




<div class="profile-left-box col-12 col-sm-12 col-md-12 col-lg -8">
    <div class="profile-headline">Biographie</div>
    <div class="Descriptionprofile row">
    <span class="col"><?php echo $profile['u_bio'];?></span>
    </div>
    <div class="profile-headline">les 5 derniere Postes</div>
    <div class="5lastposts row">
        <?php
        $_5topics = topics_get_last_5_topics($profile['u_id']);
        if($_5topics!=NULL && $_5topics!=0){
            
            foreach($_5topics as $topic){

                echo '
                <a class="pst col-12" href="topic.php?id='.$topic['t_id'].'"><i class="far fa-folder"></i>  '.$topic['t_subject'].'</a>
                <hr />
                ';
            }
        }
        
        ?>
       
    </div>
    <div class="profile-headline">les 5 derniere commentaires</div>
    <div class="5lastposts row">
        <?php
        $_5comments = comments_get_last_5_Post_comments($profile['u_id']);
        if($_5comments!=NULL && $_5comments!=0){
            
            foreach($_5comments as $topic){

                echo '
                <a class="pst col-12" href="topic.php?id='.$topic['t_id'].'#comment'.$topic['replayid'].'"><i class="far fa-comment-dots"></i>  '.$topic['t_subject'].'</a>
                <hr />
                ';
            }
        }
        
        ?>

    </div>

</div>


</div>
</div>
</div>

</div>


<div class="rightSide"></div>
  
  
  
<!--END CATEGORIE AND FORUMS-->





<?php require_once('inc/footer.php');  db_close();?>