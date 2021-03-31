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
                <h3 class="mb-3 bold">Categories</h3>
                <table class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try{
                          $getCat = $con->prepare("SELECT * FROM category");
                          $getCat->execute();
                          $rowcat = $getCat->fetch(PDO::FETCH_ASSOC);
                          while(!empty($rowcat)){
                        ?>
                        <?php
                          echo "<tr>";
                            echo "<td>".$rowcat['id']."</td>";
                            echo "<td>".$rowcat['catname']."</td>";
                            echo "<td>".$rowcat['catdesc']."</td>";
                            echo "<td>"."<img src='images/category/".$rowcat['catimage']."' alt='".$rowcat['catimage']."' width='40' height='50'/> </td>";
                            echo "<td>"."<a href='editCategory.php?catId=".$rowcat['id']."'>Edit</a> || 
                            <button type='button' name='delete_category' class='btn' id='delete_category' value=".$rowcat['id']."><i class='fa fa-trash'></i></button>"."</td>";
                          echo "</tr>";
                          $rowcat = $getCat->fetch(PDO::FETCH_ASSOC);
                          }
                        }
                        catch(PDOException $e){
                          echo $e->getMessage();
                          die();
                        }
                        ?>
                </tbody>
            </div>
        </div>
    </div>

<?php include_once "templetes/footer.php"?>
