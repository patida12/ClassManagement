<?php include './session.php';
      require_once './users.php';
      $link = DbConnection::getConnection();

      $cur_password = $password = $confirm_password = $email = $phonenumber = "";
      $cur_password_err = $password_err = $confirm_password_err = "";
      if (isset($_SESSION['id']))
      {
          $id = $_SESSION['id'];
          $user = User::getById($id);
          if(isset($_POST['btnSubmit']))
          {
              $link = DbConnection::getConnection();
              $id = $_POST['id'];
              $email = $_POST['email'];
              $phonenumber = $_POST['phonenumber'];
              
              // Validate current password
              if(empty(trim($_POST["cur_password"]))){
                $cur_password_err = "Please enter current password.";     
              } else{
                $cur_password = trim($_POST["cur_password"]);
                $isMatched= password_verify($cur_password, $user->getPassword());
                if(empty($cur_password_err) && !$isMatched){
                    $cur_password_err = "Password did not match.";
                }
              }

              // Validate new password
              if(empty(trim($_POST["password"]))){
                  $password_err = "Please enter a password.";     
              } elseif(strlen(trim($_POST["password"])) < 6){
                  $password_err = "Password must have atleast 6 characters.";
              } else{
                  $password = trim($_POST["password"]);
              }

              // Validate confirm password
              if(empty(trim($_POST["confirm_password"]))){
                  $confirm_password_err = "Please confirm password.";     
              } else{
                  $confirm_password = trim($_POST["confirm_password"]);
                  if(empty($password_err) && ($password != $confirm_password)){
                      $confirm_password_err = "Password did not match.";
                  }
              }

              // Check input errors
              if(empty($cur_password_err) && empty($password_err) && empty($confirm_password_err)){
                  $param_password = password_hash($password, PASSWORD_DEFAULT); 
                  $query = "UPDATE users SET password='$param_password', email='$email', phonenumber='$phonenumber' WHERE id='$id';";
                  
                  $result = mysqli_query($link,$query);
                  if ($result)
                  {
                      echo '<script>alert("Edit success!")</script>';
                      header('Location: index.php');
                  }
                  else 
                  {
                      echo '<script>alert("Edit fail!")</script>';
                      header('Location: index.php');
                  }
                  DbConnection::closeConnection($link);
              }
          }
      }
?>

<?php include './index.php'; ?>
</style>
<body class="link-tab">
<section>
<div class="tab-content" style="margin-right: 15%;">
  <div class="card">
    <div class="card-body">
      <div class="e-profile">
        <div class="row">
          <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
            <div class="text-center text-sm-left mb-2 mb-sm-0">
              <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo"{$user->getUserName()}"; ?></h4>
              <div class="mt-4">
              <a href="./logout.php">
              <button class="btn btn-block btn-secondary">
              <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
              </button>
              </a>
              </div>
            </div>
          </div>
        </div>
        <form class="form" novalidate="" action="#" method="post">
          <div class="row">
            <div class="col">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="phonenumber">Phone number: </label>
                    <input type="text" name="phonenumber" class="form-control" 
                        value="<?php echo $user->getPhoneNumber(); ?>" placeholder="Enter phone number...">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="email" class="form-control" name="email"
                        value="<?php echo $user->getEmail(); ?>" aria-describedby="emailHelpId"
                        placeholder="Enter email...">
                    <small id="emailHelpId" class="form-text text-muted">Help text</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6 mb-3">
              <div class="mb-2"><b>Change Password</b></div>
              <div class="row">
                <div class="col">
                  <div class="form-group <?php echo (!empty($cur_password_err)) ? 'has-error' : ''; ?>">
                    <label>Current Password</label>
                    <input type="password" name="cur_password" class="form-control" required>
                    <span style="color: red;" class="help-block"><?php echo $cur_password_err; ?></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>New Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <span style="color: red;" class="help-block"><?php echo $password_err; ?></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                    <span style="color: red;" class="help-block"><?php echo $confirm_password_err; ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
                <div class="form-group">
                  <input type="hidden" name="id" value="<?php echo $id; ?>" />
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col d-flex justify-content-end">
              <button name="btnSubmit" class="btn btn-primary" type="submit">Save Changes</button>
            </div>
          </div>
        </form>
      </div><a href="index.php"><button class="btn btn-primary">Back</button></a>
    </div>   
  </div>
</div>
</section>  
</body>

