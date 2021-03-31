<?php
    header('Content-type: application/json');
    require_once '../config/config.php';

    $user_email= $_POST['verify_email'];
    $user_pass= $_POST['verify_pass'];
    $sql_verify=$con->prepare("SELECT * FROM users WHERE email='$user_email'");
    $sql_verify->execute();
    $result = $sql_verify->fetch(PDO::FETCH_ASSOC);
    if(!empty($result)){
        $sql_update=$con->prepare("UPDATE users SET password=? WHERE email=?");
        $sql_update->bindValue(1,$user_pass,PDO::PARAM_STR);
        $sql_update->bindValue(2,$user_email,PDO::PARAM_STR);
        try{
            $sql_update->execute();
            $response_array['status']='success';
        }
        catch(PDOException $e){
            echo $e->getMessage();
            die();
        }
    }
    else{
        $response_array['status']='fail';
    }
    echo json_encode($response_array);

?>
