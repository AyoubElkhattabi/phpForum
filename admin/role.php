<h1>Roles</h1>
<div>
<a href="admin.php?id=3&role=admin"><button class="btn btn-warning">Admin</button></a>
<a href="admin.php?id=3&role=monitor"><button class="btn btn-danger" >Monitor</button></a>
<a href="admin.php?id=3&role=moderator"><button class="btn btn-info">Moderator</button></a>
</div>
<br>

<?php
if(isset($_GET['role'])){

    if($_GET['role']=='admin'){

        require_once('role_admin.php');
    }else if($_GET['role']=='monitor'){
        require_once('role_monitor.php');
    }else if(isset($_GET['role'])=='moderator'){
        require_once('role_moderator.php');
    }












}

?>