<?php require_once "config/config.php";
header('Content-type: application/json');
session_start();
if (isset($_SESSION['user'])&&isset($_SESSION['user_role'])&&$_SESSION['user_role']=='admin') {
  $user = "Welcome ".$_SESSION['user'];
} else {
  session_destroy();
  header('Location: ./../index.php');
}
$cat_id = isset($_POST['delete_category'])?$_POST['delete_category']:"";
$sql_del_cat = $con->prepare("DELETE FROM category WHERE id = ?");
$sql_del_cat->bindValue(1,$cat_id,PDO::PARAM_STR);
try{
    $sql_del_cat->execute();
    $sqlcheck=$con->prepare("SELECT * FROM category WHERE id='$cat_id'");
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
