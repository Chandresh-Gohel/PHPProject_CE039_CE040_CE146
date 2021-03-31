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
if(isset($_POST['add_album']))
{
  $album_image = $_FILES['album_image']['name'];
  $album_temp_image = $_FILES['album_image']['tmp_name'];
  $album_name = $_POST['album_name'];
  $album_singer = $_POST['album_singer'];
  $album_writer = $_POST['album_writer'];
  $album_search = implode("#", $_POST['album_search']);
  $album_cat = $_POST['album_cat'];

  //move_uploaded_file($_FILES['txtimage']['tmp_name'], "images/album/".$_FILES['txtimage']['name']);
  move_uploaded_file($album_temp_image,"images/album/".$album_image);

  $sqlalbum = $con->prepare("INSERT INTO album(albumcat,albumname,
  albumsinger,albumwriter,albumdesc,albumimage) VALUES ('".$album_cat."','".$album_name."','".$album_singer."','".$album_writer."','".$album_search."','".$album_image."')");
    try{
      $sqlalbum->execute();
      $sqlcheck=$con->prepare("SELECT * FROM album WHERE albumname='$album_name'");
      $sqlcheck->execute();
      $count=$sqlcheck->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
      echo $e->getMessage();
      die();
    }
    if(!empty($count)){
      echo "<script>alert('Album Inserted');</script>";
    }
    else{
      echo "Error Occured";
      print_r($con->errorInfo());
    }
}
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <b class="navbar-brand" href="#">MusicMania</b>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- -----------------------------------------------LEFT----------------------------------------------->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
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
                <i class="fa fa-upload mb-3 fa-2x"></i>
                <h3 class="mb-3 bold">Add Album</h3>
                <form id="albumform" method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                  <div class="col">
                        <label >Album Cat:</label>
                        <select class="form-control" name="album_cat" id="album_cat" >
                        <option value="CATEGORY" selected="selected">SELECT CATEGORY</option>
                        <?php 
                        try{
                          $getCat = $con->prepare("SELECT id,catname FROM category");
                          $getCat->execute();
                          $rowcat = $getCat->fetch(PDO::FETCH_ASSOC);
                          while(!empty($rowcat)){
                        ?>
                        <option value="<?php echo $rowcat['id'] ?>"><?php echo $rowcat['catname']?></option>
                        <?php
                          $rowcat = $getCat->fetch(PDO::FETCH_ASSOC);
                          }
                        }
                        catch(PDOException $e){
                          echo $e->getMessage();
                          die();
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col">
                      <label for="Album">Album Name</label>
                      <input type="text" class="form-control"  name="album_name" id="album_name" placeholder="Album" size="39"/>
                  </div>
                  </div>
                  <div class="form-row">
                  <div class="col">
                    	<label for="Singer">Album Singer(s)</label>
                        <input type="text" class="form-control"  name="album_singer" id="album_singer"placeholder="Singer" size="39"/>
                  </div>
                  <div class="col">
                    	<label for="Writer">Album Writer(s)</label>
                        <input type="text" class="form-control"  name="album_writer" id="album_writer" placeholder="Writer" size="39"/>
                    </div>
                    </div>
                    <div class="form-row">
                    	<label for="Album Search">Album Search</label>
                        <textarea class="form-control"  rows="6" cols="50" placeholder="Album Search" name="album_search[]" id="album_search"></textarea>
                    </div>
                    <div class="form-row">
                    	<label for="Image">Album Cover</label>
                      <div class="col">
                        <input type="file" class="form-control"  name="album_image" id="album_image"/>
                      </div>
                    </div>
                    <div class="form-row">
                    <div class="col">
                    	<input type="submit" class="form-control"  value="Add Album" id="add_album" name="add_album"/>
                    </div>
                    <div class="col">
                      <input type="reset" class="form-control"  value="Cancel" id="reset_album" name="reset_album"/>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include_once "templetes/footer.php"?>

