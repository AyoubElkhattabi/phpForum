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


//http://localhost/forum/editepost.php?id=37&edite=topic
//http://localhost/forum/editepost.php?id=1&edite=reply
require_once('session.php'); 
require_once('inc/top-header.php');

if(isset($_SESSION['user_info']) && !empty($_SESSION['user_info'])) {}else{exit('login first');}
// hna kayaw9a3 l update f 7alat ma tclicka 3la l update
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if($_GET['edite'] == 'topic'){
        $edite = topics_update($_POST['title'],$_POST['editor'],$_GET['id']);
        if($edite==true) {

            header('location: message.php?message=Le sujet est modifie&link=topic.php?id='.$_GET['id'].'');

        }else{

            echo 'error';
        }


    }else if($_GET['edite'] == 'reply'){

        $replay = comments_get_by_id($_GET['id']);
        $edite = comments_update($_GET['id'] , $_POST['editor']);

        if($edite==true) {
            header('location: message.php?message=Le commentaire est modifie&link=topic.php?id='.$replay['t_id'].'');
        }else{

            echo 'error';
        }
    }

    
    exit();
}


?>




<?php

//check if the url is okey 
// check if user has the permission for edite topics or comments
if($_SERVER['REQUEST_METHOD']==='GET'){

    if(isset($_GET['id']) && isset($_GET['edite']) && !empty($_GET['id']) && !empty($_GET['edite']) &&  ($_GET['edite'] == 'topic' || $_GET['edite'] == 'reply' )  ){

        // daba radi ntchecki les permission d user
        if($_GET['edite'] == 'topic'){
            $user = $_SESSION['user_info']; 
            
           // $canEdite = can_edite_topic($user['u_id'],$_GET['id']);
           $canEdite = can_edite_topic($user['u_id'],$_GET['id']);
           if($canEdite==true) {}
           else {header("location: message.php?message=n'as pas la permission pour modifier ce sujet&link=index.php"); exit();}
           
        }
        /*
        if(isset($_GET['edite']) && $_GET['edite'] == 'reply'){
        $can = can_edite_delete_reply($_GET['id']);
        if($can==false){
            header("Location: message.php?message=Tu n'as pas la permission pour modifier ce commentaire&link=login.php");
            exit();
        }
        else{


        }*/
            
            
        
    }else{

        echo 'link ralat';
        exit();
    }



}else{
    exit();
}
    




?>




    <title>
    
    <?php 
    if($_GET['edite'] == 'topic'){
       echo topics_get_name_by_id($_GET['id']); 
    }else {
        echo 'modofier commetaire';
    }
    
    ?>
    
    </title>
    <!--Include ckeditor library-->
    <script src="ckeditor/ckeditor.js"></script>
  
    <?php require_once('inc/header.php'); ?>

<!--START CONTENT-->
<div class="content container-fluid">

  <?php require_once('inc/admin-message.php');?>





  <?php
  
///// ----------------------- security ------------------------------/////


if(isset($_GET['id']) && !empty($_GET['id'])){

    // l7imaya diyal reply : mam7miyach 100/100 7intach ya9dar l user ytla3ab b get mais rah 5addama l7imaya 5assni nfakar fiha chwiya
    if(isset($_GET['edite']) && $_GET['edite'] == 'reply'){
        $can = can_edite_delete_reply($_GET['id']);
        if($can==false){
            header("Location: message.php?message=Tu n'as pas la permission pour modifier ce commentaire&link=login.php");
            exit();
        }
       

    }else if(isset($_GET['edite']) && $_GET['id'] == 'topic'){
        $can = can_edite_topic($u_id,$t_id);
        if($can==false){
            header("Location: message.php?message=Tu n'as pas la permission pour modifier ce Sujet&link=login.php");
            exit();
        }  
    }


}else{

    exit('error7879');
}


?>






  <?php

if(empty($_SESSION['user_info'])){

header('Location: message.php?message=Tu Doit Authentifier &link=login.php');
exit();

}







if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    

    // hna radi tkoun l5adma ba3d lclick 3la modifier
    
}

?>
<?php
$str;
if($_GET['edite'] == 'topic') $str = 'Modifier Sujet';
if($_GET['edite'] == 'reply') $str = 'Modifier Commentaire';
?>




 <!--START CATEGORIE AND FORUMS-->
 <!--START forum-->
 <div class="m-3">
 <h2 class="text-center" style="color:#41B8F3"><?php echo $str; ?></h2>
     <form method="POST" action="" onsubmit="return validate_topic()"> 
<?php
$textContent = ''; // hadi ima tchad text diyal topic ola replay 
if($_GET['edite']=='topic'){
    $topic = topics_get_by_id($_GET['id']);
    $textContent =  $topic['t_text'];
   echo '
<div class="mt-3 mb-3"><label>Titre de Sujet : </label>  <input type="text" class="form-control frm-ctr" id="title" name="title" placeholder="" value="'.$topic['t_subject'].'"> <span id="titleerror" style="color:red; font-size:18px;">*</span></div>

'; 
}else if($_GET['edite'] == 'reply'){
    $reply = comments_get_by_id($_GET['id']);
    $textContent = $reply['r_text'];

    
echo '<h3>Sujet : <span style="font-size:20px; color:red;">'.topics_get_name_by_id($reply['t_id']).'<span></h3>';
}


?>
<div class="editblockr mt-3 mb-3"><textarea name="editor" class="form-control" id="textcontent" rows="10"><?php echo $textContent;?></textarea> </div>
<div class="editprofilerow mt-3 mb-3"><button type="submit" class="btn btn-primary btn-lg">Modifier</button></div>
</form>
</div>


<script src="js/validation.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>


  <!--END forum-->
  
    <!--END CATEGORIE AND FORUMS-->





<?php require_once('inc/footer.php');  db_close();?>