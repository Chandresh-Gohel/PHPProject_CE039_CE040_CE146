<?php
require_once 'config/config.php';
session_start();
if (isset($_SESSION['user'])) {
  $user = "Welcome ".$_SESSION['user'];
} else {
  session_destroy();
  header('Location: ./../index.php');
}
$search_key=$_POST['search_key'];
$getalbums=$con->prepare("SELECT * FROM album WHERE albumdesc LIKE '$search_key%'");
if(!ctype_space($search_key)&&!empty($search_key)){
try{
$getalbums->execute();
$rowAlbums=$getalbums->fetch(PDO::FETCH_ASSOC);
if(!empty($rowAlbums)){
while(!empty($rowAlbums)){
    echo "&emsp;<img src='./images/album/".$rowAlbums['albumimage']."' height='100px' width='80px'/>&nbsp;&nbsp;&emsp;";
    echo "Album:&emsp;<a href=songsByAlbum.php?album_id=".$rowAlbums['id'].">".$rowAlbums['albumname']."</a>";
    echo "</br>";
    $rowAlbums=$getalbums->fetch(PDO::FETCH_ASSOC);
}
}
else{
    echo "<p class='danger'> No result found with keyword: ".$search_key."</p>";
}
}
catch(PDOException $e){
    echo $e->getMessage();
    die();
  }
}
else{
  echo "<p class='danger'> Nothing Mentioned </p>";
}
?>        


