<?php require_once "config/config.php";
session_start();
if (isset($_SESSION['user'])&&isset($_SESSION['user_role'])&&$_SESSION['user_role']=='admin') {
  $user = "Welcome ".$_SESSION['user'];
} else {
  session_destroy();
  header('Location: ./../index.php');
}
    $song_id=$_REQUEST['song_id'];
    $sql_del_song = $con->prepare("DELETE FROM songs WHERE id = ?");
    $sql_del_song->bindValue(1,$song_id,PDO::PARAM_STR);
    try{
        $sql_del_song->execute();
        $sqlcheck=$con->prepare("SELECT * FROM songs WHERE id='$song_id'");
        $sqlcheck->execute();
        $count=$sqlcheck->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo $e->getMessage();
        die();
      }
      if(empty($count)){
        echo "<script>alert('Song Deleted');</script>";
      }
      else{
        echo "Error Occured";
        print_r($con->errorInfo());
      }  
?>

