<?php
    header('Content-type: application/json');
    require_once '../config/config.php';

    $user_email= $_POST['verify_email'];
    $sql_verify=$con->prepare("SELECT * FROM users WHERE email='$user_email'");
    $sql_verify->execute();
    $result = $sql_verify->fetch(PDO::FETCH_ASSOC);
    if(!empty($result)){
        $response_array['status']='success';
    }
    else{
        $response_array['status']='fail';
    }
    echo json_encode($response_array);

?>
