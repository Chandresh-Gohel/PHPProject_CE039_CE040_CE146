<?php require_once "config/config.php";
header('Content-type: application/json');
session_start();
if (isset($_SESSION['user'])&&isset($_SESSION['user_role'])&&$_SESSION['user_role']=='admin') {
  $user = "Welcome ".$_SESSION['user'];
} else {
  session_destroy();
  header('Location: ./../index.php');
}
$album_id = isset($_POST['delete_album'])?$_POST['delete_album']:"0";
$sql_del_album = $con->prepare("DELETE FROM album WHERE id = ?");
$sql_del_album->bindValue(1,$album_id,PDO::PARAM_STR);
 try{
    $sql_del_album->execute();
    $sqlcheck=$con->prepare("SELECT * FROM album WHERE id='$album_id'");
    $sqlcheck->execute();
    $count=$sqlcheck->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo $e->getMessage();
    die();
  }
  if(empty($count)){
    $response_array['status']='success';
  }
  else{
    echo "Error Occured";
    print_r($con->errorInfo());
    $response_array['status']='fail';
  }  
  echo json_encode($response_array);
?>
