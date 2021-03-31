<?php include_once "templetes/header.php" ?>
<?php require_once "config/config.php" ?>


<?php
session_start();
if (isset($_SESSION['user'])) {
  $user = "Welcome ".$_SESSION['user'];
} else {
  session_destroy();
  header('Location: ./../index.php');
} ?>
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
          <input class="form-control mr-sm-2 ch_length" type="text" maxlength="1" id="search_bar" name="search_bar" placeholder="Search by song name or author or movie" aria-label="Search">
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
<div class="container ml-5 mr-4">
  <table>
    <thead>
      <h2>New Released:</h2>
      </br>
    </thead>
    <tbody>
      <tr>
        <?php
        try {
          $sql_select = $con->prepare("SELECT * FROM album ORDER BY id DESC LIMIT 4");
          $sql_select->execute();
          $rowalbum = $sql_select->fetch(PDO::FETCH_ASSOC);
          while (!empty($rowalbum)) {
            // $albumid=$rowcat['songalbum'];   
        ?>
            <td>
              <div class="card p-3 ml-2 mr-2" style="width: 20rem;">
                <img class="card-img-top" src="../admin/images/album/<?php echo $rowalbum['albumimage']; ?>" alt="Card image cap" style="width: 130px; height:120px;" />
                <div class="card-body">
                  <h5 class="card-title">Album:&emsp;<a href="songsByAlbum.php?album_id=<?php echo $rowalbum['id']; ?>"><?php echo $rowalbum['albumname']; ?></a>
                    <h5>
                      <p class="card-text">Writer:&emsp;<?php echo $rowalbum['albumwriter']; ?>
                    </h5>
                    </p>
                    <h5>
                      <p class="card-text">Singer:&emsp;<?php echo $rowalbum['albumsinger']; ?>
                    </h5>
                    </p>
                </div>
              </div>
            </td>
        <?php
            $rowalbum = $sql_select->fetch(PDO::FETCH_ASSOC);
          }
        } catch (PDOException $e) {
          echo $e->getMessage();
          die();
        }
        ?>
      </tr>
    <tbody>
  </table>
  </br>
  </br>
  </br>
  <h3>New Songs</h3>
  </br>
  </br>
</div>
<div class="container">
  <div class="row">
    <div class=""></div>
    <div class="">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col" class="text-center">Song</th>
            <th scope="col" class="text-center">Cover Page</th>
            <th scope="col" class="text-center">Category</th>
            <th scope="col" class="text-center">Album</th>
            <th scope="col" class="text-center">Singer</th>
            <th scope="col" class="text-center">Writer</th>
            <th scope="col" class="text-center">Description</th>
            <th scope="col" class="text-center">Play</th>
          </tr>
        </thead>
        <tbody>
          <?php
          try {
            $getsong = $con->prepare("SELECT * FROM songs ORDER BY id DESC LIMIT 10");
            $getsong->execute();
            $rowsong = $getsong->fetch(PDO::FETCH_ASSOC);
            while (!empty($rowsong)) {
              $song_album_id = $rowsong['songalbum'];
              try {
                $getsongalbum = $con->prepare("SELECT albumname,albumimage FROM album WHERE id='$song_album_id'");
                $getsongalbum->execute();
                $rowsongalbum = $getsongalbum->fetch(PDO::FETCH_ASSOC);
              } catch (PDOException $e) {
                echo $e->getMessage();
                die();
              }
          ?>
              <?php
              echo "<tr>";
              echo "<td>" . $rowsong['songname'] . "</td>";
              echo "<td>" . "<img src='../admin/images/album/" . $rowsongalbum['albumimage'] . "' alt='" . $rowsongalbum['albumimage'] . "' width='50' height='40'/> </td>";
              echo "<td>" . $rowsong['songcat'] . "</td>";
              echo "<td>" . $rowsongalbum['albumname'] . "</td>";
              echo "<td>" . $rowsong['songsinger'] . "</td>";
              echo "<td>" . $rowsong['songwriter'] . "</td>";
              echo "<td>" . $rowsong['songdesc'] . "</td>";
              ?>
              <td>
                <audio controls>
                  <source src="../admin/music/<?php echo $rowsong['songfile']; ?>" type="audio/mpeg">
                  </source>
                </audio>
              </td>
          <?php
              echo "</tr>";
              $rowsong = $getsong->fetch(PDO::FETCH_ASSOC);
            }
          } catch (PDOException $e) {
            echo $e->getMessage();
            die();
          }
          ?>
        </tbody>
    </div>
  </div>
</div>
</div>
</table>
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
