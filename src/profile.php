<?php include './session.php';
      require_once './users.php';
      $conn = DbConnection::getConnection();

      $cur_password = $password = $confirm_password = $email = $phonenumber = "";
      $cur_password_err = $password_err = $confirm_password_err = "";
      if (isset($_SESSION['id']))
      {
          $id = $_SESSION['id'];
          $user = User::getById($id);
          $count = 0;
          $query = "SELECT COUNT(isRead) as count FROM mbox WHERE isRead=false AND idReceiver=$id GROUP BY isRead";
          $result = $conn->query($query);

          if($result) {
              while($row = $result->fetch_assoc()) {
                  $count = $row['count'];
              }
          }
          if(isset($_POST['btnSubmit']))
          {
              $conn = DbConnection::getConnection();
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
                  
                  $result = mysqli_query($conn,$query);
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
                  DbConnection::closeConnection($conn);
              }
          }
      }
?>

<?php include './index.php'; ?>
</style>
<body>
<section>
<div class="tab-content" style="margin-right: 15%;">
  <div class="card">
    <div class="card-body">
      <div class="e-profile">
        <div class="row">
          <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
            <div class="text-center text-sm-left mb-2 mb-sm-0">
              <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo"{$user->getUserName()}"; ?></h4>
              <div class="mt-2">
              <i class="fa fa-inbox fa-2x btn" data-toggle='modal' data-target='#myModal'></i>
              <span class="badge"><?php echo $count; ?></span>
              <div class="modal" id="myModal">
                <div class="modal-dialog">
                <div class="modal-content">
                
                    <div class="modal-header" style="background-color: blue; color: white;">
                    <h4 class="modal-title">Inbox</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                    <?php
                    $conn = DbConnection::getConnection();
                      $query = "SELECT idSender, COUNT(isRead) as otherCount FROM mbox WHERE isRead=false AND idReceiver=$id GROUP BY idSender";
                      $result = $conn->query($query);
              
                      if($result) {
                          while($rowSender = $result->fetch_assoc()) {
                              $idSender = $rowSender['idSender'];
                              $user = User::getById($idSender);
                              $sender = $user->getUserName();
                              $otherCount = $rowSender['otherCount'];
                              echo '<div class="row" style="font-size: 30px;">';
                              echo '<strong>' . $sender . '</strong><span style="color: red;">('.$otherCount.')</span>';
                    ?>
                              <form action="sendMess.php" id="form_upload" method="POST">   
                                  <input type="hidden" name="idSender" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $id; ?>" />
                                  <input type="hidden" name="idReceiver" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $idSender; ?>" />
                                  <input type="hidden" name="nameReceiver" style="margin-top: 1%; margin-bottom: 1%;" value="<?php echo $sender; ?>" />
                                  <input type="submit" name="submit" value="Read" class="btn btn-primary btn-sm"><br>
                              </form>
                            </div>
                    <?php
                            }
                      }
                      DbConnection::closeConnection($conn);
                    ?>
                    
                    </div>                    
                </div>
                </div>
            </div>
              </div>
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

