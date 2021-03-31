<?php include_once "templetes/header.php"?>
<?php require_once 'config/config.php'; ?>

<?php
if(isset($_POST['login_btn'])){
  $user_email=$_POST['login_email'];
  $user_pass=$_POST['login_pass'];
  try{
    $sql_select=$con->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $sql_select->bindValue(1,$user_email,PDO::PARAM_STR);
    $sql_select->bindValue(2,$user_pass,PDO::PARAM_STR);
    $sql_select->execute();
    $user_data = $sql_select->fetch(PDO::FETCH_ASSOC);
    if(!empty($user_data)){
      if($user_data['role']=='user'){
        session_start();
        $_SESSION['user']=$user_data['name'];
        $_SESSION['user_role']=$user_data['role'];
        header('Location: store/index.php');
      }
      else if($user_data['role']=='admin'){
        session_start();
        $_SESSION['user']=$user_data['name'];
        $_SESSION['user_role']=$user_data['role'];
        header('Location: admin/index.php');
      }
    }
    else{
      $message='<div class="alert alert-warning alert-danger" role="alert">
                  <strong>Warning!!</strong></br> Wrong login details
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
    }
  }
  catch(PDOException $e){
    echo $e->getMessage();
    die();
  }
}
?>







<!-- ----------------------Login Model -->
    <div class="container text-center">
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3 login_position">
            <i class="fab fa-napster mb-3 fa-4x"></i>
            <h3 class="mb-3 login_bold">Login to MusicMania</h3>
                <form action= <?php echo $_SERVER['PHP_SELF']; ?> method="POST">
                    <div class="form-group">
                        <input type="email" class="form-control" id="login_email" name="login_email" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text" ><i class="fas fa-lock"></i> We'll never share your email with anyone </small>
                        <span id="login_email_error" class="ch_error"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="login_pass" name="login_pass"placeholder="Password">
                        <span id="login_pass_error" class="ch_error"></span>
                    </div>
                    <input type="submit" class="btn btn-color btn-block" id="login_btn" name = "login_btn" value="Login"/>
                </form>
                <span class="float-left mt-1"><a href="javascript:void(0)" data-toggle="modal" data-target="#register">New To Here?</a></span>
                <span class="float-right mt-1"><a href="javascript:void(0)" data-toggle="modal" data-target="#forgot">Forgot Password</a></span></br></br>
                <?php echo @$message; ?>
            </div>
        </div>
    </div>

<!-- Register Modal -->
<div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fab fa-napster mb-3 fa-2x"></i> Register To MusicMania</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="register_model"> 
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
        <form id="register_form">
        <span id="not_match_error" class="ch_error"></span>
            <div class="form-group" style="text-align:left;">
                <input type="text" class="form-control" id="user_name" name= "user_name" aria-describedby="namewlHelp" placeholder="Enter Name">
                <span id="name_error" class="ch_error"></span>
            </div>
            <div class="form-group" style="text-align:left;">
                <input type="email" class="form-control" id="user_email" name="user_email"aria-describedby="emailHelp" placeholder="Enter email">
                <span id="email_error" class="ch_error"></span>
            </div>
            <div class="form-group" style="text-align:left;">
                <input type="password" class="form-control" id="userRegPass" name="userRegPass" placeholder="Password">
                <span id="password_error" class="ch_error"></span>
            </div>
            <div class="form-group" style="text-align:left;">
                <input type="password" class="form-control" id="user_confpass" name="user_confpass" placeholder="Confirm Password">
                <span id="confp_error" class="ch_error"></span>
            </div>
        </form>
        </div>
      </div>
      <div class="modal-footer">
      <p class="ch_left" id="message"></p>
        <button type="button" class="btn btn-primary" id="verify_ajax">Register</button>
        <button class="btn btn-primary" type="button" id="snipper" disabled>
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Please Wait...
        </button>
      </div>
    </div>
  </div>
</div>


<!-- Forgot Password Modal -->
<div class="modal fade" id="forgot" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fab fa-napster mb-3 fa-2x"></i> Frogot Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="forgot_pass_model">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
        <form id="forgot_form">
            <div class="form-group" style="text-align:left;">
                <input type="email" class="form-control" id="verify_email" name="verify_email" aria-describedby="emailHelp" placeholder="Enter email">
                <span id="email_error1" class="ch_error"></span>
            </div>
            <div class="form-group"  id= "pass_field" style="text-align:left;">
                <input type="password" class="form-control" id="verify_pass" name="verify_pass" placeholder="New Password">
                <span id="pass_error1" class="ch_error"></span>
            </div>
        </form>
        </div>
      </div>
      <div class="modal-footer">
      <p class="ch_left" id="message1"></p>
        <button type="button" class="btn btn-primary" id="email_btn">Verify</button>
        <button type="button" class="btn btn-primary" id="pass_btn">Change Password</button>
      </div>
    </div>
  </div>
</div>

<?php include_once "templetes/footer.php"?>
