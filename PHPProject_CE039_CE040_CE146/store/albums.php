<?php include_once "templetes/header.php" ?>
<?php require_once "config/config.php" ?>

<?php
session_start();
if (isset($_SESSION['user'])) {
  $user = "Welcome ".$_SESSION['user'];
} else {
  session_destroy();
  header('Location: ./../index.php');
}

?>
<!-- ------------------------------------Start of Navbar------------------------------ -->

<!-- ------------------------------------Start of Navbar------------------------------ -->

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
          <a class="nav-link" href="allSongs.php">All Songs</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="albums.php">Albums</a>
        </li>
      </ul>
      <!---------------------------------------------CENTER-------------------------------->
      <<ul class="navbar-nav mr-auto ml-auto">
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2 ch_length" type="text" id="search_bar" maxlength="1" name="search_bar" placeholder="Search by song name or author or movie" aria-label="Search">
          <button class="btn btn-secondary my-2 my-sm-0" id="search_btn"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
        </ul>

        <!---------------------------------------------RIGHT------------------------------ -->
        <ul class="navbar-nav ml-auto">
          <!-- <li class="nav-item active">
        <a class="nav-link" href="#"><i class="fas fa-bell"></i></a>
      </li> -->
      <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" style="color: white;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $user; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="logout.php">Logout</a>
              
            </div>
          </li>
        </ul>
    </div>
  </div>
</nav>
</br>
</br>
<div class="container">
<p><h5>Filter By Category:</h5></p>
<form class="form-inline" method="POST" action="songsByCategory.php">
            <select class="form-control ch_length" name="album_category" id="album_category" style="max-width:70%;">
            <option value="CATEGORY" selected="selected">SELECT CATEGORY</option>
                <?php 
                $getcategories= $con->prepare("SELECT id,catname FROM category");
                try{
                $getcategories->execute();
                $rowCategories=$getcategories->fetch(PDO::FETCH_ASSOC);
                while(!empty($rowCategories)){
                ?>
                <option value="<?php echo $rowCategories['id'] ?>" length="90px"><?php echo $rowCategories['catname']?></option>
                <?php
              $rowCategories=$getcategories->fetch(PDO::FETCH_ASSOC); 
                  }
                 } catch (PDOException $e) {
                  echo $e->getMessage();
                  die();
                }?>
                </select>
                &emsp;
                <input type='hidden' name='filter_by_category' id='filter_by_category' value="<?php echo $rowCategories['id']; ?>" />
                <input type="submit" name="filter" id="filter" value="Filter">
            </ul>
    </form>
  <div class="col15">
  <p><h5>Album List</h5></p>
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th scope="col" class="text-center">Album</th>
          <th scope="col" class="text-center">Cover Page</th>
          <th scope="col" class="text-center">Category</th>
          <th scope="col" class="text-center">Singer</th>
          <th scope="col" class="text-center">Writer</th>
          <th scope="col" class="text-center">Description</th>
          <th scope="col" class="text-center">View Album</th>
        </tr>
      </thead>
      <tbody>
        <?php
        try {
          $getalbum = $con->prepare("SELECT * FROM album ORDER BY id DESC");
          $getalbum->execute();
          $rowalbum = $getalbum->fetch(PDO::FETCH_ASSOC);
          while (!empty($rowalbum)) {
            $album_cat_id = $rowalbum['albumcat'];
            try {
              $getalbumcat = $con->prepare("SELECT catname FROM category WHERE id='$album_cat_id'");
              $getalbumcat->execute();
              $rowalbumcat = $getalbumcat->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
              echo $e->getMessage();
              die();
            }
        ?>
            <?php
            echo "<tr>";
            echo "<td>" . $rowalbum['albumname'] . "</td>";
            echo "<td>" . "<img src='../admin/images/album/" . $rowalbum['albumimage'] . "' alt='" . $rowalbum['albumimage'] . "' width='50' height='40'/> </td>";
            echo "<td>" . $rowalbumcat['catname'] . "</td>";
            echo "<td>" . $rowalbum['albumsinger'] . "</td>";
            echo "<td>" . $rowalbum['albumwriter'] . "</td>";
            echo "<td>" . $rowalbum['albumdesc'] . "</td>";
            ?>
            <td>
              <a href="songsByAlbum.php?album_id=<?php echo $rowalbum['id']; ?>">Songs</a>
            </td>
        <?php
            echo "</tr>";
            $rowalbum = $getalbum->fetch(PDO::FETCH_ASSOC);
          }
        } catch (PDOException $e) {
          echo $e->getMessage();
          die();
        }
        ?>
      </tbody>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Search Result</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="search_result">        
      </div>
    </div>
  </div>
</div>
<?php include_once "templetes/footer.php" ?>
