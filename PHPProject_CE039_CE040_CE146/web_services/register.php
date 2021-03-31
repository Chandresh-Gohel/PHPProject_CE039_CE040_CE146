<?php
header('Content-type: application/json');
require_once '../config/config.php';
$user=$_POST['user_name'];
$email=$_POST['user_email'];
$password=$_POST['userRegPass'];

$sql_verify=$con->prepare("SELECT * FROM users WHERE email='$email'");
$sql_verify->execute();
$result = $sql_verify->fetch(PDO::FETCH_ASSOC);
if(!empty($result)){
    $response_array['status']='fail';
}
else{
    $sql_insert=$con->prepare("INSERT INTO users(name,email,password,role) VALUES(?,?,?,'user')");
    $sql_insert->bindValue(1,$user,PDO::PARAM_STR);
    $sql_insert->bindValue(2,$email,PDO::PARAM_STR);
    $sql_insert->bindValue(3,$password,PDO::PARAM_STR);
    try{
        $sql_insert->execute();
        $response_array['status']='success';
    }
    catch(PDOException $e){
        echo $e->getMessage();
        die();
    }
}
echo json_encode($response_array);
?>
