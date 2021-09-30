<?php
include 'inc/header.php';
Session::CheckSession();
$i=$_GET['id'];
 ?>

<?php

if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $users->updateUserByIdInfo($userid, $_POST);

}
if (isset($updateUser)) {
  echo $updateUser;
}




 ?>

 <div class="card ">
   <div class="card-header">
          <h3>FIWARE OCB <span class="float-right"> <a href="index.php" class="btn btn-primary">Back</a> </h3>
        </div>
        <div class="card-body">

    <?php
    $getUinfo = $devices->getDeviceInfoById($i);
    if ($getUinfo) {






     ?>


          <div style="width:600px; margin:0px auto">

          <form class="" action="" method="POST">
              <div class="form-group">
                <label for="name">Device name</label>
                <input type="text" name="name" value="<?php echo $getUinfo->name; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="username">readings</label>
                <input type="text" name="username" value="<?php echo $getUinfo->readings; ?>" class="form-control">
              </div>

              <div class="form-group">
                <label for="username">readings</label>
                <input type="text" name="username" value="<?php echo $getUinfo->readings; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="username">Orion Context Broker address</label>
                <input type="text" name="username" value="<?php echo $getUinfo->APIkey; ?>" class="form-control">
              </div>
              <?php
                  // data strored in array
                  $array = Array (
                      "0" => Array (
                        "post"=>$getUinfo->name .':1026/v2/entities',
                        "Header:Content-type application/json",
                        "body",
                        "id" => $getUinfo->readings,
                        "type" => $getUinfo->readings,
                        $getUinfo->APIkey,
                        "type"=> 'float',
                        "type"=>'1.5'
                      )
                      );

                      // encode array to json
                      $json = json_encode($array);
                      $bytes = file_put_contents("myfile.json", $json);


              ?>

              <div class="form-group">
              <div class="bg-card dark shadow rounded mb-4 p-4 ng-star-inserted">

                <link rel="stylesheet" href="css/style2.css" />
                <div class="header"> Orion context broker entitie </div>
                <div class="control-panel">

                </div>
                <div class="editor" id="editor"> <?php echo " $json." ?></div>

                <div class="button-container">
                  <button class="btn" onclick="executeCode()"> submit </button>
                </div>

                <div class="output"></div>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="lib/ace.js"></script>
                <script src="lib/theme-monokai.js"></script>
                <script src="ide.js"></script>
              </div>
              </div>



              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">submit</button>
                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>">Delete</a>
              </div>
            <?php } elseif(Session::get("roleid") == '2') {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">Submit</button>

              </div>

              <?php   }else{ ?>
                  <div class="form-group">

                    <a class="btn btn-primary" href="index.php">Submit</a>
                  </div>
                <?php } ?>


          </form>
        </div>




      </div>
    </div>


  <?php
  include 'inc/footer.php';

  ?>
