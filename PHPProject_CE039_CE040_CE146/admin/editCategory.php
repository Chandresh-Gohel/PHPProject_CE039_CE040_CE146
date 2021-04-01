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
if(isset($_POST['edit_cat']))
{
  $cat_image = $_FILES['cat_image']['name'];
  $cat_temp_image = $_FILES['cat_image']['tmp_name'];
  $cat_name = $_POST['cat_name'];
  $cat_id=$_POST['cat_id'];
  $cat_desc = implode("#", $_POST['cat_desc']);

  //move_uploaded_file($_FILES['txtimage']['tmp_name'], "images/album/".$_FILES['txtimage']['name']);
  move_uploaded_file($cat_temp_image,"images/category/".$cat_image);

  $sqlcat = $con->prepare("UPDATE category set catname=?,catdesc=?,catimage=? WHERE id=?");$sqlcat->bindValue(1,$cat_name,PDO::PARAM_STR);
  $sqlcat->bindValue(2,$cat_desc,PDO::PARAM_STR);
  $sqlcat->bindValue(3,$cat_image,PDO::PARAM_STR);
  $sqlcat->bindValue(4,$cat_id,PDO::PARAM_STR);
    try{
      $sqlcat->execute();
      $sqlcheck=$con->prepare("SELECT * FROM category WHERE catname='$cat_name'");
      $sqlcheck->execute();
      $count=$sqlcheck->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
      echo $e->getMessage();
      die();
    }
    if(!empty($count)){
      echo "<script>alert('Category edited successfully');</script>";
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
          <a class="nav-link" href="allSongsAdmin.php">All Songs</a>
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
                <!-- <i class="fa fa-upload mb-3 fa-2x"></i> -->
                <?php
                $catId=$_GET['catId'];
                try{
                    $getCat = $con->prepare("SELECT * FROM category WHERE id='$catId'");
                    $getCat->execute();
                    $rowcat = $getCat->fetch(PDO::FETCH_ASSOC);
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                    die();
                }
                if(!empty($rowcat)){
                ?>
                <h3 class="mb-3 bold">Category</h3>
                <form id="catform" method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                        <label >Song Category:</label>
                        <input type="text" class="form-control"  name="cat_name" id="cat_name" placeholder="<?php echo $rowcat['catname']; ?>" value="<?php echo $rowcat['catname']; ?>" size="39" readonly="readonly"/>
                        <input type="hidden"  name="cat_id" id="cat_id" value="<?php echo $catId; ?>"/>
                    </div>
                    <div class="form-row">
                    	<label for="Album Search">Category Description:</label>
                        <textarea class="form-control"  rows="6" cols="50" name="cat_desc[]" id="cat_desc" required><?php echo $rowcat['catdesc']; ?></textarea>
                    </div>
                    <div class="form-row">
                    	<label for="Image">Category Baner</label>
                      <div class="col">
                        <input type="file" class="form-control"  name="cat_image" id="cat_image" required/>
                      </div>
                    </div>
                    <div class="form-row">
                    <div class="col">
                    	<input type="submit" class="form-control"  value="Edit Category" id="edit_cat" name="edit_cat"/>
                    </div>
                    <div class="col">
                      <input type="reset" class="form-control"  value="Cancel" id="reset_cat" name="reset_cat"/>
                    </div>
                    </div>
                </form>
                <?php
                }
                else{
                    echo "Error Occured";
                    print_r($con->errorCode());
                }
                ?>
                
            </div>
        </div>
    </div>

<?php include_once "templetes/footer.php"?>
