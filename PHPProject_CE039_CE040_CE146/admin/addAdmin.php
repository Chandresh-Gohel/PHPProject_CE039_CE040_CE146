<?php include_once "../templetes/header.php" ?>
<?php require_once "config/config.php" ?>
<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
  $user = "Welcome " . $_SESSION['user'];
} else {
  header('Location: ./../index.php');
}
if (isset($_POST['upgrade_user'])) {
  if (isset($_POST['user_id'])&&!empty($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $sql_verify_user = $con->prepare("UPDATE users set role='admin' where id=? ");
    $sql_verify_user->bindValue(1, $user_id, PDO::PARAM_STR);
    try{
      $sql_verify_user->execute();
      $sql_check_user=$con->prepare("SELECT * FROM users WHERE id='$user_id'");
      $sql_check_user->execute();
      $row_check_user=$sql_check_user->fetch(PDO::PARAM_STR);
      if(!empty($row_check_user)){
        echo "<script>alert('User ".$row_check_user['name']." \nUpgraded to Admin successfully')</script>";
      }
      else{
        echo "<script>alert('Error occured at time of updation')</script>";
      }
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }
}
else if(isset($_POST['delete_user'])){
  if (isset($_POST['user_id'])&&!empty($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $sql_verify_user = $con->prepare("DELETE FROM users where id=? ");
    $sql_verify_user->bindValue(1, $user_id, PDO::PARAM_STR);
    try{
      $sql_verify_user->execute();
      $sql_check_user=$con->prepare("SELECT * FROM users WHERE id='$user_id'");
      $sql_check_user->execute();
      $row_check_user=$sql_check_user->fetch(PDO::PARAM_STR);
      if(empty($row_check_user)){
        echo "<script>alert('User ".$row_check_user['name']." \nDeleted Successfully')</script>";
      }
      else{
        echo "<script>alert('Error occured at time of updation')</script>";
      }
    }
    catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }
}
?>

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
            <a class="nav-link dropdown-toggle" style="color: white;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
</br>
</br>
<div class="container text-center">
  <div class="row">
    <div class="position home_content">
      <h3 class="mb-3 bold">Users</h3>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col" class="text-center">User Name</th>
            <th scope="col" class="text-center">User Email</th>
            <th scope="col" class="text-center">User Role</th>
            <th scope="col" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php
            try {
              $sql_select = $con->prepare("SELECT * FROM users WHERE role!='admin' ORDER BY id DESC");
              $sql_select->execute();
              $rowuser = $sql_select->fetch(PDO::FETCH_ASSOC);
              while (!empty($rowuser)) {
            ?>
                <form method="POST">
                  <td><?php echo $rowuser['name']; ?></td>
                  <td><?php echo $rowuser['email']; ?></td>
                  <td>
                  <?php echo $rowuser['role']; ?></td>
                  <td> 
                  <input type="hidden" id="user_id" name="user_id" value="<?php echo $rowuser['id']; ?>">
                  <button type='submit' name='upgrade_user' class='btn btn-primary' id='upgrade_user' >Make Admin</button> &emsp;||&emsp; <button type='submit' name='delete_user' class='btn btn-primary' id='delete_user'><i class='fa fa-trash'></i></button></td>
                </form>
                </tr>
            <?php
              $rowuser = $sql_select->fetch(PDO::FETCH_ASSOC);
              }
            } catch (PDOException $e) {
              echo $e->getMessage();
              die();
            }
            ?>
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>
<?php include_once "templetes/footer.php" ?>
