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

echo '<h1 class="text-center" style="color:#dc3545;">MONITORS</h1> <br>';

$categories = cat_get('');
echo '
<form method="GET">
<input type="hidden" name="id" value="3">
<input type="hidden" name="role" value="monitor">
<select class="custom-select" style="width:50%;" name="categorie">
<option value="0" name="0">--Sélectionner une categorie--</option>
';
foreach($categories as $categorie){
echo '<option value="'.$categorie['cat_id'].'" name= "'.$categorie['cat_id'].'" >'.$categorie['cat_name'].'</option>';
}

  echo'
</select> 

<button class="btn btn-success" type="submit" style="width:100px;">Go</button>
</form>
';


if($_SERVER['REQUEST_METHOD'] === 'GET'){
    //if(isset($_POST['updatemonitor']))
    $selected_categorie=NULL;
    if(isset($_GET['categorie'])) $selected_categorie = cat_get_by_id($_GET['categorie']);
    if($selected_categorie!=NULL){

        $id_categorie = $selected_categorie['cat_id'];
        $monitor = $selected_categorie['cat_monitor'];
        if($monitor==0) $monitor='';
        
        echo'
        <form method="post">
        <h3><a href="#">'.$selected_categorie['cat_name'].'</a></h3>
        <input type="hidden" name="updatemonitor" value="1">
        <input type="hidden" name="cat_id" value="'.$id_categorie.'">
        <label>Monitor ID : </label> <input class="form-control" style="width:30%; display:inline;"type="number" id="quantity" name="newmonitor" value="'.$monitor.'" min="1"  required">
        <button class="btn btn-success" type="submit">UPDATE</button>
        </form>
        
        ';

    } 
}else if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(isset($_POST['updatemonitor']) && isset($_POST['cat_id']) && isset($_POST['newmonitor'])){
        if(!empty($_POST['updatemonitor']) && !empty($_POST['cat_id'])){


                            if(trim($_POST['newmonitor'])!=""){

                                                $get_user_role = get_user_role($_POST['newmonitor']);
                                                if($get_user_role!='Administrateur'){
                                                    $add_monitor = cat_add_monitor($_POST['newmonitor'],$_POST['cat_id']);
                                                    if($add_monitor == true) {echo'monitor est ajouter'; users_add_new_role('mlev3',$_POST['newmonitor']);}
                                                    else {echo 'error1';}
                                                }else{

                                                    echo'<p style="color:red"> tu n as pas le droit de faire L Operation car le ID taper est propre au Administrateur </p>';
                                                }

                                                

                            }else{

                                                    $oldMonitor = cat_get_monitor_id($_POST['cat_id']);
                                                    if($oldMonitor!=NULL && $oldMonitor !=0){
                                                        cat_delete_monitor($_POST['cat_id']);
                                                        // CHECK IF MONITOR IS MONITOR IN ANOTHER CATEGORIE
                                                        $numberOfCatHasThisMonitor = cat_get_monitor_count_cat($oldMonitor);
                                                        
                                                        if($numberOfCatHasThisMonitor==0){
                                                                // check if user has another role like mlev2
                                                                $monitor_is_moderator_in_another_forum = moderator_Exist($oldMonitor);
                                                                if($monitor_is_moderator_in_another_forum == true){
                                                                    users_add_new_role('mlev2',$oldMonitor);
                                                                }else{
                                                                users_add_new_role('mlev1',$oldMonitor);  
                                                                }
                                                        }


                                                        
                                                        

                                                        echo 'ancient monitor est supprime';
                            }


     }

            

         }

         
           

    }
 
}

?>

