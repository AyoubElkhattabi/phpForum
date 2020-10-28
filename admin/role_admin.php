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
echo '<h1 class="text-center" style="color:#FFC107;">ADMINS</h1> <br>';
//add new admin

                if(isset($_GET['operation']) && isset($_GET['iduser'])){

                    $res = users_add_new_role('mlev1',$_GET['iduser']);
                    if($res == true) echo 'le Role de ce utilisateur est modifier ';
                    else echo'error';
                }

                echo'
                <div>
                <form method="post">
                <label>ID user : </label> <input class="form-control" style="width:30%; display:inline;" type="text" name="idnewadmin"> <button  class="btn btn-success" type="submit">ajouter</buuton>
                
                </form>
                </div>
                
                <br>
                
                ';



                //end add new admin

                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    if(isset($_POST['idnewadmin'])){
                        $idnewadmin = $_POST['idnewadmin'];

                        if(empty($idnewadmin)) echo 'le champ de id user est vide';
                        else if(users_get_by_id($idnewadmin) == NULL || users_get_by_id($idnewadmin) == 0 ) echo "DATABASE ERROR ou user n'existe pas";
                        else if(users_get_by_id($idnewadmin) != 0){
                        $addnewadmin =  users_add_new_role('admin',$idnewadmin);
                        if($addnewadmin == NULL) echo 'error in database';
                        else 'okey';
                        }
                        

                    }
                }



                $admins = users_get_admins();
                echo'
                <table style="width:100%">
                <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Operation</th>
                </tr>';
                if($admins!=0 && $admins!=NULL){
                foreach($admins as $admin){
                    echo '
                    <tr>
                    <td>'.$admin['u_id'].'</td>
                    <td>'.$admin['u_username'].'</td>
                    <td>'.$admin['u_role'].'</td>
                    <td><a href="admin.php?id=3&role=admin&operation=delete&iduser='.$admin['u_id'].'" style="color:#C82333;">supprimer</a></td>
                    </tr>
                    ';

                }}

                echo'
                </table>
                
                
                ';

                ?>