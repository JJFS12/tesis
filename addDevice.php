<?php
include 'inc/header.php';
Session::CheckSession();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addDevice'])) {

  $deviceAdd = $devices->addNewDevice($_POST);
}
if (isset($deviceAdd)) {
  echo $deviceAdd;
}
?>


<div class="card ">
  <div class="card-header">
         <h3 class='text-center'>Add New Device</h3>
       </div>
       <div class="cad-body">



           <div style="width:600px; margin:0px auto">

           <form class="" action="" method="post">
               <div class="form-group pt-3">
                 <label for="name">Name</label>
                 <input type="text" name="name"  class="form-control">
               </div>
               <div class="form-group pt-3">
                 <label for="name">Readings</label>
                 <input type="text" name="readings"  class="form-control">
               </div>
               <div class="form-group pt-3">
                 <label for="name">Units</label>
                 <input type="text" name="units"  class="form-control">
               </div>
               <div class="form-group pt-3">
                 <label for="name">Max value</label>
                 <input type="text" name="max"  class="form-control">
               </div>
               <div class="form-group pt-3">
                 <label for="name">Min value</label>
                 <input type="text" name="min"  class="form-control">
               </div>
               <div class="form-group pt-3">
                 <label for="name">OCB Address</label>
                 <input type="text" name="min"  class="form-control">
               </div>
               <div class="form-group">
                 <button type="submit" name="addDevice" class="btn btn-success">Register</button>
               </div>


           </form>
         </div>


       </div>
     </div>

<?php

?>

 <?php
 include 'inc/footer.php';

 ?>
