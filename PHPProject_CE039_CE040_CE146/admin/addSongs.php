<?php include_once "templetes/header.php"?>
<?php require_once "config/config.php" ?>
<?php
session_start();
if (isset($_SESSION['user'])&&isset($_SESSION['user_role'])&&$_SESSION['user_role']=='admin') {
  $user = "Welcome ".$_SESSION['user'];
} else {
  session_destroy();
  header('Location: ./../index.php');
}
if(isset($_POST['add_song']))
{
  $song_file = $_FILES['song_file']['name'];
  $song_file_temp = $_FILES['song_file']['tmp_name'];
  $song_name = $_POST['song_name'];
  $song_singer = $_POST['album_singer'];
  $song_writer = $_POST['album_writer'];
  $song_desc = implode("#", $_POST['song_search']);
  $song_cat = $_POST['song_cat'];
  $song_album= $_POST['song_album_id'];

  //move_uploaded_file($_FILES['txtimage']['tmp_name'], "images/album/".$_FILES['txtimage']['name']);
  move_uploaded_file($song_file_temp,"music/".$song_file);

  $sql_song = $con->prepare("INSERT INTO songs(songname,songcat,songalbum,songsinger,songdesc,songfile,songwriter) VALUES (?,?,?,?,?,?,?)");
  $sql_song->bindValue(1,$song_name,PDO::PARAM_STR);
  $sql_song->bindValue(2,$song_cat,PDO::PARAM_STR);
  $sql_song->bindValue(3,$song_album,PDO::PARAM_STR);
  $sql_song->bindValue(4,$song_singer,PDO::PARAM_STR);
  $sql_song->bindValue(5,$song_desc,PDO::PARAM_STR);
  $sql_song->bindValue(6,$song_file,PDO::PARAM_STR);
  $sql_song->bindValue(7,$song_writer,PDO::PARAM_STR);
    try{
      $sql_song->execute();
      $sqlcheck=$con->prepare("SELECT * FROM songs WHERE songname='$song_name'");
      $sqlcheck->execute();
      $count=$sqlcheck->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
      echo $e->getMessage();
      die();
    }
    if(!empty($count)){
      echo "<script>alert('Song Added');</script>";
    }
    else{
      echo "Error Occured";
      print_r($con->errorInfo());
    }
}
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
  <a class="navbar-brand" href="#">MusicMania</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<!-- -----------------------------------------------LEFT----------------------------------------------->
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="viewAlbum.php">Album Records</a>
      </li>
    </ul>
    <!---------------------------------------------CENTER-------------------------------->

    <!---------------------------------------------RIGHT------------------------------ -->
    <ul class="navbar-nav ml-auto">
      <!-- <li class="nav-item active">
        <a class="nav-link" href="#"><i class="fas fa-bell"></i></a>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" style="color: white;"  href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $user; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./album.php">Add Album</a>
          <a class="dropdown-item" href="./category.php">Categoey</a>
          <a class="dropdown-item" href="./addAdmin.php">Add Admin</a>
          <a class="dropdown-item" href="logout.php">Logout</a>
          
          
        </div>
      </li>
    </ul>
  </div>
  </div>
</nav>

    <div class="container text-center">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 position home_content">
            <?php
                $catId=$_GET['catId'];
                try{
                    $sql="SELECT album.id,album.albumname,album.albumsinger,album.albumwriter,category.catname,category.id FROM album,category WHERE album.albumcat = category.id AND album.id ='".$catId."'";
                    $getCat = $con->prepare($sql);
                    $getCat->execute();
                    $rowcat = $getCat->fetch(PDO::FETCH_ASSOC);
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                    die();
                }
            ?>
                <h3 class="mb-3 bold"><i class="fa fa-upload mb-3"></i> Add Songs</h3>
                <form id="albumform" method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                  <div class="col">
                    <label for="Song File">Song Name:</label>
               		<input type="text" class="form-control" name="song_name" id="song_name" required/> 
                  </div>
                  <div class="col">
                        <label >Song Category:</label>
                        <input type="hidden" class="form-control" value="<?php echo $rowcat['id']?>" />
                        <input type="text" class="form-control" value="<?php echo $rowcat['catname']?>" name="song_cat" id="song_cat" size="39" readonly="readonly"/>
                    </div>
                    <div class="col">
                      <label for="Album">Song Album:</label>
                      <input type="text" class="form-control" size="39" value="<?php echo $rowcat['albumname'] ;?>" readonly="readonly"/>
                      <input type="hidden" value="<?php echo $catId; ?>"  name="song_album_id" id="song_album_id"/>
                  </div>
                  </div>
                  <input type="hidden" class="form-control" name="id" value="<?php echo $rowcat['id']?>"/>
                  </br>
                  <div class="form-row">
                  <div class="col">
                    	<label for="Singer">Album Singer(s)</label>
                        <input type="text" class="form-control" name="album_singer" id="ambum_singer" value="<?php echo $rowcat['albumsinger']?>"  readonly="readonly" size="39"/>
                  </div>
                  <div class="col">
                    	<label for="Writer">Album Writer(s)</label>
                        <input type="text" class="form-control" name="album_writer" id="ambum_writer" value="<?php echo $rowcat['albumwriter']?>"  readonly="readonly" size="39"/>
                    </div>
                    </div>
                    </br>
                    <div class="form-row">
                    	<label for="Song Search">Description:</label>
                        <textarea class="form-control"  rows="6" cols="50" placeholder="Song Search" name="song_search[]" id="song_search" required></textarea>
                        </br>
                    </div>
                    <div class="form-row">
                        <label for="Song File">Song File:</label>
                        <div class="col">
               		        <input type="file" calss="form-control" name="song_file" id="song_file" required/>
                        </div>
                        </br>
                    </div>
                    </br>
                    <div class="form-row">
                    <div class="col">
                    	<input type="submit" class="form-control"  value="Add Song" id="add_song" name="add_song"/>
                    </div>
                    <div class="col">
                      <input type="reset" class="form-control"  value="Cancel" id="reset_song" name="reset_song"/>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include_once "templetes/footer.php"?>

