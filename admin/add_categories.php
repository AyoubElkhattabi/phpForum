<h1>ajouter categories</h1>
<form action="<?php echo $_SERVER['PHP_SELF'].'?id=1'; ?>" method="post" onsubmit="return true">


      <span>status</span>
      <span><select id="" name="status" class="custom-select" style="width:200px;"> <option value="1">1</option> <option value="0">0</option></select></span>
      <br>
      <span>nom</span>
      <span> <input type="text" name="name" class="form-control" style="width:350px;" ></span>
      <br>
      <span>description</span>
      <span><textarea name="description" class="form-control" style="width:350px;"></textarea></span>
      <br>
      <span>order</span>
      <span> <input type="text" name="order" value="99" class="form-control" style="width:350px;"></span>
      <br>
      <span>monitor id</span>
      <span> <input type="text" name="monitor" value="0" class="form-control"style="width:350px;" ></span>
      <br>
      <span><button type="submit" name="addcatbtn"  class="btn btn-primary">ajouter</button></span>
 
</form>