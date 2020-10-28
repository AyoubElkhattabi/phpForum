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

echo '<h1 class="text-center" style="color:#17a2b8;">MODERATORS</h1> <br>';
if($_SERVER['REQUEST_METHOD'] === 'GET'){

    if(isset($_GET['deletemoderator']) && isset($_GET['idforum'])){

        if(!empty($_GET['deletemoderator']) && !empty($_GET['idforum'])){

            $deleteModerator = moderator_delete($_GET['deletemoderator'],$_GET['idforum']);
            if($deleteModerator == true ){

                $user_role = get_user_role($_GET['deletemoderator']);
                if($user_role == 'Moderator'){
                    // check if user moderator in more than 2 forum
                    $countOfForumWhoHasModerated = moderator_number_forum_count($_GET['deletemoderator']);
                    if($countOfForumWhoHasModerated == 0){
                        users_add_new_role('mlev1',$_GET['deletemoderator']);
                    }

                    
                }
                echo "<p style='color:red'>Moderator est Supprime</p>";

            }else{

                echo 'matamsa7ch';
            }
            


            

        }

    }
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if($_POST['forum']!=0){

        $isUserExists = users_get_by_id($_POST['newmoderator']);
        if(empty($isUserExists)){
            echo "<p style='color:red'>user n'existe pas</p>";
        }else{

            $get_user_role = get_user_role($_POST['newmoderator']);
            if($get_user_role!='Administrateur'){

                $moderator_alerdy_exist = moderator_Exist_in_forum($_POST['newmoderator'],$_POST['forum']);

                if($moderator_alerdy_exist == true)  {

                    echo "<p style='color:red'>Moderator est déjà existant</p>";
                }
                else if ($moderator_alerdy_exist == false){

                     $addModerator = moderator_add($_POST['newmoderator'],$_POST['forum']) ;
                     // add  user role 
                     $userRole = get_user_role($_POST['newmoderator']);

                     if($userRole=='Membre régulier'){
                        users_add_new_role('mlev2',$_POST['newmoderator']);
                     }
                     echo "<p style='color:green'>Moderator est ajouter</p>";
        }

            }else{

                echo'<p style="color:red"> tu n as pas le droit de faire L Operation car le ID taper est propre au Administrateur </p>';

            }
                
                
               
                
                
               
            
            
        }

    }else{

        echo "<p style='color:red'>Selectionner un forum</p>";
    }

        
}





$categories = cat_get('');
echo '
<form method="POST">


<select class="custom-select" style="width:40%;" name="forum">
<option value="0" name="0">--Sélectionner un Forum--</option>
';
foreach($categories as $categorie){

    echo'<optgroup label="'.$categorie['cat_name'].'">'; 

    $forums = forums_get_by_cat_id($categorie['cat_id']);
    foreach($forums as $forum){
        echo '<option value="'.$forum['f_id'].'" name="'.$forum['f_id'].'">'.$forum['f_title'].'</option>';
    }

}

  echo'
</select> 

<label>Monitor Id</label>
<input class="form-control" style="width:30%; display:inline;" type="number" name="newmoderator" min="1" required>

<button class="btn btn-success" type="submit" style="width:100px;">AJOUTER</button>
</form>
<br>
';

//<i class="fas fa-folder-open"></i>
foreach($categories as $categorie){

    echo '<h3 style="color:#17a2b8; background: bisque;"><i class="fas fa-folder"></i>  '.$categorie['cat_name'].'</h3>';

    $forums = forums_get_by_cat_id($categorie['cat_id']);
    foreach($forums as $forum){
        echo '
        <ul style="margin:5px 0 5px 20px;">
        <li> <i class="fas fa-folder-open"></i> '.$forum['f_title'].' 
                        <ul style="margin:5px 0 5px 70px; color:black;">
                        ';
                        $moderators = moderator_get_by_forum($forum['f_id']);
                        if($moderators!=NULL && $moderators!=0){
                            foreach($moderators as $moderator){
                                $usermoderator = users_get_by_id($moderator['u_id']);
                                echo'<li> <a style="width: 200px;display: inline-block;" href="profile.php?id='.$moderator['u_id'].'"><i class="fas fa-user"></i> '.$usermoderator['u_username'].'</a> <a style="padding-left: 193px;color: red;" href="admin.php?id=3&role=moderator&deletemoderator='.$usermoderator['u_id'].'&idforum='.$forum['f_id'].'">Supprimer</a></li>';
                            }

                        }else{

                            echo '<p style="color:red">No Moderators</p>';
                        }
                        echo'
                        </ul>
      </li>
      
      </ul>
        ';
    }

}








?>