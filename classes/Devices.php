<?php

//include 'lib/Database.php';
include_once 'lib/Session.php';
$id =  Session::get('id');
class Devices{
  // Db Property
  private $db;
  private $id;
  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }
  // Date formate Method
   public function formatDate($date){
     // date_default_timezone_set('Asia/Dhaka');
      $strtime = strtotime($date);
    return date('Y-m-d H:i:s', $strtime);
   }
   public function addNewDevice($data){
     $name = $data['name'];
     $readings = $_POST['readings'];
     $units = $data['units'];
     $max  = $data['max'];
     $min  = $data['min'];
     $ocba  = $data['ocba'];
     $Protocol  = $data['protocol'];
     $IoTAgent  = $data['agent'];


     if ($name == "" || $readings == "" ) {
       $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 <strong>Error !</strong> Input fields must not be Empty !</div>';
         return $msg;
     }//elseif (strlen($readings) < 3) {
       //$msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
 //<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
// <strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
//         return $msg;


     else{
       $APIkey = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
       $sql = "INSERT INTO tbl_device(name,readings,APIkey,deviceid,units,max,min,ocba,Protocol,IoTAgent)
       VALUES(:name, :readings, :APIkey, :deviceid, :units, :max, :min,:ocba,:Protocol,:IoTAgent)";
       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':name', $name);

       $stmt->bindValue(':readings', implode(",",$_POST['readings']));

       $stmt->bindValue(':APIkey',$APIkey);
       $stmt->bindValue(':units',$units);
       $stmt->bindValue(':max',$max);
       $stmt->bindValue(':min',$min);
       $stmt->bindValue(':deviceid', Session::get('id'));
       $stmt->bindValue(':ocba', $ocba);
       $stmt->bindValue(':Protocol', $Protocol);
       $stmt->bindValue(':IoTAgent',$IoTAgent);;
       $result = $stmt->execute();
       $col_types = array();
       array_push($readings,"link","cur_time","id");
       for($i=0; $i<count($readings) ;$i=$i+1)
        {
          $col_types[$i] ='varchar(10)' ;
        }
        for($i=0; $i<count($readings)-1 ;$i=$i+1)
        {
          $col_types[$i].="," ;
        }
       $query = "CREATE TABLE $name( ";
          for($i=0; $i<count($readings) ;$i=$i+1)
          {
            $query .= " $readings[$i]" . " " . " $col_types[$i]"  ;
          }
          $query .= " ); ";
          $stmt = $this->db->pdo->prepare($query);
          $stmt->execute();

          $query = "ALTER TABLE `$name` ADD PRIMARY KEY (`id`)";
          $stmt = $this->db->pdo->prepare($query);
          $result = $stmt->execute();
//ALTER TABLE `device1` CHANGE `cur_time` `cur_time` TIMESTAMP(10) NULL DEFAULT NULL;
          $query= "ALTER TABLE `$name`  MODIFY id int(10)NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2";
          $stmt = $this->db->pdo->prepare($query);
          $stmt->execute();

           if ($result) {
             $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Success !</strong> bien !</div>';
           } else {
             echo "Error ALTER table: " . $con->error;
           }
     }

   }


   public function selectAllDeviceData(){
     $id =  Session::get('id');

     $sql = "SELECT * FROM tbl_device WHERE deviceid =$id ORDER BY id DESC";
     $stmt = $this->db->pdo->prepare($sql);
     $stmt->execute();
     return $stmt->fetchAll(PDO::FETCH_OBJ);
   }

   // Get Single User Information By Id Method
   public function getDeviceInfoById($deviceid){
     $sql = "SELECT * FROM tbl_device WHERE id = :id LIMIT 1";
     $stmt = $this->db->pdo->prepare($sql);
     $stmt->bindValue(':id', $deviceid);
     $stmt->execute();
     $result = $stmt->fetch(PDO::FETCH_OBJ);
     if ($result) {
       return $result;
     }else{
       return false;
     }


   }
}
